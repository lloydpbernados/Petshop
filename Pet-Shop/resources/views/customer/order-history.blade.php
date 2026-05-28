@extends('layouts.app')
@section('title', 'Order History — PawHaven')
@section('content')
{{-- ── STYLES ── --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap');
:root {
    --cream: #FDF8F1; --cream-mid: #FDF2E9; --orange: #E68A39; --orange-dark: #CF7529;
    --brown: #2D241E; --brown-sub: #5C4D3C; --brown-muted: #A68B6D;
    --border: #F3E9DC; --border-mid: #EBD7BC; --white: #ffffff;
    --green: #34A853; --shadow-md: 0 6px 24px rgba(45,36,30,0.10);
    --radius-md: 1.25rem; --radius-lg: 1.75rem; --serif: 'DM Serif Display', serif;
}
body { background: var(--cream); color: var(--brown); font-family: 'Segoe UI', system-ui, sans-serif; margin: 0; padding-bottom: 4rem; }
.order-header { background: var(--white); border-bottom: 1.5px solid var(--border); padding: 1.5rem 2.5rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 90; box-shadow: 0 4px 12px rgba(45,36,30,0.05); }
.order-title { font-family: var(--serif); font-size: 1.8rem; color: var(--brown); margin: 0; }
.btn-back { background: transparent; color: var(--brown-sub); border: 1.5px solid var(--border); padding: 8px 16px; border-radius: 99px; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
.btn-back:hover { border-color: var(--orange); color: var(--orange); background: #FFF8F0; }
.order-container { max-width: 900px; margin: 2.5rem auto; padding: 0 1.5rem; }

/* Order Card Styles */
.order-card { background: var(--white); border-radius: var(--radius-lg); border: 1.5px solid var(--border); margin-bottom: 2rem; overflow: hidden; box-shadow: var(--shadow-md); transition: transform 0.2s; }
.order-card:hover { transform: translateY(-2px); }
.order-top { background: var(--cream-mid); padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid var(--border); }
.order-id { font-weight: 800; color: var(--brown); font-size: 1rem; }
.order-meta { font-size: 0.85rem; color: var(--brown-muted); display: flex; gap: 1rem; align-items: center; }
.status-badge { padding: 4px 10px; border-radius: 99px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
.status-delivered { background: #DCFCE7; color: #166534; }
.status-processing { background: #DBEAFE; color: #1E40AF; }
.status-shipped { background: #F3E8FF; color: #7E22CE; }
.status-cancelled { background: #FEE2E2; color: #991B1B; }

/* Order Items */
.order-body { padding: 1.5rem; }
.order-item { display: flex; align-items: center; justify-content: space-between; padding: 1rem 0; border-bottom: 1px dashed var(--border); }
.order-item:last-child { border-bottom: none; padding-bottom: 0; }
.order-item:first-child { padding-top: 0; }
.item-left { display: flex; align-items: center; gap: 1rem; }
.item-emoji { font-size: 2.2rem; width: 50px; height: 50px; background: var(--cream-mid); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.item-details h4 { font-size: 0.95rem; font-weight: 700; margin: 0 0 4px; color: var(--brown); }
.item-details p { font-size: 0.8rem; color: var(--brown-muted); margin: 0; }
.item-right { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 6px; }
.item-price { font-weight: 700; color: var(--orange); font-size: 1rem; }
.reorder-btn { background: var(--brown); color: var(--white); border: none; padding: 6px 14px; border-radius: 99px; font-size: 0.78rem; font-weight: 700; cursor: pointer; transition: all 0.2s; }
.reorder-btn:hover { background: var(--orange); transform: scale(1.05); }
.reorder-btn.added { background: var(--green); cursor: default; }

/* Empty State */
.empty-orders { text-align: center; padding: 4rem 2rem; color: var(--brown-muted); background: var(--white); border-radius: var(--radius-lg); border: 1.5px solid var(--border); box-shadow: var(--shadow-md); }
.empty-icon { font-size: 3rem; display: block; margin-bottom: 1rem; }
.empty-orders h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--brown); }

@media (max-width: 600px) {
    .order-header { padding: 1.25rem; }
    .order-top { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    .item-left { gap: 0.75rem; }
}
</style>

<div class="order-header">
    <h1 class="order-title">📜 Order History</h1>
    <a href="{{ route('shop') }}" class="btn-back">← Back to Shop</a>
</div>

<div class="order-container">
    {{-- 
      FIX: Initialize $orders to an empty collection if it is not passed by the controller.
      This prevents the "Undefined variable $orders" crash.
    --}}
    @php
        $orders = $orders ?? collect();
    @endphp

    @forelse($orders as $order)
    <div class="order-card">
        <div class="order-top">
            <div>
                <div class="order-id">Order #{{ $order->id }}</div>
                <div class="order-meta">📅 {{ $order->created_at->format('M d, Y') }}</div>
            </div>
            <div class="order-meta">
                <span>💰 ₱{{ number_format($order->total, 2) }}</span>
                <span class="status-badge status-{{ Str::lower($order->status ?? 'processing') }}">{{ ucfirst($order->status ?? 'Processing') }}</span>
            </div>
        </div>
        
        <div class="order-body">
            @forelse($order->items as $item)
            <div class="order-item">
                <div class="item-left">
                    <div class="item-emoji">
                        @if(isset($item->product) && $item->product->emoji)
                            {{ $item->product->emoji }}
                        @else
                            📦
                        @endif
                    </div>
                    <div class="item-details">
                        <h4>{{ $item->product->name ?? 'Item' }} (x{{ $item->quantity ?? $item->qty ?? 1 }})</h4>
                        <p>{{ $item->product->category ?? 'General' }}</p>
                    </div>
                </div>
                <div class="item-right">
                    <span class="item-price">₱{{ number_format($item->price ?? 0, 2) }}</span>
                    <button class="reorder-btn" onclick="addOrderToCart({{ $item->id }}, '{{ addslashes($item->product->name ?? 'Item') }}', {{ $item->price ?? 0 }}, '{{ addslashes($item->product->emoji ?? '📦') }}')">
                        Add to Cart 🛒
                    </button>
                </div>
            </div>
            @empty
            <p style="text-align:center; color: var(--brown-muted); font-size: 0.9rem; padding: 1rem 0;">No items details available for this order.</p>
            @endforelse
        </div>
    </div>
    @empty
    <div class="empty-orders">
        <span class="empty-icon">📦</span>
        <h3>No Orders Yet</h3>
        <p>You haven't placed any orders yet. Start shopping to see your history here!</p>
        <a href="{{ route('shop') }}" style="display:inline-block; margin-top:1.5rem; background:var(--orange); color:white; padding:10px 24px; border-radius:99px; font-weight:700; text-decoration:none;">Go Shopping</a>
    </div>
    @endforelse
</div>

<script>
function addOrderToCart(id, name, price, emoji) {
    // Use the same logic as the shop page (sessionStorage key: 'ph_cart')
    let cart = JSON.parse(sessionStorage.getItem('ph_cart') || '[]');
    const existing = cart.find(c => String(c.id) === String(id));
    if (existing) { existing.qty++; } else { cart.push({ id, name, price, emoji, qty: 1 }); }
    sessionStorage.setItem('ph_cart', JSON.stringify(cart));
    
    // Visual feedback
    const btn = event.currentTarget;
    btn.textContent = '✓ Added';
    btn.classList.add('added');
    setTimeout(() => { btn.textContent = 'Add to Cart 🛒'; btn.classList.remove('added'); }, 2000);
}
</script>
@endsection