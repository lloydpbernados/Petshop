@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1]">
    {{-- Mock Data Logic --}}
    @php
        $orders = [
            ['id' => 'PH-9921', 'status' => 'pending', 'customer' => 'Alice Rodriguez', 'date' => 'May 14, 2026', 'items' => [['name' => 'Premium Puppy Kibble', 'icon' => '🍖', 'qty' => 2, 'price' => 850], ['name' => 'Interactive Cat Wand', 'icon' => '🧶', 'qty' => 1, 'price' => 350]]],
            ['id' => 'PH-9922', 'status' => 'pending', 'customer' => 'Roberto Gomez', 'date' => 'May 14, 2026', 'items' => [['name' => 'Self-Cleaning Litter Box', 'icon' => '📦', 'qty' => 1, 'price' => 4500]]],
            ['id' => 'PH-9923', 'status' => 'pending', 'customer' => 'Elena Cruz', 'date' => 'May 14, 2026', 'items' => [['name' => 'Grooming Brush Set', 'icon' => '🪮', 'qty' => 1, 'price' => 1200], ['name' => 'Dog Shampoo', 'icon' => '🧴', 'qty' => 2, 'price' => 450]]],
            ['id' => 'PH-9925', 'status' => 'to-ship', 'customer' => 'Mark Tee', 'date' => 'May 13, 2026', 'items' => [['name' => 'Orthopedic Dog Bed', 'icon' => '🛏️', 'qty' => 1, 'price' => 2200]]],
            ['id' => 'PH-9926', 'status' => 'to-ship', 'customer' => 'Liza Soberano', 'date' => 'May 13, 2026', 'items' => [['name' => 'Hamster Exercise Wheel', 'icon' => '🎡', 'qty' => 1, 'price' => 650], ['name' => 'Hamster Pellets', 'icon' => '🐹', 'qty' => 3, 'price' => 150]]],
            ['id' => 'PH-9927', 'status' => 'to-ship', 'customer' => 'Kevin Tan', 'date' => 'May 12, 2026', 'items' => [['name' => 'Large Aquarium Filter', 'icon' => '🐠', 'qty' => 1, 'price' => 3200]]],
            ['id' => 'PH-9800', 'status' => 'completed', 'customer' => 'Sarah Jenkins', 'date' => 'May 10, 2026', 'items' => [['name' => 'Bird Cage Large', 'icon' => '🦜', 'qty' => 1, 'price' => 4500]]],
        ];
    @endphp

    {{-- Centered Custom Modal Popup --}}
    <div id="statusModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-[#2D241E]/50 backdrop-blur-sm" onclick="closeModal()"></div>
        
        {{-- Modal Content --}}
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
            <p class="text-gray-500 text-sm sm:text-base">Track and manage customer purchases for supplies and pets.</p>
        </div>
        <button onclick="showModal('📊', 'Exporting Data', 'Your orders report is being generated.')" class="bg-[#E68A39] text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-bold shadow-md hover:scale-105 transition-all text-sm w-fit">
            Export CSV
        </button>
    </div>

    {{-- Tabs Navigation — scrollable on mobile --}}
    <div class="overflow-x-auto pb-px mb-6 sm:mb-8">
        <div class="flex gap-2 sm:gap-4 border-b border-[#F3E9DC] min-w-max">
            @foreach(['pending', 'to-ship', 'completed'] as $tab)
                <button 
                    onclick="filterOrders('{{ $tab }}')" 
                    id="tab-{{ $tab }}" 
                    class="tab-btn px-4 sm:px-6 py-3 sm:py-4 border-b-4 transition-all uppercase text-[10px] tracking-[0.2em] font-bold whitespace-nowrap
                    {{ $tab === 'pending' ? 'border-[#E68A39] text-[#E68A39]' : 'border-transparent text-gray-400' }}">
                    {{ str_replace('-', ' ', $tab) }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Orders Container --}}
    <div id="orders-container" class="space-y-5 sm:space-y-8 pb-24">
        <!-- JS will render orders here -->
    </div>
</div>

<script>
    // Initialize data from PHP
    let ordersList = @json($orders);
    let currentTab = 'pending';

    function renderOrders() {
        const container = document.getElementById('orders-container');
        const filtered = ordersList.filter(o => o.status === currentTab);
        
        if (filtered.length === 0) {
            container.innerHTML = `<div class="text-center py-16 sm:py-20 text-gray-400 font-bold uppercase tracking-widest text-xs">No ${currentTab} orders found</div>`;
            return;
        }

        container.innerHTML = filtered.map(order => {
            let grandTotal = order.items.reduce((sum, item) => sum + (item.qty * item.price), 0);
            
            let actionBtn = '';
            if (order.status === 'pending') {
                actionBtn = `<button onclick="processOrder('${order.id}', 'to-ship')" class="bg-[#2D241E] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-2xl text-xs font-bold hover:bg-black transition-all shadow-lg">Approve Order</button>`;
            } else if (order.status === 'to-ship') {
                actionBtn = `<button onclick="processOrder('${order.id}', 'completed')" class="bg-[#E68A39] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-2xl text-xs font-bold transition-all shadow-lg shadow-orange-100">Ship Items</button>`;
            } else {
                actionBtn = `<div class="flex items-center gap-2 text-green-600"><span class="bg-green-100 p-1.5 rounded-full text-[8px]">✔</span><span class="text-[10px] font-bold uppercase tracking-widest">Delivered</span></div>`;
            }

            return `
                <div class="order-card bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 bg-[#FDF2E9]/40 border-b border-[#F3E9DC] flex flex-wrap justify-between items-center gap-2 sm:gap-4">
                        <div class="flex items-center gap-2 sm:gap-4">
                            <span class="bg-[#E68A39] text-white px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[10px] font-bold uppercase">#${order.id}</span>
                            <span class="text-xs text-[#A68B6D] font-bold uppercase">${order.date}</span>
                        </div>
                        <div class="text-xs sm:text-sm text-[#2D241E] font-bold">${order.customer}</div>
                    </div>
                    <div class="p-5 sm:p-10">
                        <table class="w-full">
                            <tbody>
                                ${order.items.map(item => `
                                    <tr class="border-b border-[#FDF8F1] last:border-0">
                                        <td class="py-3 sm:py-5 flex items-center gap-3 sm:gap-4">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#FDF8F1] rounded-xl sm:rounded-2xl flex items-center justify-center text-xl sm:text-2xl shrink-0">${item.icon}</div>
                                            <div>
                                                <p class="font-bold text-xs sm:text-sm">${item.name}</p>
                                                <p class="text-[10px] text-gray-400 uppercase font-bold">Qty: ${item.qty}</p>
                                            </div>
                                        </td>
                                        <td class="py-3 sm:py-5 text-right font-serif-brand text-base sm:text-lg whitespace-nowrap">₱${(item.qty * item.price).toLocaleString()}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                    <div class="px-5 sm:px-10 py-5 sm:py-8 bg-[#FDF8F1]/50 border-t border-[#F3E9DC] flex justify-between items-center flex-wrap gap-4">
                        <div>${actionBtn}</div>
                        <div class="text-right">
                            <p class="text-[9px] text-gray-400 uppercase font-bold tracking-[0.2em] mb-1">Grand Total</p>
                            <h2 class="text-2xl sm:text-3xl font-serif-brand text-[#E68A39]">₱${grandTotal.toLocaleString()}</h2>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function processOrder(id, newStatus) {
        const orderIndex = ordersList.findIndex(o => o.id === id);
        const customer = ordersList[orderIndex].customer;
        ordersList[orderIndex].status = newStatus;
        
        renderOrders();

        if (newStatus === 'to-ship') {
            showModal('🐕', 'Order Approved', `${customer}'s order is now ready for packing.`);
        } else if (newStatus === 'completed') {
            showModal('📦', 'Item Shipped', `Tracking info has been sent to ${customer}.`);
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
        const modal = document.getElementById('statusModal');
        const content = document.getElementById('modalContent');
        document.getElementById('modalIcon').innerText = icon;
        document.getElementById('modalTitle').innerText = title;
        document.getElementById('modalMessage').innerText = message;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-90', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('statusModal');
        const content = document.getElementById('modalContent');
        content.classList.add('scale-90', 'opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    // Initial Load
    document.addEventListener('DOMContentLoaded', renderOrders);
</script>
@endsection