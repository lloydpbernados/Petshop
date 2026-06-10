@extends('layouts.app')
@section('content')
<style>
*, *::before, *::after { box-sizing: border-box; }
body { background-color: #fcf9f4; }
.result-wrap { min-height: 80vh; padding: 24px 16px; }
@media (min-width: 640px) { .result-wrap { padding: 40px 20px; } }
.result-inner { max-width: 800px; margin: 0 auto; }

.back-link { display: inline-flex; align-items: center; color: #4a3b32; text-decoration: none; margin-bottom: 18px; font-weight: 600; font-size: 14px; }
.back-link:hover { color: #e07a2c; }

.result-card { background: #ffffff; padding: 24px 20px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #f3eae1; margin-bottom: 24px; }
@media (min-width: 480px) { .result-card { padding: 32px 28px; } }
@media (min-width: 640px) { .result-card { padding: 40px; } }

.result-title { font-family: 'Playfair Display', serif; color: #2d2117; font-size: 24px; text-align: center; margin: 0 0 8px; }
@media (min-width: 480px) { .result-title { font-size: 28px; } }
@media (min-width: 640px) { .result-title { font-size: 32px; } }
.result-order-id { color: #8c7e74; font-size: 13px; text-align: center; margin-bottom: 28px; }

.info-grid { display: grid; grid-template-columns: 1fr; gap: 16px; margin-bottom: 24px; }
@media (min-width: 560px) { .info-grid { grid-template-columns: 1fr 1fr; } }
.info-box { background-color: #faf8f5; padding: 18px; border-radius: 12px; }
.info-box h3 { color: #2d2117; font-size: 14px; margin: 0 0 14px; font-weight: 600; }
.info-field { margin-bottom: 10px; }
.info-field:last-child { margin-bottom: 0; }
.info-field-label { color: #8c7e74; font-size: 12px; display: block; margin-bottom: 3px; }
.info-field-value { color: #2d2117; font-weight: 600; font-size: 14px; word-break: break-word; }

.items-box { background-color: #faf8f5; padding: 18px; border-radius: 12px; margin-bottom: 24px; }
@media (min-width: 480px) { .items-box { padding: 22px 24px; } }
.items-box h3 { color: #2d2117; font-size: 14px; margin: 0 0 14px; font-weight: 600; }
.order-item-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f3eae1; gap: 12px; }
.order-item-row:last-of-type { border-bottom: none; }
.order-item-left { display: flex; align-items: center; gap: 10px; flex: 1; min-width: 0; }
.order-item-icon { font-size: 1.3rem; flex-shrink: 0; }
.order-item-name { font-weight: 600; color: #2d2117; font-size: 0.88rem; }
.order-item-qty { color: #8c7e74; font-size: 0.75rem; }
.order-item-price { font-weight: 700; color: #e07a2c; white-space: nowrap; font-size: 0.9rem; flex-shrink: 0; }
.grand-total-row { display: flex; justify-content: space-between; padding-top: 12px; font-weight: 700; color: #2d2117; font-size: 0.95rem; }

/* Timeline */
.timeline-section { margin-top: 36px; }
.timeline-title { color: #2d2117; font-size: 16px; margin-bottom: 20px; font-weight: 600; text-align: center; }
@media (min-width: 480px) { .timeline-title { font-size: 18px; margin-bottom: 24px; } }

/* Vertical timeline for mobile, centered for desktop */
.timeline { position: relative; padding: 0; }
.timeline::before {
    content: ''; position: absolute; left: 20px; top: 0; bottom: 0;
    width: 2px; background-color: #e6ded6;
}
@media (min-width: 560px) {
    .timeline::before { left: 50%; transform: translateX(-50%); }
}
.timeline-step { position: relative; display: flex; align-items: flex-start; margin-bottom: 24px; padding-left: 52px; }
@media (min-width: 560px) {
    .timeline-step { padding-left: 0; padding-right: 0; justify-content: flex-end; padding-right: calc(50% + 24px); }
    .timeline-step.right { justify-content: flex-start; padding-right: 0; padding-left: calc(50% + 24px); }
}
.timeline-dot {
    position: absolute; left: 12px; top: 12px;
    width: 16px; height: 16px; border-radius: 50%;
    border: 3px solid white; flex-shrink: 0;
}
@media (min-width: 560px) {
    .timeline-dot { left: 50%; transform: translateX(-50%); top: 12px; }
}
.timeline-content { padding: 12px 16px; border-radius: 8px; min-width: 0; flex: 1; }
@media (min-width: 560px) { .timeline-content { min-width: 180px; flex: none; } }
.timeline-content p { margin: 0; }
.timeline-content .step-title { font-weight: 600; font-size: 14px; }
.timeline-content .step-sub { font-size: 12px; margin-top: 3px; }

.shipping-box { background-color: #faf8f5; padding: 18px; border-radius: 12px; margin-bottom: 24px; }
.shipping-box h3 { color: #2d2117; font-size: 14px; margin: 0 0 10px; font-weight: 600; }
.shipping-box p { color: #4a3b32; line-height: 1.6; margin: 0; font-size: 14px; }

.tracking-note { background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 14px 16px; border-radius: 8px; margin-top: 24px; }
.tracking-note p { color: #92400e; margin: 0; font-size: 14px; line-height: 1.5; }

.help-box { text-align: center; padding: 24px 20px; background-color: #ffffff; border-radius: 12px; border: 1px solid #f3eae1; }
.help-box p { color: #8c7e74; margin-bottom: 14px; font-size: 14px; }
.help-btn { display: inline-block; background-color: #e07a2c; color: white; padding: 11px 28px; border-radius: 30px; text-decoration: none; font-weight: 600; font-size: 14px; transition: background-color .2s; }
.help-btn:hover { background-color: #cf7029; }
</style>

<div class="result-wrap">
    <div class="result-inner">
        <a href="{{ route('order.track.form') }}" class="back-link">
            <span style="margin-right:6px;">←</span> Back to Track Order
        </a>

        <div class="result-card">
            <div style="text-align:center; margin-bottom: 28px;">
                <h1 class="result-title">Order Details</h1>
                <p class="result-order-id">Order ID: <strong style="color:#e07a2c;">{{ $order->order_number }}</strong></p>
            </div>

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

            <div style="text-align:center; margin-bottom: 28px;">
                <div style="display:inline-block; padding:10px 28px; border-radius:30px; font-size:16px; font-weight:bold; color:white; background-color:{{ $statusColor }};">
                    {{ ucfirst($order->status) }}
                </div>
            </div>

            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-box">
                    <h3>👤 Customer Information</h3>
                    <div class="info-field">
                        <span class="info-field-label">Name</span>
                        <span class="info-field-value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-field">
                        <span class="info-field-label">Email</span>
                        <span class="info-field-value">{{ $order->email }}</span>
                    </div>
                </div>
                <div class="info-box">
                    <h3>📦 Order Summary</h3>
                    <div class="info-field">
                        <span class="info-field-label">Item(s)</span>
                        <span class="info-field-value">{{ $itemNames ?: 'N/A' }}</span>
                    </div>
                    <div class="info-field">
                        <span class="info-field-label">Total</span>
                        <span class="info-field-value" style="color:#e07a2c; font-size:16px;">₱{{ number_format($orderTotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Items Breakdown -->
            @if($order->items->count())
            <div class="items-box">
                <h3>🛒 Items Ordered</h3>
                @foreach($order->items as $item)
                <div class="order-item-row">
                    <div class="order-item-left">
                        <span class="order-item-icon">{{ $item->icon ?? '📦' }}</span>
                        <div>
                            <div class="order-item-name">{{ $item->item_name }}</div>
                            <div class="order-item-qty">Qty: {{ $item->quantity }}</div>
                        </div>
                    </div>
                    <span class="order-item-price">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                </div>
                @endforeach
                <div class="grand-total-row">
                    <span>Grand Total</span>
                    <span style="color:#e07a2c;">₱{{ number_format($orderTotal, 2) }}</span>
                </div>
            </div>
            @endif

            <!-- Shipping -->
            @if($order->shipping_address)
            <div class="shipping-box">
                <h3>📍 Shipping Address</h3>
                <p>{{ $order->shipping_address }}</p>
            </div>
            @endif

            <!-- Timeline -->
            @php
                $statusLower = strtolower($order->status);
                $isProcessing = in_array($statusLower, ['processing', 'to-ship', 'shipped', 'completed', 'delivered']);
                $isShipped    = in_array($statusLower, ['shipped', 'completed', 'delivered']);
                $isDelivered  = in_array($statusLower, ['completed', 'delivered']);
                $orderedAt = $order->ordered_at ?? $order->created_at;
            @endphp

            <div class="timeline-section">
                <h3 class="timeline-title">Order Timeline</h3>
                <div class="timeline">

                    <!-- Step 1: Placed -->
                    <div class="timeline-step">
                        <div class="timeline-dot" style="background-color:#10b981; box-shadow:0 0 0 3px #10b981;"></div>
                        <div class="timeline-content" style="background-color:#f0fdf4;">
                            <p class="step-title" style="color:#166534;">Order Placed</p>
                            <p class="step-sub" style="color:#166534;">{{ \Carbon\Carbon::parse($orderedAt)->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <!-- Step 2: Processing -->
                    <div class="timeline-step right">
                        <div class="timeline-dot" style="background-color:{{ $isProcessing ? '#3b82f6' : '#e6ded6' }}; box-shadow:0 0 0 3px {{ $isProcessing ? '#3b82f6' : '#e6ded6' }};"></div>
                        <div class="timeline-content" style="background-color:{{ $isProcessing ? '#eff6ff' : '#faf8f5' }};">
                            <p class="step-title" style="color:{{ $isProcessing ? '#1e40af' : '#8c7e74' }};">Processing</p>
                            <p class="step-sub" style="color:{{ $isProcessing ? '#1e40af' : '#8c7e74' }};">Preparing your order</p>
                        </div>
                    </div>

                    <!-- Step 3: Shipped -->
                    <div class="timeline-step">
                        <div class="timeline-dot" style="background-color:{{ $isShipped ? '#8b5cf6' : '#e6ded6' }}; box-shadow:0 0 0 3px {{ $isShipped ? '#8b5cf6' : '#e6ded6' }};"></div>
                        <div class="timeline-content" style="background-color:{{ $isShipped ? '#f5f3ff' : '#faf8f5' }};">
                            <p class="step-title" style="color:{{ $isShipped ? '#6d28d9' : '#8c7e74' }};">Shipped</p>
                            <p class="step-sub" style="color:{{ $isShipped ? '#6d28d9' : '#8c7e74' }};">On the way to you</p>
                        </div>
                    </div>

                    <!-- Step 4: Delivered -->
                    <div class="timeline-step right">
                        <div class="timeline-dot" style="background-color:{{ $isDelivered ? '#10b981' : '#e6ded6' }}; box-shadow:0 0 0 3px {{ $isDelivered ? '#10b981' : '#e6ded6' }};"></div>
                        <div class="timeline-content" style="background-color:{{ $isDelivered ? '#f0fdf4' : '#faf8f5' }};">
                            <p class="step-title" style="color:{{ $isDelivered ? '#166534' : '#8c7e74' }};">Delivered</p>
                            <p class="step-sub" style="color:{{ $isDelivered ? '#166534' : '#8c7e74' }};">Order completed</p>
                        </div>
                    </div>

                </div>
            </div>

            @if($order->tracking_notes)
            <div class="tracking-note">
                <p><strong>📝 Note:</strong> {{ $order->tracking_notes }}</p>
            </div>
            @endif
        </div>

        <div class="help-box">
            <p>Need help with your order?</p>
            <a href="mailto:support@pawhaven.ph" class="help-btn">Contact Support</a>
        </div>
    </div>
</div>
@endsection