@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1]">

    {{-- Modal --}}
    <div id="statusModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#2D241E]/50 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="relative bg-white rounded-4xl sm:rounded-[3rem] shadow-2xl p-8 sm:p-12 max-w-sm w-full border border-[#F3E9DC] transform transition-all scale-90 opacity-0 duration-300" id="modalContent">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-24 sm:h-24 bg-[#FDF8F1] rounded-full mb-5 sm:mb-6">
                    <span id="modalIcon" class="text-4xl sm:text-5xl">✅</span>
                </div>
                <h3 id="modalTitle" class="font-serif-brand text-2xl sm:text-3xl text-[#2D241E] mb-3 sm:mb-4">Success!</h3>
                <p id="modalMessage" class="text-gray-500 mb-8 sm:mb-10 leading-relaxed text-sm">Action completed.</p>
                <button onclick="closeModal()" class="w-full bg-[#E68A39] text-white py-3 sm:py-4 rounded-2xl font-bold shadow-lg shadow-orange-200 hover:bg-[#cf7b32] transition-all">
                    Understood
                </button>
            </div>
        </div>
    </div>

    {{-- Page Header --}}
    <div class="mb-6 sm:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="text-2xl sm:text-3xl">📦</span>
                <h1 class="font-serif-brand text-3xl sm:text-4xl font-bold text-[#2D241E]">Order Management</h1>
            </div>
            <p class="text-gray-500 text-sm sm:text-base">Track and manage customer purchases and service bookings.</p>
        </div>
        <a href="{{ route('admin.orders.export') }}"
           class="bg-[#E68A39] text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-bold shadow-md hover:scale-105 transition-all text-sm w-fit">
            Export CSV
        </a>
    </div>

    {{-- Tabs --}}
    <div class="overflow-x-auto pb-px mb-6 sm:mb-8">
        <div class="flex gap-2 sm:gap-4 border-b border-[#F3E9DC] min-w-max">
            @foreach(['pending' => '🕐 Pending', 'to-ship' => '📦 To Ship', 'shipped' => '🚚 Shipped', 'completed' => '✅ Completed', 'cancelled' => '❌ Cancelled'] as $tab => $label)
                <button
                    onclick="filterOrders('{{ $tab }}')"
                    id="tab-{{ $tab }}"
                    class="tab-btn px-4 sm:px-6 py-3 sm:py-4 border-b-4 transition-all text-[10px] tracking-[0.2em] font-bold whitespace-nowrap
                    {{ $tab === 'pending' ? 'border-[#E68A39] text-[#E68A39]' : 'border-transparent text-gray-400' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Orders Container --}}
    <div id="orders-container" class="space-y-5 sm:space-y-8 pb-24">
        <!-- JS renders here -->
    </div>
</div>

<script>
let ordersList = @json($orders);
let currentTab = 'pending';

function renderOrders() {
    const container = document.getElementById('orders-container');
    const filtered  = ordersList.filter(o => o.status === currentTab);

    if (filtered.length === 0) {
        container.innerHTML = `
            <div class="text-center py-16 sm:py-20 text-gray-400 font-bold uppercase tracking-widest text-xs">
                No ${currentTab.replace('-',' ')} orders found
            </div>`;
        return;
    }

    container.innerHTML = filtered.map(order => {

        // ── Grand total ──────────────────────────────────────────────────
        const physicalTotal = order.items.reduce((s, i) => s + (i.qty * i.price), 0);
        const bookingTotal  = order.bookings.reduce((s, b) => s + b.price, 0);
        const grandTotal    = physicalTotal + bookingTotal;

        // ── Action buttons per status ────────────────────────────────────
        let actionBtn = '';

        if (order.status === 'pending') {
            const label = order.has_physical ? 'Approve Order' : 'Confirm Booking';
            actionBtn = `
                <div class="flex gap-2 flex-wrap">
                    <button onclick="processOrder('${order.id}')"
                            class="bg-[#2D241E] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-2xl text-xs font-bold hover:bg-black transition-all shadow-lg">
                        ${label}
                    </button>
                    <button onclick="cancelOrder('${order.id}')"
                            class="bg-red-50 text-red-500 border border-red-200 px-5 sm:px-8 py-2.5 sm:py-3 rounded-2xl text-xs font-bold hover:bg-red-100 transition-all">
                        ❌ Cancel
                    </button>
                </div>`;

        } else if (order.status === 'to-ship') {
            actionBtn = `
                <button onclick="processOrder('${order.id}')"
                        class="bg-[#E68A39] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-2xl text-xs font-bold transition-all shadow-lg shadow-orange-100">
                    🚚 Mark as Shipped
                </button>`;

        } else if (order.status === 'shipped') {
            actionBtn = `
                <button onclick="processOrder('${order.id}')"
                        class="bg-green-600 text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-2xl text-xs font-bold hover:bg-green-700 transition-all shadow-lg">
                    ✅ Mark as Delivered
                </button>`;

        } else if (order.status === 'completed') {
            actionBtn = `
                <div class="flex items-center gap-2 text-green-600">
                    <span class="bg-green-100 p-1.5 rounded-full text-[8px]">✔</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Delivered</span>
                </div>`;

        } else if (order.status === 'cancelled') {
            actionBtn = `
                <div class="flex items-center gap-2 text-red-400">
                    <span class="bg-red-50 p-1.5 rounded-full text-[8px]">✕</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Cancelled</span>
                </div>`;
        }

        // ── Physical items rows ──────────────────────────────────────────
        const itemRows = order.items.length > 0 ? `
            <div class="px-5 sm:px-10 py-4 border-b border-[#F3E9DC]">
                <p class="text-[9px] font-bold uppercase tracking-widest text-[#A68B6D] mb-3">📦 Items / Products</p>
                <table class="w-full">
                    <tbody>
                        ${order.items.map(item => `
                            <tr class="border-b border-[#FDF8F1] last:border-0">
                                <td class="py-3 sm:py-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#FDF8F1] rounded-xl flex items-center justify-center text-xl shrink-0">
                                        ${item.icon}
                                    </div>
                                    <div>
                                        <p class="font-bold text-xs sm:text-sm">${item.name}</p>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">Qty: ${item.qty}</p>
                                    </div>
                                </td>
                                <td class="py-3 sm:py-4 text-right font-serif-brand text-base sm:text-lg whitespace-nowrap">
                                    ₱${(item.qty * item.price).toLocaleString()}
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>` : '';

        // ── Service bookings rows ────────────────────────────────────────
        const bookingRows = order.bookings.length > 0 ? `
            <div class="px-5 sm:px-10 py-4 border-b border-[#F3E9DC]">
                <p class="text-[9px] font-bold uppercase tracking-widest text-[#A68B6D] mb-3">🗓️ Service Bookings</p>
                <table class="w-full">
                    <tbody>
                        ${order.bookings.map(b => `
                            <tr class="border-b border-[#FDF8F1] last:border-0">
                                <td class="py-3 sm:py-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#FDF8F1] rounded-xl flex items-center justify-center text-xl shrink-0">
                                        ${b.icon}
                                    </div>
                                    <div>
                                        <p class="font-bold text-xs sm:text-sm">${b.name}</p>
                                        <p class="text-[10px] font-bold text-[#E68A39] mt-0.5">
                                            📅 Appointment: ${b.scheduled_at ?? 'No date set'}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3 sm:py-4 text-right font-serif-brand text-base sm:text-lg whitespace-nowrap">
                                    ₱${b.price.toLocaleString()}
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>` : '';

        // ── Grand total color: red if cancelled ──────────────────────────
        const totalColor = order.status === 'cancelled' ? 'text-red-400 line-through' : 'text-[#E68A39]';

        return `
            <div class="order-card bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm overflow-hidden">

                <div class="p-4 sm:p-6 bg-[#FDF2E9]/40 border-b border-[#F3E9DC] flex flex-wrap justify-between items-center gap-2 sm:gap-4">
                    <div class="flex items-center gap-2 sm:gap-4">
                        <span class="bg-[#E68A39] text-white px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[10px] font-bold uppercase">
                            #${order.id}
                        </span>
                        <span class="text-xs text-[#A68B6D] font-bold uppercase">${order.date}</span>
                    </div>
                    <div class="text-xs sm:text-sm text-[#2D241E] font-bold">${order.customer}</div>
                </div>

                <div class="px-5 sm:px-10 pt-4 flex gap-2 flex-wrap">
                    ${order.has_physical ? `<span class="text-[9px] font-bold uppercase tracking-widest bg-orange-50 text-orange-500 border border-orange-200 px-2 py-1 rounded-full">📦 Physical Items</span>` : ''}
                    ${order.has_booking  ? `<span class="text-[9px] font-bold uppercase tracking-widest bg-purple-50 text-purple-500 border border-purple-200 px-2 py-1 rounded-full">🗓️ Service Booking</span>` : ''}
                </div>

                ${itemRows}
                ${bookingRows}

                <div class="px-5 sm:px-10 py-5 sm:py-8 bg-[#FDF8F1]/50 border-t border-[#F3E9DC] flex justify-between items-center flex-wrap gap-4">
                    <div>${actionBtn}</div>
                    <div class="text-right">
                        <p class="text-[9px] text-gray-400 uppercase font-bold tracking-[0.2em] mb-1">Grand Total</p>
                        <h2 class="text-2xl sm:text-3xl font-serif-brand ${totalColor}">₱${grandTotal.toLocaleString()}</h2>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

// Advance order through status flow
async function processOrder(orderNumber) {
    try {
        const res = await fetch(`/admin/orders/${orderNumber}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        const data = await res.json();
        if (!res.ok) { showModal('❌', 'Error', data.error || 'Something went wrong.'); return; }

        const order = ordersList.find(o => o.id === orderNumber);
        if (order) order.status = data.new_status;

        renderOrders();

        const messages = {
            'to-ship'   : ['🐕', 'Order Approved',    `${order.customer}'s order is ready for packing.`],
            'shipped'   : ['🚚', 'Marked as Shipped',  `${order.customer} has been notified it's on the way.`],
            'completed' : ['✅', 'Delivery Confirmed', `Order marked as delivered. ${order.customer} has been notified.`],
        };

        const [icon, title, msg] = messages[data.new_status] ?? ['📋', 'Updated', 'Order status changed.'];
        showModal(icon, title, msg);

    } catch (err) {
        showModal('❌', 'Network Error', 'Could not update order. Please try again.');
    }
}

// Cancel a pending order
async function cancelOrder(orderNumber) {
    if (!confirm('Are you sure you want to cancel this order? This cannot be undone.')) return;

    try {
        const res = await fetch(`/admin/orders/${orderNumber}/cancel`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        const data = await res.json();
        if (!res.ok) { showModal('❌', 'Error', data.error || 'Could not cancel order.'); return; }

        const order = ordersList.find(o => o.id === orderNumber);
        if (order) order.status = 'cancelled';

        renderOrders();
        showModal('❌', 'Order Cancelled', `The order has been cancelled and the customer has been notified.`);

    } catch (err) {
        showModal('❌', 'Network Error', 'Could not cancel order. Please try again.');
    }
}

function filterOrders(status) {
    currentTab = status;
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-[#E68A39]', 'text-[#E68A39]');
        btn.classList.add('border-transparent', 'text-gray-400');
    });
    document.getElementById('tab-' + status).classList.add('border-[#E68A39]', 'text-[#E68A39]');
    renderOrders();
}

function showModal(icon, title, message) {
    const modal   = document.getElementById('statusModal');
    const content = document.getElementById('modalContent');
    document.getElementById('modalIcon').innerText    = icon;
    document.getElementById('modalTitle').innerText   = title;
    document.getElementById('modalMessage').innerText = message;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        content.classList.remove('scale-90', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeModal() {
    const modal   = document.getElementById('statusModal');
    const content = document.getElementById('modalContent');
    content.classList.add('scale-90', 'opacity-0');
    content.classList.remove('scale-100', 'opacity-100');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

document.addEventListener('DOMContentLoaded', renderOrders);
</script>
@endsection