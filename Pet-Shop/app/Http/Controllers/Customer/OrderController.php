<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show the authenticated user's order history.
     * Only completed orders are shown (you can remove the status filter
     * if you want ALL orders regardless of status).
     */
    public function history()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            // Remove the line below if you want ALL statuses shown
            ->whereIn('status', ['completed', 'shipped', 'to-ship', 'processing', 'pending', 'cancelled'])
            ->latest('ordered_at')
            ->get();

        return view('order-history', compact('orders'));
    }
}