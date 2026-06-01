{{--
    track-result.blade.php
    Rendered by OrderTrackingController::result()
    Receives: $order  (Order model with ->items() eager-loaded)

    Order columns:  order_number, customer_name, email,
                    shipping_address, status, tracking_notes,
                    ordered_at, created_at
    Items columns:  item_name, icon, quantity, price
--}}
@extends('layouts.app')

@section('content')
<div style="background-color:#fcf9f4; min-height:80vh; padding:40px 20px;">
    <div style="max-width:800px; margin:0 auto;">

        <a href="{{ route('order.track.form') }}"
           style="display:inline-flex; align-items:center; color:#4a3b32; text-decoration:none; margin-bottom:20px; font-weight:600;">
            <span style="margin-right:8px;">←</span> Back to Track Order
        </a>

        {{-- ── Order Status Card ─────────────────────────────────────── --}}
        <div style="background:#ffffff; padding:40px; border-radius:20px;
                    box-shadow:0 10px 30px rgba(0,0,0,0.04); border:1px solid #f3eae1; margin-bottom:30px;">

            <div style="text-align:center; margin-bottom:40px;">
                <h1 style="font-family:'Playfair Display',serif; color:#2d2117; font-size:32px; margin-bottom:10px;">
                    Order Details
                </h1>
                <p style="color:#8c7e74; font-size:14px;">
                    Order ID: <strong style="color:#e07a2c;">{{ $order->order_number }}</strong>
                </p>
            </div>

            {{-- ── Status Badge ──────────────────────────────────────── --}}
            @php
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

                $orderTotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                $itemNames  = $order->items->pluck('item_name')->implode(', ');
            @endphp

            <div style="text-align:center; margin-bottom:40px;">
                <div style="display:inline-block; padding:12px 32px; border-radius:30px;
                            font-size:18px; font-weight:bold; color:white;
                            background-color:{{ $statusColor }};">
                    {{ ucfirst($order->status) }}
                </div>
            </div>

            {{-- ── Customer + Order Info Grid ───────────────────────── --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px; margin-bottom:30px;">

                <div style="background-color:#faf8f5; padding:24px; border-radius:12px;">
                    <h3 style="color:#2d2117; font-size:16px; margin-bottom:16px; font-weight:600;">
                        👤 Customer Information
                    </h3>
                    <div style="margin-bottom:12px;">
                        <span style="color:#8c7e74; font-size:13px; display:block; margin-bottom:4px;">Name</span>
                        <span style="color:#2d2117; font-weight:600;">{{ $order->customer_name }}</span>
                    </div>
                    <div>
                        <span style="color:#8c7e74; font-size:13px; display:block; margin-bottom:4px;">Email</span>
                        <span style="color:#2d2117;">{{ $order->email }}</span>
                    </div>
                </div>

                <div style="background-color:#faf8f5; padding:24px; border-radius:12px;">
                    <h3 style="color:#2d2117; font-size:16px; margin-bottom:16px; font-weight:600;">
                        📦 Order Summary
                    </h3>
                    <div style="margin-bottom:12px;">
                        <span style="color:#8c7e74; font-size:13px; display:block; margin-bottom:4px;">Item(s)</span>
                        <span style="color:#2d2117; font-weight:600;">
                            {{ $itemNames ?: 'N/A' }}
                        </span>
                    </div>
                    <div>
                        <span style="color:#8c7e74; font-size:13px; display:block; margin-bottom:4px;">Total</span>
                        <span style="color:#e07a2c; font-weight:bold; font-size:18px;">
                            ₱{{ number_format($orderTotal, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── Order Items Breakdown ─────────────────────────────── --}}
            @if($order->items->count())
            <div style="background-color:#faf8f5; padding:24px; border-radius:12px; margin-bottom:30px;">
                <h3 style="color:#2d2117; font-size:16px; margin-bottom:16px; font-weight:600;">🛒 Items Ordered</h3>
                @foreach($order->items as $item)
                <div style="display:flex; justify-content:space-between; align-items:center;
                            padding:10px 0; border-bottom:1px solid #f3eae1;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <span style="font-size:1.4rem;">{{ $item->icon ?? '📦' }}</span>
                        <div>
                            <div style="font-weight:600; color:#2d2117; font-size:.9rem;">{{ $item->item_name }}</div>
                            <div style="color:#8c7e74; font-size:.75rem;">Qty: {{ $item->quantity }}</div>
                        </div>
                    </div>
                    <span style="font-weight:700; color:#e07a2c;">
                        ₱{{ number_format($item->price * $item->quantity, 2) }}
                    </span>
                </div>
                @endforeach
                <div style="display:flex; justify-content:space-between; padding-top:12px; font-weight:700; color:#2d2117;">
                    <span>Grand Total</span>
                    <span style="color:#e07a2c;">₱{{ number_format($orderTotal, 2) }}</span>
                </div>
            </div>
            @endif

            {{-- ── Shipping Address ──────────────────────────────────── --}}
            @if($order->shipping_address)
            <div style="background-color:#faf8f5; padding:24px; border-radius:12px; margin-bottom:30px;">
                <h3 style="color:#2d2117; font-size:16px; margin-bottom:12px; font-weight:600;">
                    📍 Shipping Address
                </h3>
                <p style="color:#4a3b32; line-height:1.6;">{{ $order->shipping_address }}</p>
            </div>
            @endif

            {{-- ── Order Timeline ────────────────────────────────────── --}}
            @php
                $statusLower = strtolower($order->status);

                /*
                 * FIXED: Timeline steps now correctly reflect the 4-step flow:
                 *   pending → to-ship → shipped → completed
                 *
                 * $isProcessing: lights up once admin approves (to-ship and beyond)
                 * $isShipped:    lights up only when the order is actually with the
                 *                courier ('shipped' status), NOT at 'to-ship'.
                 *                Previously 'to-ship' was included here, causing the
                 *                Shipped step to appear active before the item left.
                 * $isDelivered:  lights up only on 'completed' or 'delivered'.
                 */
                $isProcessing = in_array($statusLower, ['processing', 'to-ship', 'shipped', 'completed', 'delivered']);
                $isShipped    = in_array($statusLower, ['shipped', 'completed', 'delivered']);
                $isDelivered  = in_array($statusLower, ['completed', 'delivered']);

                $orderedAt = $order->ordered_at ?? $order->created_at;
            @endphp

            <div style="margin-top:40px;">
                <h3 style="color:#2d2117; font-size:18px; margin-bottom:24px; font-weight:600; text-align:center;">
                    Order Timeline
                </h3>

                <div style="position:relative; padding:20px 0;">
                    {{-- Vertical line --}}
                    <div style="position:absolute; left:50%; transform:translateX(-50%);
                                top:0; bottom:0; width:2px; background-color:#e6ded6;"></div>

                    {{-- Step 1: Order Placed --}}
                    <div style="position:relative; display:flex; justify-content:flex-end;
                                align-items:center; margin-bottom:30px; padding-right:calc(50% + 24px);">
                        <div style="position:absolute; left:50%; transform:translateX(-50%);
                                    width:16px; height:16px; border-radius:50%; background-color:#10b981;
                                    border:3px solid white; box-shadow:0 0 0 3px #10b981;"></div>
                        <div style="background-color:#f0fdf4; padding:12px 24px; border-radius:8px; min-width:180px;">
                            <p style="color:#166534; font-weight:600; margin:0;">Order Placed</p>
                            <p style="color:#166534; font-size:13px; margin:4px 0 0;">
                                {{ \Carbon\Carbon::parse($orderedAt)->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    </div>

                    {{-- Step 2: Processing --}}
                    <div style="position:relative; display:flex; justify-content:flex-start;
                                align-items:center; margin-bottom:30px; padding-left:calc(50% + 24px);">
                        <div style="position:absolute; left:50%; transform:translateX(-50%);
                                    width:16px; height:16px; border-radius:50%;
                                    background-color:{{ $isProcessing ? '#3b82f6' : '#e6ded6' }};
                                    border:3px solid white;
                                    box-shadow:0 0 0 3px {{ $isProcessing ? '#3b82f6' : '#e6ded6' }};"></div>
                        <div style="background-color:{{ $isProcessing ? '#eff6ff' : '#faf8f5' }};
                                    padding:12px 24px; border-radius:8px; min-width:180px;">
                            <p style="color:{{ $isProcessing ? '#1e40af' : '#8c7e74' }}; font-weight:600; margin:0;">
                                Processing
                            </p>
                            <p style="color:{{ $isProcessing ? '#1e40af' : '#8c7e74' }}; font-size:13px; margin:4px 0 0;">
                                Preparing your order
                            </p>
                        </div>
                    </div>

                    {{-- Step 3: Shipped --}}
                    <div style="position:relative; display:flex; justify-content:flex-end;
                                align-items:center; margin-bottom:30px; padding-right:calc(50% + 24px);">
                        <div style="position:absolute; left:50%; transform:translateX(-50%);
                                    width:16px; height:16px; border-radius:50%;
                                    background-color:{{ $isShipped ? '#8b5cf6' : '#e6ded6' }};
                                    border:3px solid white;
                                    box-shadow:0 0 0 3px {{ $isShipped ? '#8b5cf6' : '#e6ded6' }};"></div>
                        <div style="background-color:{{ $isShipped ? '#f5f3ff' : '#faf8f5' }};
                                    padding:12px 24px; border-radius:8px; min-width:180px;">
                            <p style="color:{{ $isShipped ? '#6d28d9' : '#8c7e74' }}; font-weight:600; margin:0;">
                                Shipped
                            </p>
                            <p style="color:{{ $isShipped ? '#6d28d9' : '#8c7e74' }}; font-size:13px; margin:4px 0 0;">
                                On the way to you
                            </p>
                        </div>
                    </div>

                    {{-- Step 4: Delivered --}}
                    <div style="position:relative; display:flex; justify-content:flex-start;
                                align-items:center; padding-left:calc(50% + 24px);">
                        <div style="position:absolute; left:50%; transform:translateX(-50%);
                                    width:16px; height:16px; border-radius:50%;
                                    background-color:{{ $isDelivered ? '#10b981' : '#e6ded6' }};
                                    border:3px solid white;
                                    box-shadow:0 0 0 3px {{ $isDelivered ? '#10b981' : '#e6ded6' }};"></div>
                        <div style="background-color:{{ $isDelivered ? '#f0fdf4' : '#faf8f5' }};
                                    padding:12px 24px; border-radius:8px; min-width:180px;">
                            <p style="color:{{ $isDelivered ? '#166534' : '#8c7e74' }}; font-weight:600; margin:0;">
                                Delivered
                            </p>
                            <p style="color:{{ $isDelivered ? '#166534' : '#8c7e74' }}; font-size:13px; margin:4px 0 0;">
                                Order completed
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Tracking Notes ────────────────────────────────────── --}}
            @if($order->tracking_notes)
            <div style="background-color:#fffbeb; border-left:4px solid #f59e0b;
                        padding:16px; border-radius:8px; margin-top:30px;">
                <p style="color:#92400e; margin:0;">
                    <strong>📝 Note:</strong> {{ $order->tracking_notes }}
                </p>
            </div>
            @endif
        </div>

        {{-- ── Help Section ──────────────────────────────────────────── --}}
        <div style="text-align:center; padding:30px; background-color:#ffffff;
                    border-radius:12px; border:1px solid #f3eae1;">
            <p style="color:#8c7e74; margin-bottom:16px;">Need help with your order?</p>
            <a href="mailto:support@pawhaven.ph"
               style="display:inline-block; background-color:#e07a2c; color:white;
                      padding:12px 32px; border-radius:30px; text-decoration:none; font-weight:600;">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection