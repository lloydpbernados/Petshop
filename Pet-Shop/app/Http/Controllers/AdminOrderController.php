<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Activity;
use App\Mail\OrderStatusMail;          // ← ADD
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;   // ← ADD
use Illuminate\Support\Facades\Log; // ← ADD THIS LINE

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
                'date'     => ($o->ordered_at ?? $o->created_at)->format('M j, Y'),
                'items'    => $o->items->map(fn($i) => [
                    'name'  => $i->item_name,
                    'icon'  => $i->icon,
                    'qty'   => $i->quantity,
                    'price' => $i->price,
                ]),
            ]);

        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        $transitions = [
            'pending' => 'to-ship',
            'to-ship' => 'completed',
        ];

        $newStatus = $transitions[$order->status] ?? null;

        if (!$newStatus) {
            return response()->json(['error' => 'No further transitions allowed.'], 422);
        }

        $order->update(['status' => $newStatus]);

        // ── Send email notification to customer ──────────────────
       try {
            Mail::to($order->email)->send(new OrderStatusMail($order, $newStatus));
        } catch (\Exception $e) {
            // Don't fail the request if mail fails — just log it
            Log::error('Order status email failed: ' . $e->getMessage()); // ← REMOVE the \ before Log
        }
        
        // ── Log to activity feed ─────────────────────────────────
        $icon   = $newStatus === 'to-ship' ? '🛒' : '📦';
        $detail = $newStatus === 'to-ship'
            ? "Order #{$order->order_number} approved and ready to pack."
            : "Order #{$order->order_number} shipped to {$order->customer_name}.";

        Activity::log('Order', $order->customer_name, $detail, ucfirst($newStatus), $icon);

        return response()->json([
            'success'    => true,
            'new_status' => $newStatus,
            'order'      => $order->order_number,
        ]);
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
            fn($r) => implode(',', array_map(fn($v) => '"'.$v.'"', $r)),
            $rows
        ));

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pawhaven-orders.csv"',
        ]);
    }
}