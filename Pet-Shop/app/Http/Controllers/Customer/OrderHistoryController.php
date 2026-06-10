<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $orders = Order::with('items')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('customer.order-history', compact('orders'));
    }
}