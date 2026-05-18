<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderTrackingController extends Controller
{
    /**
     * Display the tracking entry form view.
     */
    public function showForm()
    {
        return view('customer.track-order');
    }

    /**
     * Query the order and return results or bounce back with an error.
     */
    public function track(Request $request)
    {
        // 1. Validate Form Input Fields
        $request->validate([
            'order_id' => [
                'required',
                'string',
                'max:50',
                'regex:/^PH-[A-Z0-9]+-\d+$/i' // Matches format: PH-XXXXXXX-XXXX
            ],
            'email' => 'required|email|max:255'
        ], [
            'order_id.regex' => 'Please enter a valid Order ID (e.g., PH-MPATB538-5850)'
        ]);

        // 2. Normalize input for consistent database lookup
        $orderId = strtoupper(trim($request->order_id));
        $email = strtolower(trim($request->email));

        // 3. Query DB to look for a matching guest order record
        //    ⚠️ Ensure your 'orders' table has a VARCHAR 'order_id' column (not just the auto-increment 'id')
        $order = DB::table('orders')
                    ->where('order_id', $orderId) // ✅ Changed from 'id' to 'order_id'
                    ->where('email', $email)
                    ->first();

        // 4. Fallback if order cannot be found
        if (!$order) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'We couldn\'t find an order matching that Order ID and Email address. Please check your confirmation email and try again.');
        }

        // 5. Return results view along with the matched record details
        return view('customer.track-result', compact('order'));
    }
}