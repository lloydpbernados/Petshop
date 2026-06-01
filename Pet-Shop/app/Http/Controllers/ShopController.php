<?php

// ──────────────────────────────────────────────────────────────────────────
// app/Http/Controllers/ShopController.php
// ──────────────────────────────────────────────────────────────────────────

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Activity;
use App\Models\Pet;
use App\Models\Supply;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    // ── Public shop / catalog page ────────────────────────────────────────
    public function index()
    {
        $pets = Pet::where('available', true)->get()->map(fn($p) => [
            'id'         => 'pet-' . $p->id,
            'name'       => $p->name,
            'emoji'      => $p->emoji,
            'image'      => $p->image_path ? Storage::url($p->image_path) : null,  // ← ADD
            'category'   => $p->category,
            'type'       => 'pet',
            'price'      => $p->price,
            'badge'      => $p->badge,
            'badgeLabel' => $p->badge_label,
            'desc'       => $p->description,
            'available'  => $p->stock > 0,
        ]);

        $supplies = Supply::where('available', true)->get()->map(fn($s) => [
            'id'         => 'supply-' . $s->id,
            'name'       => $s->name,
            'emoji'      => $s->emoji,
            'image'      => $s->image_path ? Storage::url($s->image_path) : null,  // ← ADD
            'category'   => $s->category,
            'type'       => 'product',
            'price'      => $s->price,
            'badge'      => $s->badge,
            'badgeLabel' => $s->badge_label,
            'desc'       => $s->description,
            'available'  => $s->stock > 0,
        ]);

        $services = Service::active()->get()->map(fn($s) => [
            'id'         => 'service-' . $s->id,
            'name'       => $s->name,
            'emoji'      => $s->icon,
            'image'      => null,                                                    
            'category'   => $s->category ?? 'Services',
            'type'       => 'service',
            'price'      => $s->price,
            'badge'      => $s->badge,
            'badgeLabel' => $s->badge_label,
            'desc'       => $s->description,
            'available'  => $s->available,
        ]);

        $catalog = $pets->concat($supplies)->concat($services)->values();

        return view('shop', compact('catalog'));
    }

    // ── SEND OTP ──────────────────────────────────────────────────────────
    //  POST /shop/otp/send
    //  Body: { email, name }
    //  Generates a 6-digit OTP, stores it in the session with a 10-min
    //  expiry, then emails it. Returns JSON { success: true }.
    // ─────────────────────────────────────────────────────────────────────
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name'  => 'nullable|string|max:255',
        ]);

        // Generate a cryptographically random 6-digit OTP
        $otp  = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $name = $request->input('name', 'Customer');

        // Store in session: OTP + expiry timestamp + the email it was sent to
        Session::put('otp_data', [
            'code'    => $otp,
            'email'   => $request->email,
            'expires' => now()->addMinutes(10)->timestamp,
        ]);

        // Send the email
        Mail::to($request->email)
            ->send(new OtpMail($otp, $name));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to ' . $request->email,
        ]);
    }

    // ── VERIFY OTP ────────────────────────────────────────────────────────
    //  POST /shop/otp/verify
    //  Body: { email, otp }
    //  Returns JSON { success: true } or { success: false, message: '...' }
    // ─────────────────────────────────────────────────────────────────────
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string|size:6',
        ]);

        $stored = Session::get('otp_data');

        // No OTP in session
        if (!$stored) {
            return response()->json([
                'success' => false,
                'message' => 'No OTP found. Please request a new one.',
            ], 422);
        }

        // OTP expired
        if (now()->timestamp > $stored['expires']) {
            Session::forget('otp_data');
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.',
            ], 422);
        }

        // Email mismatch (extra security — ensure OTP used for same email)
        if ($stored['email'] !== $request->email) {
            return response()->json([
                'success' => false,
                'message' => 'OTP is not valid for this email address.',
            ], 422);
        }

        // Wrong code
        if ($stored['code'] !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect OTP. Please try again.',
            ], 422);
        }

        // ✅ Correct — mark as verified in session so placeOrder can trust it
        Session::put('otp_verified', $request->email);
        Session::forget('otp_data');

        return response()->json(['success' => true]);
    }

    // ── PLACE ORDER ───────────────────────────────────────────────────────
    //  POST /shop/checkout
    //  Requires OTP to have been verified for the submitted email address.
    // ─────────────────────────────────────────────────────────────────────
public function placeOrder(Request $request)
{
    $data = $request->validate([
        'customer_name'         => 'required|string|max:255',
        'email'                 => 'required|email',
        'shipping_address'      => 'nullable|string',
        'payment_method'        => 'nullable|string',
        'gcash_reference'       => 'nullable|string|size:13',
        'items'                 => 'required|array|min:1',
        'items.*.name'          => 'required|string',
        'items.*.emoji'         => 'nullable|string',
        'items.*.qty'           => 'required|integer|min:1',
        'items.*.price'         => 'required|numeric|min:0',
        // ↓ NEW: item type, source ID, and service booking date
        'items.*.item_type'     => 'nullable|string|in:pet,supply,service',
        'items.*.source_id'     => 'nullable|integer',
        'items.*.scheduled_at'  => 'nullable|date|after:today',
    ]);

    // Guard: OTP must have been verified for this exact email
    $verifiedEmail = Session::get('otp_verified');
    if ($verifiedEmail !== $data['email']) {
        return back()
            ->withInput()
            ->with('error', 'Your order could not be verified. Please complete OTP verification.');
    }

    // Create the order
    $order = Order::create([
        'order_number'     => Order::generateOrderNumber(),
        'customer_name'    => $data['customer_name'],
        'email'            => $data['email'],
        'shipping_address' => $data['shipping_address'] ?? null,
        'status'           => 'pending',
        'ordered_at'       => now(),
    ]);

    foreach ($data['items'] as $item) {
        $order->items()->create([
            'item_name'    => $item['name'],
            'icon'         => $item['emoji'] ?? '📦',
            'quantity'     => $item['qty'],
            'price'        => $item['price'],
            // ↓ NEW: save the three new columns
            'item_type'    => $item['item_type']    ?? 'supply',
            'source_id'    => $item['source_id']    ?? null,
            'scheduled_at' => $item['scheduled_at'] ?? null,
        ]);
    }

    // Log activity
    Activity::log(
        'Order',
        $order->customer_name,
        'Purchased ' . collect($data['items'])->pluck('name')->implode(', '),
        'Pending',
        '🛒'
    );

    // Clear verification from session
    Session::forget('otp_verified');

    return redirect()
        ->route('order.success')
        ->with('order_id', $order->order_number);
}

// ── SUCCESS PAGE ──────────────────────────────────────────────────────
public function success()
{
    return view('order.success');
}
}