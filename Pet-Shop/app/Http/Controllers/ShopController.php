<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // 🐾 Import the Order model

class ShopController extends Controller
{
    /**
     * Display the main shop storefront page.
     */
    public function index()
    {
        // Restores the original function so your shop load isn't broken
        return view('customer.shop');
    }

    /**
     * Handle the checkout submission for a guest order.
     */
    public function checkout(Request $request)
    {
        // 1. Validate the form data coming from the checkout process
        $request->validate([
            'email'         => 'required|email',
            'customer_name' => 'required|string|max:255',
            'item_name'     => 'required|string|max:255',
            'price'         => 'required|numeric',
        ]);

        // 2. Create and save the order row to the database table
        $order = new Order();
        $order->email = $request->email;
        $order->customer_name = $request->customer_name;
        $order->item_name = $request->item_name;
        $order->price = $request->price;
        $order->status = 'Pending'; // Default status for your tracker
        $order->save(); // 💾 This automatically generates the unique Order ID number!

        // 3. Send them to the success page with their new order number
        return redirect()->route('shop.success')->with([
            'order_id' => $order->id,
            'success'  => 'Your order has been placed successfully!'
        ]);
    }

    /**
     * Display the order confirmation/success screen.
     */
    public function showSuccess()
    {
        return view('customer.success');
    }
}