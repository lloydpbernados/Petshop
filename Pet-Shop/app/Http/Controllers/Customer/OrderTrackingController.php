<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Show the order tracking entry form.
     * Route: GET /track   (name: order.track.form)
     */
    public function form()
    {
        return view('customer.track-order');
    }

    /**
     * Validate submitted credentials and redirect to the result page.
     * Route: POST /track/search   (name: order.track.search)
     */
    public function search(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string|max:50',
            'email'    => 'required|email|max:255',
        ]);

        $orderNumber = strtoupper(trim($request->order_id));
        $email       = strtolower(trim($request->email));

        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('email', $email)
            ->first();

        if (! $order) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'We couldn\'t find an order matching that Order ID and email address. Please check your confirmation email and try again.');
        }

        session([
            'tracked_order_number' => $order->order_number,
            'tracked_email'        => $email,
        ]);

        return redirect()->route('order.track.result', $order->order_number);
    }

    /**
     * AJAX endpoint for modal tracking (no redirect)
     * Route: POST /track/ajax   (name: order.track.ajax)
     */
    public function ajaxSearch(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string|max:50',
            'email'    => 'required|email|max:255',
        ]);

        $orderNumber = strtoupper(trim($request->order_id));
        $email       = strtolower(trim($request->email));

        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('email', $email)
            ->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'We couldn\'t find an order matching that Order ID and email address.'
            ], 404);
        }

        // Compute order data for modal display
        $orderTotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
        $itemNames  = $order->items->pluck('item_name')->implode(', ');

        $statusColors = [
            'pending'    => '#f59e0b',
            'processing' => '#3b82f6',
            'to-ship'    => '#8b5cf6',
            'shipped'    => '#8b5cf6',
            'completed'  => '#10b981',
            'delivered'  => '#10b981',
            'cancelled'  => '#ef4444',
        ];
        $statusColor = $statusColors[strtolower($order->status)] ?? '#6b7280';

        $orderedAt = $order->ordered_at ?? $order->created_at;
        $statusLower = strtolower($order->status);

        return response()->json([
            'success' => true,
            'order' => [
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'email' => $order->email,
                'shipping_address' => $order->shipping_address,
                'status' => ucfirst($order->status),
                'status_color' => $statusColor,
                'ordered_at' => \Carbon\Carbon::parse($orderedAt)->format('M d, Y h:i A'),
                'tracking_notes' => $order->tracking_notes,
                'total' => number_format($orderTotal, 2),
                'items' => $order->items->map(fn($i) => [
                    'name' => $i->item_name,
                    'icon' => $i->icon ?? '📦',
                    'quantity' => $i->quantity,
                    'price' => number_format($i->price * $i->quantity, 2),
                ]),
                'timeline' => [
                    'processing' => in_array($statusLower, ['processing', 'to-ship', 'shipped', 'completed', 'delivered']),
                    'shipped' => in_array($statusLower, ['to-ship', 'shipped', 'completed', 'delivered']),
                    'delivered' => in_array($statusLower, ['completed', 'delivered']),
                ]
            ]
        ]);
    }

    /**
     * Display the full order status & timeline (page view).
     * Route: GET /track/{number}   (name: order.track.result)
     */
    public function result(string $number)
    {
        if (session('tracked_order_number') !== strtoupper($number)) {
            return redirect()
                ->route('order.track.form')
                ->with('error', 'Please search for your order before viewing results.');
        }

        $order = Order::with('items')
            ->where('order_number', strtoupper($number))
            ->firstOrFail();

        return view('customer.track-result', compact('order'));
    }
}