@extends('layouts.app')
@section('title', 'Order History — PawHaven')
@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap');
:root {
    --cream: #FDF8F1; --cream-mid: #FDF2E9; --orange: #E68A39; --orange-dark: #CF7529;
    --brown: #2D241E; --brown-sub: #5C4D3C; --brown-muted: #A68B6D;
    --border: #F3E9DC; --border-mid: #EBD7BC; --white: #ffffff;
    --green: #34A853; --shadow-md: 0 6px 24px rgba(45,36,30,0.10);
    --radius-md: 1.25rem; --radius-lg: 1.75rem; --serif: 'DM Serif Display', serif;
}
*, *::before, *::after { box-sizing: border-box; }
body { background: var(--cream); color: var(--brown); font-family: 'Segoe UI', system-ui, sans-serif; margin: 0; padding-bottom: 4rem; }

.order-header {
    background: var(--white); border-bottom: 1.5px solid var(--border);
    padding: 1rem 1.25rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem;
    position: sticky; top: 0; z-index: 90;
    box-shadow: 0 4px 12px rgba(45,36,30,0.05);
    flex-wrap: wrap;
}
.order-title { font-family: var(--serif); font-size: 1.5rem; color: var(--brown); margin: 0; }
@media (min-width: 480px) { .order-title { font-size: 1.8rem; } .order-header { padding: 1.5rem 2rem; } }
@media (min-width: 768px) { .order-header { padding: 1.5rem 2.5rem; } }

.btn-back {
    background: transparent; color: var(--brown-sub); border: 1.5px solid var(--border);
    padding: 7px 14px; border-radius: 99px; font-size: 0.82rem; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all 0.2s; white-space: nowrap; flex-shrink: 0;
}
.btn-back:hover { border-color: var(--orange); color: var(--orange); background: #FFF8F0; }

.order-container { max-width: 900px; margin: 1.5rem auto; padding: 0 1rem; }
@media (min-width: 640px) { .order-container { margin: 2.5rem auto; padding: 0 1.5rem; } }

.order-card {
    background: var(--white); border-radius: var(--radius-lg); border: 1.5px solid var(--border);
    margin-bottom: 1.5rem; overflow: hidden; box-shadow: var(--shadow-md); transition: transform 0.2s;
}
.order-card:hover { transform: translateY(-2px); }

.order-top {
    background: var(--cream-mid); padding: 0.85rem 1rem; display: flex;
    flex-direction: column; gap: 0.5rem; border-bottom: 1px solid var(--border);
}
@media (min-width: 480px) {
    .order-top { flex-direction: row; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; padding: 1rem 1.5rem; }
}

.order-id { font-weight: 800; color: var(--brown); font-size: 0.95rem; }
@media (min-width: 480px) { .order-id { font-size: 1rem; } }
.order-meta { font-size: 0.82rem; color: var(--brown-muted); display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; }
.status-badge { padding: 3px 9px; border-radius: 99px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap; }
.status-delivered { background: #DCFCE7; color: #166534; }
.status-processing { background: #DBEAFE; color: #1E40AF; }
.status-shipped { background: #F3E8FF; color: #7E22CE; }
.status-cancelled { background: #FEE2E2; color: #991B1B; }
.status-pending { background: #FEF9C3; color: #854D0E; }
.status-completed { background: #DCFCE7; color: #166534; }

.order-body { padding: 1rem; }
@media (min-width: 480px) { .order-body { padding: 1.25rem 1.5rem; } }

.order-item {
    display: flex; align-items: flex-start; justify-content: space-between;
    padding: 0.85rem 0; border-bottom: 1px dashed var(--border); gap: 0.75rem;
}
.order-item:last-child { border-bottom: none; padding-bottom: 0; }
.order-item:first-child { padding-top: 0; }
.item-left { display: flex; align-items: center; gap: 0.75rem; flex: 1; min-width: 0; }

/* ✅ Updated: item thumbnail supports both image and emoji fallback */
.item-thumb {
    width: 44px; height: 44px; min-width: 44px;
    background: var(--cream-mid); border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden; border: 1px solid var(--border);
}
.item-thumb img { width: 100%; height: 100%; object-fit: cover; }
.item-thumb .item-emoji-fallback { font-size: 1.8rem; line-height: 1; }
@media (min-width: 480px) {
    .item-thumb { width: 50px; height: 50px; min-width: 50px; border-radius: 12px; }
    .item-thumb .item-emoji-fallback { font-size: 2.2rem; }
}

.item-details h4 { font-size: 0.88rem; font-weight: 700; margin: 0 0 3px; color: var(--brown); }
@media (min-width: 480px) { .item-details h4 { font-size: 0.95rem; } }
.item-details p { font-size: 0.75rem; color: var(--brown-muted); margin: 0; }
.item-right { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 5px; flex-shrink: 0; }
.item-price { font-weight: 700; color: var(--orange); font-size: 0.92rem; white-space: nowrap; }
@media (min-width: 480px) { .item-price { font-size: 1rem; } }
.reorder-btn {
    background: var(--brown); color: var(--white); border: none;
    padding: 5px 12px; border-radius: 99px; font-size: 0.73rem; font-weight: 700;
    cursor: pointer; transition: all 0.2s; white-space: nowrap;
}
.reorder-btn:hover { background: var(--orange); transform: scale(1.05); }
.reorder-btn.added { background: var(--green); cursor: default; }

.empty-orders {
    text-align: center; padding: 3rem 1.5rem; color: var(--brown-muted);
    background: var(--white); border-radius: var(--radius-lg);
    border: 1.5px solid var(--border); box-shadow: var(--shadow-md);
}
@media (min-width: 480px) { .empty-orders { padding: 4rem 2rem; } }
.empty-icon { font-size: 2.5rem; display: block; margin-bottom: 1rem; }
@media (min-width: 480px) { .empty-icon { font-size: 3rem; } }
.empty-orders h3 { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--brown); }
@media (min-width: 480px) { .empty-orders h3 { font-size: 1.1rem; } }
</style>

<div class="order-header">
    <h1 class="order-title">📜 Order History</h1>
    <a href="{{ route('shop') }}" class="btn-back">← Back to Shop</a>
</div>

<div class="order-container">
    @php $orders = $orders ?? collect(); @endphp

    @forelse($orders as $order)
    <div class="order-card">
        <div class="order-top">
            <div>
                <div class="order-id">Order #{{ $order->order_number ?? $order->id }}</div>
                <div class="order-meta">
                    📅 {{ ($order->ordered_at ?? $order->created_at)->format('M d, Y') }}
                </div>
            </div>
            <div class="order-meta">
                <span>💰 ₱{{ number_format($order->grand_total, 2) }}</span>
                <span class="status-badge status-{{ Str::lower($order->status ?? 'pending') }}">
                    {{ ucfirst($order->status ?? 'Pending') }}
                </span>
            </div>
        </div>

        <div class="order-body">
            @forelse($order->items as $item)
            <div class="order-item">
                <div class="item-left">
                    {{-- ✅ Shows actual image if available, falls back to emoji --}}
                    <div class="item-thumb">
                        @if(!empty($item->image_url))
                            <img src="{{ $item->image_url }}" alt="{{ $item->item_name }}">
                        @elseif(!empty($item->source) && !empty($item->source->image_path))
                            <img src="{{ Storage::url($item->source->image_path) }}" alt="{{ $item->item_name }}">
                        @else
                            <span class="item-emoji-fallback">{{ $item->icon ?? '📦' }}</span>
                        @endif
                    </div>
                    <div class="item-details">
                        <h4>{{ $item->item_name }} (x{{ $item->quantity }})</h4>
                        <p>{{ ucfirst($item->item_type ?? 'Product') }}</p>
                    </div>
                </div>
                <div class="item-right">
                    <span class="item-price">₱{{ number_format($item->price, 2) }}</span>
                    <button class="reorder-btn"
                        onclick="addOrderToCart({{ $item->id }}, '{{ addslashes($item->item_name) }}', {{ $item->price }}, '{{ addslashes($item->icon ?? '📦') }}')">
                        Add to Cart 🛒
                    </button>
                </div>
            </div>
            @empty
            <p style="text-align:center; color:var(--brown-muted); font-size:0.88rem; padding:1rem 0;">
                No item details available.
            </p>
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
    let cart = JSON.parse(sessionStorage.getItem('ph_cart') || '[]');
    const existing = cart.find(c => String(c.id) === String(id));
    if (existing) { existing.qty++; } else { cart.push({ id, name, price, emoji, qty: 1 }); }
    sessionStorage.setItem('ph_cart', JSON.stringify(cart));
    const btn = event.currentTarget;
    btn.textContent = '✓ Added';
    btn.classList.add('added');
    setTimeout(() => { btn.textContent = 'Add to Cart 🛒'; btn.classList.remove('added'); }, 2000);
}
</script>
@endsection