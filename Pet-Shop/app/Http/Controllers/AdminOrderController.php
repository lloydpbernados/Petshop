<?php
// app/Http/Controllers/AdminOrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pet;
use App\Models\Supply;
use App\Models\Activity;
use App\Mail\OrderStatusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->latest('created_at')
            ->get()
            ->map(fn($o) => [
                'id'       => $o->order_number,
                'status'   => $o->status,
                'customer' => $o->customer_name,
                'email'    => $o->email,
                'date'     => ($o->ordered_at ?? $o->created_at)->format('M j, Y'),
                // Separate supply/pet items from service bookings
                'items'    => $o->items->where('item_type', '!=', 'service')->map(fn($i) => [
                    'name'      => $i->item_name,
                    'icon'      => $i->icon,
                    'qty'       => $i->quantity,
                    'price'     => $i->price,
                    'item_type' => $i->item_type,
                ])->values(),
                // Service bookings as a separate list
                'bookings' => $o->items->where('item_type', 'service')->map(fn($i) => [
                    'name'         => $i->item_name,
                    'icon'         => $i->icon,
                    'price'        => $i->price,
                    'scheduled_at' => $i->scheduled_at?->format('M j, Y'),
                ])->values(),
                'has_physical' => $o->items->where('item_type', '!=', 'service')->count() > 0,
                'has_booking'  => $o->items->where('item_type', 'service')->count() > 0,
            ]);

        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        $transitions = [
            'pending' => 'to-ship',
            'to-ship' => 'shipped',
            'shipped' => 'completed',
        ];

        // Service-only orders skip the shipping steps entirely:
        // pending → completed (nothing to ship)
        $isServiceOnly = $order->items->every(fn($i) => $i->item_type === 'service');
        if ($isServiceOnly) {
            $transitions = ['pending' => 'completed'];
        }

        $newStatus = $transitions[$order->status] ?? null;

        if (!$newStatus) {
            return response()->json(['error' => 'No further transitions allowed.'], 422);
        }

        DB::transaction(function () use ($order, $newStatus) {
            // Deduct stock only when pending → to-ship
            if ($order->status === 'pending') {
                foreach ($order->items as $item) {
                    if ($item->item_type === 'pet' && $item->source_id) {
                        Pet::where('id', $item->source_id)
                           ->where('stock', '>=', $item->quantity)
                           ->decrement('stock', $item->quantity);
                    } elseif ($item->item_type === 'supply' && $item->source_id) {
                        Supply::where('id', $item->source_id)
                              ->where('stock', '>=', $item->quantity)
                              ->decrement('stock', $item->quantity);
                    }
                    // service → no stock to deduct
                }
            }

            $order->update(['status' => $newStatus]);
        });

        // Email the customer
        try {
            Mail::to($order->email)->send(new OrderStatusMail($order, $newStatus));
        } catch (\Exception $e) {
            Log::error('Order status email failed: ' . $e->getMessage());
        }

        $activityMap = [
            'to-ship'   => ['🛒', "Order #{$order->order_number} approved — ready to pack."],
            'shipped'   => ['🚚', "Order #{$order->order_number} shipped to {$order->customer_name}."],
            'completed' => ['📦', "Order #{$order->order_number} delivered to {$order->customer_name}."],
        ];

        [$icon, $detail] = $activityMap[$newStatus]
            ?? ['📋', "Order #{$order->order_number} updated to {$newStatus}."];

        Activity::log('Order', $order->customer_name, $detail, ucfirst($newStatus), $icon);

        return response()->json([
            'success'    => true,
            'new_status' => $newStatus,
            'order'      => $order->order_number,
        ]);
    }
    public function cancelOrder(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                    ->where('status', 'pending') // only pending can be cancelled
                    ->firstOrFail();

        $order->update(['status' => 'cancelled']);

        // Notify customer
        try {
            Mail::to($order->email)->send(new OrderStatusMail($order, 'cancelled'));
        } catch (\Exception $e) {
            Log::error('Cancel email failed: ' . $e->getMessage());
        }

        Activity::log('Order', $order->customer_name, 
            "Order #{$order->order_number} was cancelled.", 'Cancelled', '❌');

        return response()->json(['success' => true, 'new_status' => 'cancelled']);
}
    public function exportCsv()
    {
        $orders = Order::with('items')->get();
        $rows   = [['Order #', 'Customer', 'Email', 'Status', 'Items', 'Total', 'Date']];

        foreach ($orders as $o) {
            $itemList = $o->items->map(fn($i) => "{$i->item_name} x{$i->quantity}")->implode('; ');
            $rows[] = [
                $o->order_number,
                $o->customer_name,
                $o->email,
                $o->status,
                $itemList,
                $o->grand_total,
                ($o->ordered_at ?? $o->created_at)->format('Y-m-d'),
            ];
        }

        $csv = implode("\n", array_map(
            fn($r) => implode(',', array_map(fn($v) => '"' . $v . '"', $r)),
            $rows
        ));

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pawhaven-orders.csv"',
        ]);
    }
}