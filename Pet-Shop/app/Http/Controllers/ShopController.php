<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
            'id'             => 'pet-' . $p->id,
            'name'           => $p->name,
            'emoji'          => $p->emoji,
            'image'          => $p->image_path ? Storage::url($p->image_path) : null,
            'category'       => $p->category,
            'type'           => 'pet',
            'price'          => $p->price,
            'badge'          => $p->badge,
            'badgeLabel'     => $p->badge_label,
            'desc'           => $p->description,
            'available'      => $p->stock > 0,
        ]);

        $supplies = Supply::where('available', true)->get()->map(fn($s) => [
            'id'             => 'supply-' . $s->id,
            'name'           => $s->name,
            'emoji'          => $s->emoji,
            'image'          => $s->image_path ? Storage::url($s->image_path) : null,
            'category'       => $s->category,
            'type'           => 'product',
            'price'          => $s->price,
            'badge'          => $s->badge,
            'badgeLabel'     => $s->badge_label,
            'desc'           => $s->description,
            'available'      => $s->stock > 0,
            // ↓ Pass weight options to the JS catalog so the modal can render them
            'weight_options' => $s->weight_options ?? [],
        ]);

        $services = Service::active()->get()->map(fn($s) => [
            'id'         => 'service-' . $s->id,
            'name'       => $s->name,
            'emoji'      => $s->icon,
            'image'      => $s->image_path ? Storage::url($s->image_path) : null,
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
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name'  => 'nullable|string|max:255',
        ]);

        $otp  = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $name = $request->input('name', 'Customer');

        Session::put('otp_data', [
            'code'    => $otp,
            'email'   => $request->email,
            'expires' => now()->addMinutes(10)->timestamp,
        ]);

        Mail::to($request->email)->send(new OtpMail($otp, $name));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to ' . $request->email,
        ]);
    }

    // ── VERIFY OTP ────────────────────────────────────────────────────────
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string|size:6',
        ]);

        $stored = Session::get('otp_data');

        if (!$stored) {
            return response()->json(['success' => false, 'message' => 'No OTP found. Please request a new one.'], 422);
        }

        if (now()->timestamp > $stored['expires']) {
            Session::forget('otp_data');
            return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new one.'], 422);
        }

        if ($stored['email'] !== $request->email) {
            return response()->json(['success' => false, 'message' => 'OTP is not valid for this email address.'], 422);
        }

        if ($stored['code'] !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Incorrect OTP. Please try again.'], 422);
        }

        Session::put('otp_verified', $request->email);
        Session::forget('otp_data');

        return response()->json(['success' => true]);
    }

    // ── ORDER HISTORY ─────────────────────────────────────────────────────
    public function orderHistory()
    {
        $user = Auth::user();

        $orders = Order::with('items')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('email', $user->email);
            })
            ->latest('ordered_at')
            ->get();

        return view('customer.order-history', compact('orders'));
    }

    // ── PLACE ORDER ───────────────────────────────────────────────────────
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
            'items.*.item_type'     => 'nullable|string|in:pet,supply,service',
            'items.*.source_id'     => 'nullable|integer',
            'items.*.scheduled_at'  => 'nullable|date|after:today',
            'items.*.selected_kg'   => 'nullable|numeric',
            'items.*.variant_label' => 'nullable|string',
        ]);

        $verifiedEmail = Session::get('otp_verified');
        if ($verifiedEmail !== $data['email']) {
            return back()->withInput()->with('error', 'Your order could not be verified. Please complete OTP verification.');
        }

        $totalAmount = collect($data['items'])->sum(fn($item) => $item['price'] * $item['qty']);

        $order = Order::create([
            'user_id'          => Auth::id(),
            'order_number'     => Order::generateOrderNumber(),
            'customer_name'    => $data['customer_name'],
            'email'            => $data['email'],
            'shipping_address' => $data['shipping_address'] ?? null,
            'payment_method'   => $data['payment_method'] ?? 'cash',
            'gcash_reference'  => $data['gcash_reference'] ?? null,
            'total_amount'     => $totalAmount,
            'status'           => 'pending',
            'ordered_at'       => now(),
        ]);

        foreach ($data['items'] as $item) {
            $order->items()->create([
                'item_name'    => $item['name'],
                'icon'         => $item['emoji'] ?? '📦',
                'quantity'     => $item['qty'],
                'price'        => $item['price'],
                'item_type'    => $item['item_type']    ?? 'supply',
                'source_id'    => $item['source_id']    ?? null,
                'scheduled_at' => $item['scheduled_at'] ?? null,
            ]);
        }

        Activity::log(
            'Order',
            $order->customer_name,
            'Purchased ' . collect($data['items'])->pluck('name')->implode(', '),
            'Pending',
            '🛒'
        );

        Session::forget('otp_verified');

        return redirect()->route('order.success')->with('order_id', $order->order_number);
    }

    // ── SUCCESS PAGE ──────────────────────────────────────────────────────
    public function success()
    {
        return view('order.success');
    }
}