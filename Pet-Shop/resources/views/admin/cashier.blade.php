{{-- cashier.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1]">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-serif-brand text-3xl font-bold text-[#2D241E]">Walk-in Cashier</h1>
            <p class="text-sm text-gray-400 mt-1">Select items from the catalog, then complete the sale on the right.</p>
        </div>
        <button onclick="openHistory()"
                class="flex items-center gap-2 bg-white border border-[#EBD7BC] text-[#5C4D3C] px-5 py-2.5 rounded-full text-sm font-bold shadow-sm hover:bg-[#FDF8F1] transition-colors">
            📋 History
        </button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_400px] gap-6 items-start">

        {{-- LEFT PANEL — Product Catalog --}}
        <div class="space-y-4">

            {{-- Filters --}}
            <div class="bg-white rounded-2xl border border-[#F3E9DC] p-4 flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm">🔍</span>
                    <input id="posSearch" type="text" placeholder="Search by name, category…"
                           oninput="filterProducts()"
                           class="w-full pl-9 pr-4 py-2.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-sm text-[#2D241E] focus:outline-none focus:border-[#E68A39]">
                </div>
                <div class="flex gap-2">
                    <button id="tab-all"    onclick="setTab('all')"    class="pos-tab on  flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-sm font-bold">All</button>
                    <button id="tab-supply" onclick="setTab('supply')" class="pos-tab off flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-sm font-bold">Supplies</button>
                    <button id="tab-pet"    onclick="setTab('pet')"    class="pos-tab off flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-sm font-bold">Pets</button>
                </div>
            </div>

            {{-- Product Grid --}}
            <div id="productLoading" class="bg-white rounded-2xl border border-[#F3E9DC] py-16 text-center text-gray-400">
                <div class="text-3xl mb-2 animate-pulse">📦</div>
                <p class="text-sm">Loading products…</p>
            </div>
            <div id="productEmpty" class="hidden bg-white rounded-2xl border border-[#F3E9DC] py-16 text-center text-gray-400">
                <div class="text-3xl mb-2">📭</div>
                <p class="text-sm">No products match your search.</p>
            </div>
            <div id="productGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3"></div>
        </div>

        {{-- RIGHT PANEL — Cart & Checkout --}}
        <div class="bg-white rounded-2xl border border-[#F3E9DC] shadow-sm sticky top-6 flex flex-col" style="max-height: calc(100vh - 7rem);">

            {{-- Cart header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-[#F3E9DC]">
                <div class="flex items-center gap-2">
                    <span class="font-serif-brand text-lg text-[#2D241E]">Cart</span>
                    <span id="cartBadge" class="hidden bg-[#E68A39] text-white text-[10px] font-bold w-5 h-5 rounded-full items-center justify-center">0</span>
                </div>
                <button onclick="clearCart()" class="text-xs text-gray-400 hover:text-red-500 font-bold transition-colors">Clear</button>
            </div>

            {{-- Customer name --}}
            <div class="px-5 py-3 border-b border-[#F3E9DC]">
                <input id="customerName" type="text" placeholder="Customer name (optional)"
                       class="w-full px-3 py-2 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-sm text-[#2D241E] focus:outline-none focus:border-[#E68A39]">
            </div>

            {{-- Cart item list --}}
            <div id="cartList" class="flex-1 overflow-y-auto px-5 py-3 space-y-1">
                <div id="cartEmpty" class="py-10 text-center text-gray-300">
                    <div class="text-3xl mb-2">🛒</div>
                    <p class="text-sm">Cart is empty</p>
                    <p class="text-xs mt-0.5">Tap a product to add it</p>
                </div>
            </div>

            {{-- Summary + payment --}}
            <div class="border-t border-[#F3E9DC] px-5 py-4 space-y-4">

                <div class="flex justify-between text-sm text-gray-500">
                    <span>Subtotal</span>
                    <span id="subtotalDisplay">₱0.00</span>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Discount</span>
                    <div class="relative w-28">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">₱</span>
                        <input id="discountAmt" type="number" min="0" step="0.01" placeholder="0.00"
                               oninput="recalcTotals()"
                               class="w-full pl-6 pr-3 py-1.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-lg text-sm text-right text-[#2D241E] focus:outline-none focus:border-[#E68A39]">
                    </div>
                </div>

                <div class="flex justify-between items-center pt-2 border-t border-[#F3E9DC]">
                    <span class="font-bold text-[#2D241E]">Total</span>
                    <span id="totalDisplay" class="font-bold text-xl text-[#E68A39]">₱0.00</span>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <button id="pm-cash"  onclick="setPayment('cash')"  class="pm-btn on  py-2 rounded-xl text-xs font-bold border">💵 Cash</button>
                    <button id="pm-gcash" onclick="setPayment('gcash')" class="pm-btn off py-2 rounded-xl text-xs font-bold border">📱 GCash</button>
                    <button id="pm-card"  onclick="setPayment('card')"  class="pm-btn off py-2 rounded-xl text-xs font-bold border">💳 Card</button>
                </div>

                <div id="cashSection" class="space-y-2">
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₱</span>
                        <input id="cashTendered" type="number" min="0" placeholder="Cash tendered"
                               oninput="recalcTotals()"
                               class="w-full pl-8 pr-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-sm text-[#2D241E] focus:outline-none focus:border-[#E68A39]">
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Change</span>
                        <span id="changeDisplay" class="font-bold text-[#34A853]">₱0.00</span>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5">
                        <button onclick="quickCash(50)"   class="py-1.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-lg text-xs font-bold text-[#5C4D3C] hover:bg-[#EBD7BC]">₱50</button>
                        <button onclick="quickCash(100)"  class="py-1.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-lg text-xs font-bold text-[#5C4D3C] hover:bg-[#EBD7BC]">₱100</button>
                        <button onclick="quickCash(500)"  class="py-1.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-lg text-xs font-bold text-[#5C4D3C] hover:bg-[#EBD7BC]">₱500</button>
                        <button onclick="quickCash(1000)" class="py-1.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-lg text-xs font-bold text-[#5C4D3C] hover:bg-[#EBD7BC]">₱1K</button>
                    </div>
                </div>

                <button id="checkoutBtn" onclick="checkout()"
                        class="w-full py-3.5 bg-[#E68A39] hover:bg-[#cf7529] text-white font-bold rounded-xl shadow transition-colors text-sm flex items-center justify-center gap-2">
                    Complete Sale
                </button>
            </div>
        </div>

    </div>
</div>

{{-- WEIGHT PICKER MODAL --}}
<div id="weightModal" class="modal-backdrop hidden">
    <div class="modal-box w-full max-w-sm" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-serif-brand text-xl text-[#2D241E]">Choose a size</h3>
            <button onclick="closeModal('weightModal')" class="modal-close-btn">✕</button>
        </div>
        <div class="flex items-center gap-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-2xl p-3 mb-4">
            <div id="wpImg" class="w-12 h-12 rounded-xl bg-white border border-[#F3E9DC] flex items-center justify-center text-xl overflow-hidden shrink-0"></div>
            <div id="wpName" class="font-bold text-[#2D241E] text-sm"></div>
        </div>
        <div id="wpOptions" class="space-y-2"></div>
    </div>
</div>

{{-- RECEIPT MODAL --}}
<div id="receiptModal" class="modal-backdrop hidden">
    <div class="modal-box w-full max-w-md max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-serif-brand text-xl text-[#2D241E]">Receipt</h3>
            <button onclick="closeModal('receiptModal')" class="modal-close-btn">✕</button>
        </div>
        <div id="receiptContent"></div>
        <div class="grid grid-cols-2 gap-3 mt-5">
            <button onclick="printReceipt()" class="py-3 bg-[#E68A39] hover:bg-[#cf7529] text-white font-bold rounded-xl text-sm transition-colors">🖨️ Print</button>
            <button onclick="newSale()"      class="py-3 bg-[#34A853] hover:bg-[#2c8d46] text-white font-bold rounded-xl text-sm transition-colors">➕ New Sale</button>
        </div>
    </div>
</div>

{{-- HISTORY MODAL --}}
<div id="historyModal" class="modal-backdrop hidden">
    <div class="modal-box w-full max-w-xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-serif-brand text-xl text-[#2D241E]">Transaction History</h3>
            <button onclick="closeModal('historyModal')" class="modal-close-btn">✕</button>
        </div>
        <div id="historyList" class="space-y-3"></div>
        <div class="flex justify-between items-center mt-5 pt-4 border-t border-[#F3E9DC]">
            <span class="text-sm font-bold text-gray-500">Total recorded</span>
            <span id="historyTotal" class="text-lg font-bold text-[#E68A39]">₱0.00</span>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="toast" class="fixed bottom-6 right-6 z-[200] px-5 py-3.5 rounded-2xl shadow-xl font-bold text-sm flex items-center gap-2 opacity-0 translate-y-4 pointer-events-none transition-all duration-300"></div>

{{-- Hidden print frame --}}
<iframe id="printFrame" style="display:none; position:fixed; inset:0; width:100%; height:100%;"></iframe>

<style>
.pos-tab.on  { background:#E68A39; color:#fff; border:1.5px solid #E68A39; }
.pos-tab.off { background:#FDF8F1; color:#5C4D3C; border:1.5px solid #F3E9DC; }
.pos-tab.off:hover { background:#EBD7BC; }

.pm-btn.on  { background:#E68A39; color:#fff; border-color:#E68A39; }
.pm-btn.off { background:#FDF8F1; color:#5C4D3C; border-color:#F3E9DC; }
.pm-btn.off:hover { background:#EBD7BC; }

.prod-card { transition:transform .12s, box-shadow .12s, border-color .12s; cursor:pointer; }
.prod-card:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(230,138,57,.18); border-color:#E68A39; }
.prod-card.sold-out { opacity:.45; pointer-events:none; }

.modal-backdrop { position:fixed; inset:0; background:rgba(45,36,30,.45); backdrop-filter:blur(4px); z-index:60; display:flex; align-items:center; justify-content:center; padding:1rem; }
.modal-backdrop.hidden { display:none; }
.modal-box { background:#fff; border-radius:1.5rem; padding:1.75rem; box-shadow:0 24px 60px rgba(0,0,0,.18); }
.modal-close-btn { width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:.75rem; color:#9ca3af; font-size:.875rem; transition:background .15s, color .15s; }
.modal-close-btn:hover { background:#FDF8F1; color:#2D241E; }
</style>

<script>
const API  = '/api/v1';
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

const EMOJI     = { Food:'🍖',Toys:'🎾',Accessories:'🎀',Health:'💊',Grooming:'🪮',Dogs:'🐶',Cats:'🐱',Birds:'🦜','Small Pets':'🐹',Fish:'🐠',Reptiles:'🦎' };
const CAT_COLOR = { Food:'#FEF9C3',Toys:'#FCE7F3',Accessories:'#EDE9FE',Health:'#E9F0FE',Grooming:'#E9F7F2',Dogs:'#FEF9C3',Cats:'#FCE7F3',Birds:'#E9F0FE','Small Pets':'#EDE9FE',Fish:'#E9F7F2',Reptiles:'#FFEDD5' };

let products = [];
let cart     = [];
let tab      = 'all';
let payMode  = 'cash';
let pending  = null;
let history  = JSON.parse(localStorage.getItem('ph_txns') || '[]');

// ─── Persistent cart click handler (set up ONCE on DOMContentLoaded) ──────
// This is the root fix: one permanent listener on #cartList, never removed.
function initCartListener() {
    document.getElementById('cartList').addEventListener('click', function(e) {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        const idx    = parseInt(btn.dataset.idx);
        const action = btn.dataset.action;
        if (isNaN(idx) || !cart[idx]) return;

        if (action === 'dec') {
            if (cart[idx].qty <= 1) {
                cart.splice(idx, 1);
            } else {
                cart[idx].qty--;
            }
            renderCart();
        } else if (action === 'inc') {
            if (cart[idx].qty >= cart[idx].stock) {
                toast('Not enough stock.', false);
                return;
            }
            cart[idx].qty++;
            renderCart();
        } else if (action === 'remove') {
            cart.splice(idx, 1);
            renderCart();
        }
    });
}

// ─── Load products ─────────────────────────────────────────────────────────
async function loadProducts() {
    try {
        const [sRes, pRes] = await Promise.all([fetch(`${API}/supplies`), fetch(`${API}/pets`)]);
        const supplies = sRes.ok ? await sRes.json() : [];
        const pets     = pRes.ok ? await pRes.json() : [];
        products = [
            ...supplies.map(s => ({...s, _type:'supply'})),
            ...pets.map(p    => ({...p, _type:'pet'})),
        ];
        document.getElementById('productLoading').classList.add('hidden');
        render();
    } catch {
        document.getElementById('productLoading').innerHTML =
            '<p class="py-12 text-center text-sm text-red-400">Could not load products.</p>';
    }
}

// ─── Render product grid ───────────────────────────────────────────────────
function render() {
    const q    = document.getElementById('posSearch').value.toLowerCase();
    const list = products.filter(p => {
        if (tab === 'supply' && p._type !== 'supply') return false;
        if (tab === 'pet'    && p._type !== 'pet')    return false;
        return !q
            || p.name.toLowerCase().includes(q)
            || (p.category||'').toLowerCase().includes(q)
            || (p.sku||'').toLowerCase().includes(q);
    });

    const grid  = document.getElementById('productGrid');
    const empty = document.getElementById('productEmpty');

    if (!list.length) { grid.innerHTML = ''; empty.classList.remove('hidden'); return; }
    empty.classList.add('hidden');

    grid.innerHTML = list.map(p => {
        const em       = EMOJI[p.category] || '📦';
        const bg       = CAT_COLOR[p.category] || '#F3E9DC';
        const out      = p.status === 'out' || p.stock <= 0;
        const imgHTML  = p.image
            ? `<img src="${p.image}" class="w-full h-full object-cover" loading="lazy">`
            : `<span class="text-3xl">${em}</span>`;
        const hasSizes = p._type === 'supply' && Array.isArray(p.weight_options) && p.weight_options.length;
        const sizeLine = hasSizes
            ? `<p class="text-[10px] text-[#92400E] font-bold mt-0.5">⚖️ ${p.weight_options.map(o=>`${o.kg}kg`).join(' / ')}</p>`
            : '';
        const stockLine = out
            ? `<span class="text-[10px] text-red-400 font-bold">Out of stock</span>`
            : `<span class="text-[10px] text-gray-400">${p.stock} left</span>`;

        return `
        <div class="prod-card bg-white rounded-2xl border border-[#F3E9DC] overflow-hidden ${out ? 'sold-out' : ''}"
             data-pid="${p.id}" data-ptype="${p._type}">
            <div class="w-full aspect-square flex items-center justify-center overflow-hidden" style="background:${bg}20">
                ${imgHTML}
            </div>
            <div class="p-3 space-y-0.5">
                <p class="font-bold text-[#2D241E] text-xs leading-snug line-clamp-2">${p.name}</p>
                ${sizeLine}
                <div class="flex items-center justify-between pt-1">
                    <span class="font-bold text-[#E68A39] text-sm">₱${parseFloat(p.price).toLocaleString('en-PH',{minimumFractionDigits:2})}</span>
                    ${stockLine}
                </div>
            </div>
        </div>`;
    }).join('');

    grid.querySelectorAll('.prod-card').forEach(card => {
        card.addEventListener('click', () => addToCart(parseInt(card.dataset.pid), card.dataset.ptype));
    });
}

function setTab(t) {
    tab = t;
    ['all','supply','pet'].forEach(id => {
        document.getElementById(`tab-${id}`).className =
            `pos-tab ${id===t?'on':'off'} flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-sm font-bold`;
    });
    render();
}
function filterProducts() { render(); }

// ─── Cart mutations ────────────────────────────────────────────────────────
function addToCart(id, type) {
    const p = products.find(x => x.id === id && x._type === type);
    if (!p || p.stock <= 0) return;
    if (type === 'supply' && Array.isArray(p.weight_options) && p.weight_options.length) {
        pending = p; showWeightPicker(p); return;
    }
    pushCart(p, p.price, null);
}

function pushCart(p, price, sizeLabel) {
    const key = sizeLabel ? `${p.id}-${p._type}-${sizeLabel}` : `${p.id}-${p._type}`;
    const row = cart.find(c => c.key === key);
    if (row) {
        if (row.qty >= p.stock) { toast('Max stock reached.', false); return; }
        row.qty++;
    } else {
        cart.push({ key, id:p.id, _type:p._type, name:p.name, price, qty:1, stock:p.stock, image:p.image, category:p.category, sizeLabel });
    }
    renderCart();
}

// ─── Render cart (only rebuilds innerHTML — listener stays on #cartList) ───
function renderCart() {
    const listEl = document.getElementById('cartList');
    const badge  = document.getElementById('cartBadge');
    const totalQ = cart.reduce((s,c) => s+c.qty, 0);

    badge.textContent = totalQ;
    badge.classList.toggle('hidden',     totalQ === 0);
    badge.classList.toggle('inline-flex', totalQ > 0);

    if (!cart.length) {
        listEl.innerHTML = `
        <div class="py-10 text-center text-gray-300">
            <div class="text-3xl mb-2">🛒</div>
            <p class="text-sm">Cart is empty</p>
            <p class="text-xs mt-0.5">Tap a product to add it</p>
        </div>`;
        recalcTotals();
        return;
    }

    listEl.innerHTML = cart.map((item, idx) => {
        const em  = EMOJI[item.category] || '📦';
        const img = item.image
            ? `<img src="${item.image}" class="w-full h-full object-cover">`
            : `<span class="text-sm">${em}</span>`;
        const tag = item.sizeLabel
            ? `<span class="text-[9px] bg-[#FEF9C3] text-[#854D0E] font-bold px-1.5 py-0.5 rounded-full">${item.sizeLabel}</span>`
            : '';
        return `
        <div class="flex items-center gap-3 py-2 border-b border-[#F3E9DC] last:border-0">
            <div class="w-9 h-9 rounded-lg bg-[#FDF8F1] border border-[#F3E9DC] flex items-center justify-center shrink-0 overflow-hidden">${img}</div>
            <div class="flex-1 min-w-0">
                <div class="text-xs font-bold text-[#2D241E] truncate">${escHtml(item.name)} ${tag}</div>
                <div class="text-[11px] text-[#E68A39] font-bold">₱${parseFloat(item.price).toLocaleString('en-PH',{minimumFractionDigits:2})}</div>
            </div>
            <div class="flex items-center gap-1 bg-[#FDF8F1] border border-[#F3E9DC] rounded-lg px-1 py-0.5 shrink-0">
                <button data-action="dec" data-idx="${idx}"
                        class="w-5 h-5 text-red-400 hover:bg-red-50 rounded font-bold text-xs flex items-center justify-center">−</button>
                <span class="text-xs font-bold text-[#2D241E] w-5 text-center">${item.qty}</span>
                <button data-action="inc" data-idx="${idx}"
                        class="w-5 h-5 text-green-600 hover:bg-green-50 rounded font-bold text-xs flex items-center justify-center">+</button>
            </div>
            <div class="text-xs font-bold text-[#2D241E] w-14 text-right shrink-0">₱${(item.price*item.qty).toLocaleString('en-PH',{minimumFractionDigits:2})}</div>
            <button data-action="remove" data-idx="${idx}"
                    class="text-gray-300 hover:text-red-400 text-xs ml-1 shrink-0">✕</button>
        </div>`;
    }).join('');

    recalcTotals();
}

function clearCart() {
    cart = [];
    document.getElementById('customerName').value = '';
    document.getElementById('discountAmt').value  = '';
    document.getElementById('cashTendered').value = '';
    renderCart();
}

// ─── Totals ────────────────────────────────────────────────────────────────
function recalcTotals() {
    const sub      = cart.reduce((s,i) => s + i.price * i.qty, 0);
    const disc     = parseFloat(document.getElementById('discountAmt').value) || 0;
    const total    = Math.max(0, sub - disc);
    const tendered = parseFloat(document.getElementById('cashTendered').value) || 0;
    const change   = Math.max(0, tendered - total);
    document.getElementById('subtotalDisplay').textContent = fmt(sub);
    document.getElementById('totalDisplay').textContent    = fmt(total);
    document.getElementById('changeDisplay').textContent   = fmt(change);
}

function fmt(n)    { return '₱' + n.toLocaleString('en-PH', {minimumFractionDigits:2}); }
function escHtml(s){ const d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

// ─── Payment ───────────────────────────────────────────────────────────────
function setPayment(m) {
    payMode = m;
    ['cash','gcash','card'].forEach(id => {
        document.getElementById(`pm-${id}`).className =
            `pm-btn ${id===m?'on':'off'} py-2 rounded-xl text-xs font-bold border`;
    });
    document.getElementById('cashSection').style.display = m === 'cash' ? '' : 'none';
}
function quickCash(n) { document.getElementById('cashTendered').value = n; recalcTotals(); }

// ─── Checkout ──────────────────────────────────────────────────────────────
async function checkout() {
    if (!cart.length) { toast('Cart is empty.', false); return; }
    const sub      = cart.reduce((s,i) => s + i.price * i.qty, 0);
    const disc     = parseFloat(document.getElementById('discountAmt').value) || 0;
    const total    = Math.max(0, sub - disc);
    const tendered = parseFloat(document.getElementById('cashTendered').value) || 0;
    if (payMode === 'cash' && tendered < total) { toast('Cash tendered is less than the total.', false); return; }

    const btn = document.getElementById('checkoutBtn');
    btn.disabled = true; btn.textContent = 'Processing…';

    for (const item of cart) {
        try {
            const ep = item._type === 'pet'
                ? `${API}/pets/${item.id}/stock`
                : `${API}/supplies/${item.id}/stock`;
            const r = await fetch(ep, {
                method: 'PATCH',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF },
                body: JSON.stringify({ delta: -item.qty }),
            });
            if (r.ok) {
                const d = await r.json();
                const p = products.find(x => x.id === item.id && x._type === item._type);
                if (p) { p.stock = d.stock; p.status = d.status; }
            }
        } catch {}
    }

    const txn = {
        id:       'TXN-' + Date.now(),
        time:     new Date().toLocaleString('en-PH'),
        customer: document.getElementById('customerName').value.trim() || 'Walk-in Customer',
        items:    JSON.parse(JSON.stringify(cart)),
        sub, disc, total,
        payment:  payMode,
        tendered: payMode === 'cash' ? tendered : total,
        change:   payMode === 'cash' ? Math.max(0, tendered - total) : 0,
    };
    history.unshift(txn);
    localStorage.setItem('ph_txns', JSON.stringify(history.slice(0, 100)));

    btn.disabled = false; btn.textContent = 'Complete Sale';
    render();
    showReceipt(txn);
    toast('Sale completed! 🎉');
}

// ─── Weight picker ─────────────────────────────────────────────────────────
function showWeightPicker(p) {
    document.getElementById('wpImg').innerHTML    = p.image
        ? `<img src="${p.image}" class="w-full h-full object-cover">`
        : (EMOJI[p.category] || '📦');
    document.getElementById('wpName').textContent = p.name;

    const opts = document.getElementById('wpOptions');
    opts.innerHTML = '';
    p.weight_options.forEach(o => {
        const btn = document.createElement('button');
        btn.className = 'w-full flex items-center justify-between px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl hover:border-[#E68A39] hover:bg-[#FDF2E9] transition-colors';
        btn.innerHTML = `<span class="font-bold text-sm text-[#2D241E]">⚖️ ${o.kg} kg bag</span>
                         <span class="font-bold text-sm text-[#E68A39]">₱${parseFloat(o.price).toLocaleString('en-PH',{minimumFractionDigits:2})}</span>`;
        btn.addEventListener('click', () => {
            pushCart(pending, o.price, `${o.kg}kg`);
            pending = null;
            closeModal('weightModal');
        });
        opts.appendChild(btn);
    });
    openModal('weightModal');
}

// ─── Receipt ───────────────────────────────────────────────────────────────
function buildReceiptHTML(txn) {
    const lines = txn.items.map(i => {
        const tag = i.sizeLabel ? ` (${i.sizeLabel})` : '';
        return `<div style="display:flex;justify-content:space-between;gap:8px;padding:2px 0;font-size:11px;">
            <span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${escHtml(i.name)}${tag} ×${i.qty}</span>
            <span style="flex-shrink:0;font-weight:bold;">${fmt(i.price * i.qty)}</span>
        </div>`;
    }).join('');

    return `
    <div style="font-family:monospace;font-size:12px;color:#2D241E;line-height:1.5;">
        <div style="text-align:center;padding-bottom:12px;border-bottom:1px dashed #ccc;margin-bottom:10px;">
            <div style="font-weight:bold;font-size:16px;letter-spacing:2px;">🐾 PAWHAVEN</div>
            <div style="color:#888;font-size:10px;">Your Trusted Pet Shop</div>
        </div>
        <div style="font-size:10px;color:#666;margin-bottom:10px;">
            <div style="display:flex;justify-content:space-between;"><span>Receipt:</span><span style="font-weight:bold;color:#2D241E;">${txn.id}</span></div>
            <div style="display:flex;justify-content:space-between;"><span>Date:</span><span>${txn.time}</span></div>
            <div style="display:flex;justify-content:space-between;"><span>Customer:</span><span>${escHtml(txn.customer)}</span></div>
            <div style="display:flex;justify-content:space-between;"><span>Payment:</span><span style="font-weight:bold;text-transform:capitalize;">${txn.payment}</span></div>
        </div>
        <div style="border-top:1px dashed #ccc;padding-top:8px;margin-bottom:8px;">${lines}</div>
        <div style="border-top:1px dashed #ccc;padding-top:8px;font-size:11px;">
            <div style="display:flex;justify-content:space-between;color:#666;"><span>Subtotal</span><span>${fmt(txn.sub)}</span></div>
            ${txn.disc > 0 ? `<div style="display:flex;justify-content:space-between;color:#34A853;"><span>Discount</span><span>-${fmt(txn.disc)}</span></div>` : ''}
            <div style="display:flex;justify-content:space-between;font-weight:bold;"><span>TOTAL</span><span>${fmt(txn.total)}</span></div>
            ${txn.payment === 'cash' ? `
            <div style="display:flex;justify-content:space-between;color:#666;"><span>Tendered</span><span>${fmt(txn.tendered)}</span></div>
            <div style="display:flex;justify-content:space-between;font-weight:bold;color:#34A853;"><span>Change</span><span>${fmt(txn.change)}</span></div>` : ''}
        </div>
        <div style="border-top:1px dashed #ccc;padding-top:12px;text-align:center;font-size:10px;color:#888;margin-top:10px;">
            <div>Thank you for shopping at PawHaven! 🐾</div>
            <div>No returns or exchanges without receipt.</div>
        </div>
    </div>`;
}

function showReceipt(txn) {
    document.getElementById('receiptContent').innerHTML = buildReceiptHTML(txn);
    document.getElementById('receiptModal').dataset.txn = JSON.stringify(txn);
    openModal('receiptModal');
}

function printReceipt() {
    const txnRaw = document.getElementById('receiptModal').dataset.txn;
    if (!txnRaw) return;
    const txn   = JSON.parse(txnRaw);
    const html  = buildReceiptHTML(txn);
    const frame = document.getElementById('printFrame');
    const doc   = frame.contentDocument || frame.contentWindow.document;
    doc.open();
    doc.write(`<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Receipt – ${txn.id}</title>
<style>
  * { box-sizing:border-box; margin:0; padding:0; }
  body { font-family:monospace; font-size:12px; color:#000; padding:8px; width:80mm; }
  @media print { @page { margin:4mm; size:80mm auto; } }
</style>
</head>
<body>${html}</body>
</html>`);
    doc.close();
    frame.contentWindow.onload = () => frame.contentWindow.print();
    setTimeout(() => { try { frame.contentWindow.print(); } catch {} }, 400);
}

function newSale() { closeModal('receiptModal'); clearCart(); }

// ─── History ───────────────────────────────────────────────────────────────
function openHistory() {
    const grand = history.reduce((s,t) => s + t.total, 0);
    document.getElementById('historyTotal').textContent = fmt(grand);

    const listEl = document.getElementById('historyList');
    if (!history.length) {
        listEl.innerHTML = `<div class="text-center py-10 text-gray-300"><div class="text-3xl mb-2">📋</div><p class="text-sm">No transactions yet.</p></div>`;
        openModal('historyModal');
        return;
    }

    listEl.innerHTML = history.map((txn, idx) => `
        <div class="bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl p-4">
            <div class="flex items-start justify-between">
                <div>
                    <div class="font-bold text-[#2D241E] text-sm">${escHtml(txn.customer)}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5 font-mono">${txn.id} · ${txn.time}</div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-[#E68A39] text-sm">${fmt(txn.total)}</div>
                    <div class="text-[10px] capitalize text-gray-400">${txn.payment}</div>
                </div>
            </div>
            <div class="text-[10px] text-gray-500 mt-2 line-clamp-2">
                ${txn.items.map(i => `${escHtml(i.name)}${i.sizeLabel ? ` (${i.sizeLabel})` : ''}×${i.qty}`).join(' · ')}
            </div>
            <button data-reprint="${idx}" class="mt-2 text-[10px] font-bold text-[#E68A39] hover:underline">🖨️ Reprint</button>
        </div>`).join('');

    listEl.addEventListener('click', function handler(e) {
        const btn = e.target.closest('[data-reprint]');
        if (!btn) return;
        const txn = history[parseInt(btn.dataset.reprint)];
        if (txn) { closeModal('historyModal'); showReceipt(txn); }
        listEl.removeEventListener('click', handler);
    });

    openModal('historyModal');
}

// ─── Modal helpers ─────────────────────────────────────────────────────────
function openModal(id)  { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

['weightModal','receiptModal','historyModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', e => {
        if (e.target.id === id) closeModal(id);
    });
});

// ─── Toast ─────────────────────────────────────────────────────────────────
function toast(msg, ok = true) {
    const el = document.getElementById('toast');
    el.className = `fixed bottom-6 right-6 z-[200] px-5 py-3.5 rounded-2xl shadow-xl font-bold text-sm flex items-center gap-2 transition-all duration-300 ${ok ? 'bg-[#34A853]' : 'bg-[#EF4444]'} text-white`;
    el.innerHTML = `<span>${ok ? '✅' : '⚠️'}</span> ${msg}`;
    el.style.opacity   = '1';
    el.style.transform = 'translateY(0)';
    clearTimeout(el._t);
    el._t = setTimeout(() => { el.style.opacity = '0'; el.style.transform = 'translateY(1rem)'; }, 3000);
}

// ─── Boot ──────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    initCartListener();  // set up the ONE permanent cart listener
    setPayment('cash');
    loadProducts();
});
</script>
@endsection