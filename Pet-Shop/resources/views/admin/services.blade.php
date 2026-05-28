{{-- services.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1]">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-10 gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="text-2xl sm:text-3xl">✂️</span>
                <h1 class="font-serif-brand text-3xl sm:text-4xl font-bold text-[#2D241E]">Services</h1>
            </div>
            <p class="text-gray-500 text-sm sm:text-base">Manage grooming, training, and healthcare offerings for PawHaven.</p>
        </div>
        <button onclick="openServiceModal()" class="bg-[#E68A39] text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-bold shadow-lg hover:bg-[#cf7529] transition-all flex items-center gap-2 w-fit text-sm">
            <span class="text-lg sm:text-xl">+</span> Add New Service
        </button>
    </div>

    {{-- Services Grid --}}
    <div id="servicesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">
        {{-- Loading skeleton --}}
        <div class="col-span-full text-center py-16 text-gray-400">
            <div class="text-4xl mb-3 animate-pulse">✂️</div>
            <p class="text-sm">Loading services…</p>
        </div>
    </div>

    {{-- Empty State --}}
    <div id="emptyState" class="hidden flex-col items-center justify-center py-16 sm:py-20 text-gray-400">
        <span class="text-5xl sm:text-6xl mb-4">✨</span>
        <p class="text-base sm:text-lg">No services found. Start by adding one!</p>
    </div>
</div>

{{-- Main Service Modal (Add/Edit) --}}
<div id="serviceModal" class="fixed inset-0 bg-[#2D241E]/40 backdrop-blur-sm z-40 hidden items-center justify-center p-4">
    <div class="bg-white rounded-4xl sm:rounded-[2.5rem] p-6 sm:p-8 w-full max-w-[500px] shadow-2xl transform transition-all overflow-y-auto max-h-[90vh]">
        <div class="flex items-center justify-between mb-5 sm:mb-6">
            <h3 id="modalTitle" class="font-serif-brand text-xl sm:text-2xl text-[#2D241E]">Add New Service</h3>
            <button onclick="closeModal('serviceModal')" class="text-gray-400 hover:text-[#2D241E] hover:bg-[#FDF8F1] p-2 rounded-xl transition-colors">✕</button>
        </div>
        <div class="space-y-3 sm:space-y-4">
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Service Name</label>
                <input id="sName" type="text" placeholder="e.g. Full Grooming" class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
            </div>
            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Category Icon</label>
                    <select id="sIcon" class="w-full px-3 sm:px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm">
                        <option value="🛁">🛁 Grooming</option>
                        <option value="🎾">🎾 Training</option>
                        <option value="🩺">🩺 Health</option>
                        <option value="🏠">🏠 Boarding</option>
                        <option value="🚶">🚶 Walking</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Status</label>
                    <select id="sStatus" class="w-full px-3 sm:px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm">
                        <option value="Active">Active</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Price (PHP)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">₱</span>
                    <input id="sPrice" type="number" placeholder="0.00" class="w-full pl-8 pr-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Description</label>
                <textarea id="sDesc" rows="3" placeholder="Describe the service…" class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] resize-none text-sm"></textarea>
            </div>
        </div>
        <div class="flex gap-3 sm:gap-4 mt-6 sm:mt-8">
            <button onclick="closeModal('serviceModal')" class="flex-1 px-4 sm:px-6 py-3 border border-[#EBD7BC] text-[#5C4D3C] rounded-xl font-bold hover:bg-[#FDF8F1] transition-colors text-sm">Cancel</button>
            <button onclick="saveService()" id="saveBtn" class="flex-1 px-4 sm:px-6 py-3 bg-[#E68A39] text-white rounded-xl font-bold shadow-md hover:bg-[#cf7529] transition-colors text-sm">Save Service</button>
        </div>
    </div>
</div>

{{-- Confirmation/Alert Modal --}}
<div id="confirmModal" class="fixed inset-0 bg-[#2D241E]/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-4xl sm:rounded-[2.5rem] p-6 sm:p-8 w-full max-w-[400px] shadow-2xl text-center">
        <div id="confirmIcon" class="text-4xl sm:text-5xl mb-3 sm:mb-4">⚠️</div>
        <h3 id="confirmTitle" class="font-serif-brand text-xl sm:text-2xl text-[#2D241E] mb-2">Are you sure?</h3>
        <p id="confirmMessage" class="text-gray-500 text-sm mb-6 sm:mb-8">This action cannot be undone.</p>
        <div class="flex gap-3">
            <button onclick="closeModal('confirmModal')" id="cancelBtn" class="flex-1 px-4 sm:px-6 py-3 border border-[#F3E9DC] text-[#5C4D3C] rounded-xl font-bold hover:bg-[#FDF8F1] text-sm">No, Cancel</button>
            <button id="confirmBtn" class="flex-1 px-4 sm:px-6 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg text-sm">Yes, Delete</button>
        </div>
    </div>
</div>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-xl font-bold text-xs sm:text-sm transform translate-y-20 opacity-0 transition-all duration-300 flex items-center gap-3 pointer-events-none"></div>

<script>
    const API  = '/api/v1';
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    let services = [];
    let editId   = null;
    let pendingDeleteId = null;

    // ── Fetch services from API ──────────────────────────────
    async function loadServices() {
        try {
            const res = await fetch(`${API}/services`);
            services  = await res.json();
            renderServices();
        } catch (e) {
            document.getElementById('servicesGrid').innerHTML =
                '<p class="col-span-full text-center text-red-400 py-16 text-sm">Failed to load services.</p>';
        }
    }

    // ── Render grid ──────────────────────────────────────────
    function renderServices() {
        const grid  = document.getElementById('servicesGrid');
        const empty = document.getElementById('emptyState');

        if (!services.length) {
            grid.innerHTML = '';
            empty.classList.replace('hidden', 'flex');
            return;
        }

        empty.classList.replace('flex', 'hidden');
        grid.innerHTML = services.map(s => `
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-5 sm:mb-6">
                    <div class="p-3 sm:p-4 ${getIconBg(s.icon)} rounded-xl sm:rounded-2xl text-2xl sm:text-3xl group-hover:scale-110 transition-transform">${s.icon}</div>
                    <span class="${s.status === 'Active' ? 'bg-[#E9F7F2] text-[#34A853]' : 'bg-gray-100 text-gray-400'} text-[10px] font-bold uppercase px-3 py-1 rounded-full">${s.status}</span>
                </div>
                <h3 class="font-serif-brand text-xl sm:text-2xl text-[#2D241E] mb-2">${s.name}</h3>
                <p class="text-gray-500 text-xs sm:text-sm mb-5 sm:mb-6 leading-relaxed min-h-[40px]">${s.desc}</p>
                <div class="flex items-center justify-between border-t border-[#FDF8F1] pt-5 sm:pt-6">
                    <span class="text-lg sm:text-xl font-bold text-[#E68A39]">₱${parseFloat(s.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</span>
                    <div class="flex gap-1 sm:gap-2">
                        <button onclick="openServiceModal(${s.id})" class="p-2 hover:bg-[#FDF8F1] rounded-xl text-gray-400 hover:text-[#2D241E] transition-colors">⚙️</button>
                        <button onclick="promptDelete(${s.id})" class="p-2 hover:bg-red-50 rounded-xl text-gray-400 hover:text-red-500 transition-colors">🗑️</button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function getIconBg(icon) {
        const map = { '🛁': 'bg-[#FDF2E9]', '🎾': 'bg-[#E9F0FE]', '🩺': 'bg-[#FEE9E9]' };
        return map[icon] || 'bg-[#F3E9DC]';
    }

    // ── Modal helpers ────────────────────────────────────────
    function openServiceModal(id = null) {
        editId = id;
        if (id) {
            const s = services.find(x => x.id === id);
            document.getElementById('modalTitle').innerText = 'Edit Service';
            document.getElementById('sName').value   = s.name;
            document.getElementById('sIcon').value   = s.icon;
            document.getElementById('sStatus').value = s.status;
            document.getElementById('sPrice').value  = s.price;
            document.getElementById('sDesc').value   = s.desc;
        } else {
            document.getElementById('modalTitle').innerText = 'Add New Service';
            ['sName', 'sPrice', 'sDesc'].forEach(i => document.getElementById(i).value = '');
        }
        document.getElementById('serviceModal').classList.replace('hidden', 'flex');
    }

    function closeModal(id) {
        document.getElementById(id).classList.replace('flex', 'hidden');
    }

    // ── Save (create or update) ──────────────────────────────
    async function saveService() {
        const name = document.getElementById('sName').value.trim();
        const price = parseFloat(document.getElementById('sPrice').value);
        const desc  = document.getElementById('sDesc').value.trim();
        const icon  = document.getElementById('sIcon').value;
        const status = document.getElementById('sStatus').value;

        if (!name || isNaN(price) || !desc) {
            showAlert('Missing Info', 'Please provide a name, price, and description.');
            return;
        }

        const btn     = document.getElementById('saveBtn');
        btn.disabled  = true;
        btn.innerText = 'Saving…';

        try {
            const url    = editId ? `${API}/services/${editId}` : `${API}/services`;
            const method = editId ? 'PUT' : 'POST';

            const res  = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body:    JSON.stringify({ name, icon, status, price, description: desc }),
            });
            const saved = await res.json();

            if (editId) {
                const idx     = services.findIndex(x => x.id === editId);
                services[idx] = { ...services[idx], ...saved, desc: saved.description };
                showToast('Service updated!');
            } else {
                services.push({ ...saved, desc: saved.description });
                showToast('Service added!');
            }

            renderServices();
            closeModal('serviceModal');
        } catch (e) {
            showAlert('Error', 'Could not save service. Please try again.');
        } finally {
            btn.disabled  = false;
            btn.innerText = 'Save Service';
        }
    }

    // ── Delete ───────────────────────────────────────────────
    function promptDelete(id) {
        pendingDeleteId = id;
        document.getElementById('confirmIcon').innerText    = '🗑️';
        document.getElementById('confirmTitle').innerText   = 'Remove Service?';
        document.getElementById('confirmMessage').innerText = 'This will permanently delete this service.';
        const btn = document.getElementById('confirmBtn');
        btn.innerText  = 'Yes, Delete';
        btn.className  = 'flex-1 px-4 sm:px-6 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg text-sm';
        btn.onclick    = executeDelete;
        document.getElementById('cancelBtn').classList.remove('hidden');
        document.getElementById('confirmModal').classList.replace('hidden', 'flex');
    }

    async function executeDelete() {
        try {
            await fetch(`${API}/services/${pendingDeleteId}`, {
                method:  'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF },
            });
        } catch (e) { /* optimistic */ }

        services = services.filter(x => x.id !== pendingDeleteId);
        renderServices();
        closeModal('confirmModal');
        showToast('Service removed.', 'error');
    }

    function showAlert(title, msg) {
        document.getElementById('confirmIcon').innerText    = '❌';
        document.getElementById('confirmTitle').innerText   = title;
        document.getElementById('confirmMessage').innerText = msg;
        const btn = document.getElementById('confirmBtn');
        btn.innerText = 'Okay';
        btn.className = 'flex-1 px-4 sm:px-6 py-3 bg-[#2D241E] text-white rounded-xl font-bold text-sm';
        btn.onclick   = () => closeModal('confirmModal');
        document.getElementById('cancelBtn').classList.add('hidden');
        document.getElementById('confirmModal').classList.replace('hidden', 'flex');
    }

    function showToast(msg, type = 'success') {
        const t = document.getElementById('toast');
        t.innerText = msg;
        t.className = `fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-xl font-bold text-xs sm:text-sm transform transition-all duration-300 flex items-center gap-3 pointer-events-none ${type === 'success' ? 'bg-[#34A853] text-white' : 'bg-red-500 text-white'}`;
        t.classList.remove('translate-y-20', 'opacity-0');
        setTimeout(() => t.classList.add('translate-y-20', 'opacity-0'), 3000);
    }

    document.addEventListener('DOMContentLoaded', loadServices);
</script>
@endsection