<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update — PawHaven</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #FDF8F1; padding: 40px 20px; color: #2D241E; }
        .wrapper { max-width: 560px; margin: 0 auto; background: #ffffff; border-radius: 20px; border: 1px solid #F3E9DC; overflow: hidden; box-shadow: 0 8px 32px rgba(45,36,30,0.08); }
        .header { background: linear-gradient(135deg, #FDF2E9, #FFF8F0); padding: 36px 40px 28px; text-align: center; border-bottom: 1px solid #F3E9DC; }
        .brand { font-size: 22px; font-weight: 800; color: #2D241E; letter-spacing: -0.02em; }
        .brand-sub { font-size: 12px; color: #A68B6D; margin-top: 4px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; }
        .status-banner { padding: 28px 40px; text-align: center; }
        .status-icon { font-size: 52px; display: block; margin-bottom: 12px; }
        .status-title { font-size: 22px; font-weight: 800; color: #2D241E; margin-bottom: 6px; }
        .status-sub { font-size: 14px; color: #A68B6D; }
        .body { padding: 0 40px 36px; }
        .greeting { font-size: 15px; color: #5C4D3C; margin-bottom: 24px; line-height: 1.7; }
        .order-box { background: #FDF8F1; border: 1px solid #F3E9DC; border-radius: 14px; padding: 20px 24px; margin-bottom: 24px; }
        .order-box-title { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: #A68B6D; margin-bottom: 14px; }
        .order-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #F3E9DC; font-size: 14px; }
        .order-row:last-child { border-bottom: none; padding-bottom: 0; }
        .order-row span:first-child { color: #8c7e74; }
        .order-row span:last-child { font-weight: 700; color: #2D241E; }
        .items-box { background: #fff; border: 1px solid #F3E9DC; border-radius: 14px; padding: 20px 24px; margin-bottom: 24px; }
        .items-box-title { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: #A68B6D; margin-bottom: 14px; }
        .item-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #FDF8F1; font-size: 14px; }
        .item-row:last-child { border-bottom: none; }
        .item-name { font-weight: 600; color: #2D241E; }
        .item-qty { font-size: 12px; color: #A68B6D; margin-top: 2px; }
        .item-price { font-weight: 700; color: #E68A39; }
        .total-row { display: flex; justify-content: space-between; margin-top: 12px; padding-top: 14px; border-top: 2px solid #F3E9DC; font-size: 15px; font-weight: 800; }
        .total-amt { color: #E68A39; font-size: 18px; }
        .track-btn { display: block; background: #E68A39; color: white; text-align: center; padding: 14px 32px; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 15px; margin-bottom: 24px; }
        .notice { background: #FFF8E1; border-left: 4px solid #F59E0B; border-radius: 8px; padding: 14px 16px; font-size: 13px; color: #78350F; line-height: 1.6; margin-bottom: 24px; }
        .footer { background: #FDF8F1; padding: 20px 40px; border-top: 1px solid #F3E9DC; text-align: center; }
        .footer p { font-size: 12px; color: #A68B6D; line-height: 1.7; }
        .footer strong { color: #5C4D3C; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="brand">🐾 PawHaven</div>
        <div class="brand-sub">Your trusted pet shop since 2014</div>
    </div>

    {{-- Status Banner --}}
    <div class="status-banner">
        @if($newStatus === 'to-ship')
            <span class="status-icon">✅</span>
            <div class="status-title">Order Approved!</div>
            <div class="status-sub">Your order is being prepared for shipment.</div>
        @else
            <span class="status-icon">📦</span>
            <div class="status-title">Your Order Is On Its Way!</div>
            <div class="status-sub">Your items have been shipped and are heading to you.</div>
        @endif
    </div>

    <div class="body">

        {{-- Greeting --}}
        <p class="greeting">
            Hi <strong>{{ $order->customer_name }}</strong>,<br><br>
            @if($newStatus === 'to-ship')
                Great news! We've reviewed and approved your order. Our team is now carefully packing your items. You'll receive another update once your order ships.
            @else
                Your order has been shipped! It's on its way to you. Please allow a few days for delivery depending on your location.
            @endif
        </p>

        {{-- Order Info --}}
        <div class="order-box">
            <div class="order-box-title">Order Details</div>
            <div class="order-row">
                <span>Order ID</span>
                <span>{{ $order->order_number }}</span>
            </div>
            <div class="order-row">
                <span>Status</span>
                <span>{{ $newStatus === 'to-ship' ? 'Approved — Packing' : 'Shipped' }}</span>
            </div>
            <div class="order-row">
                <span>Shipping To</span>
                <span>{{ $order->shipping_address ?? 'N/A' }}</span>
            </div>
            <div class="order-row">
                <span>Payment</span>
                <span>{{ ucfirst($order->payment_method ?? 'Cash on Delivery') }}</span>
            </div>
        </div>

        {{-- Items --}}
        @if($order->items->count())
        <div class="items-box">
            <div class="items-box-title">Items Ordered</div>
            @foreach($order->items as $item)
            <div class="item-row">
                <div>
                    <div class="item-name">{{ $item->icon ?? '📦' }} {{ $item->item_name }}</div>
                    <div class="item-qty">Qty: {{ $item->quantity }}</div>
                </div>
                <div class="item-price">₱{{ number_format($item->price * $item->quantity, 2) }}</div>
            </div>
            @endforeach
            <div class="total-row">
                <span>Grand Total</span>
                <span class="total-amt">₱{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</span>
            </div>
        </div>
        @endif

        {{-- Track Button --}}
        <a href="{{ url('/track/' . $order->order_number) }}" class="track-btn">
            🔍 Track Your Order
        </a>

        {{-- Notice --}}
        <div class="notice">
            ℹ️ <strong>Need help?</strong> If you have questions about your order, reply to this email or contact us at <strong>support@pawhaven.ph</strong>
        </div>

    </div>

    <div class="footer">
        <p>© {{ date('Y') }} <strong>PawHaven</strong>. All rights reserved.<br>
        You're receiving this because you placed an order with us.</p>
    </div>

</div>
</body>
</html>