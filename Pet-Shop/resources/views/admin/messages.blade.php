@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1]">
    {{-- Header Section --}}
    <div class="mb-6 sm:mb-10">
        <div class="flex items-center gap-3 mb-2">
            <span class="text-2xl sm:text-3xl">✉️</span>
            <h1 class="font-serif-brand text-3xl sm:text-4xl font-bold text-[#2D241E]">Messages</h1>
        </div>
        <p class="text-gray-500 text-sm sm:text-base">Respond to customer inquiries and pet adoption requests.</p>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="msgModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#2D241E]/40 backdrop-blur-sm" onclick="toggleModal(false)"></div>
        <div class="relative bg-white rounded-4xl sm:rounded-[2.5rem] p-8 sm:p-10 max-w-sm w-full text-center shadow-2xl border border-[#F3E9DC] transform transition-all scale-95 opacity-0" id="msgModalContent">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-5 sm:mb-6">
                <span class="text-3xl sm:text-4xl">🗑️</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-serif-brand text-[#2D241E] mb-2">Conversation Deleted</h3>
            <p class="text-gray-500 text-sm mb-6 sm:mb-8">The chat history has been permanently removed.</p>
            <button onclick="toggleModal(false)" class="w-full bg-[#E68A39] text-white py-3 sm:py-4 rounded-2xl font-bold shadow-lg shadow-orange-200 hover:bg-[#cf7b32]">Understood</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
        {{-- Message List --}}
        <div class="lg:col-span-1 space-y-3 sm:space-y-4">
            <div class="bg-white p-3 sm:p-4 rounded-3xl sm:rounded-4xl border border-[#F3E9DC] shadow-sm">
                <input type="text" id="searchInput" onkeyup="filterContacts()" placeholder="Search inquiries..."
                       class="w-full bg-[#FDF8F1] border-none rounded-xl px-3 sm:px-4 py-2 text-sm focus:ring-1 focus:ring-[#E68A39]">
            </div>
            <div id="contactList" class="space-y-3 sm:space-y-4">
                <div class="text-center py-8 text-gray-400 text-sm">Loading conversations…</div>
            </div>
        </div>

        {{-- Message Conversation View --}}
        <div class="lg:col-span-2">
            <div id="chatInterface" class="hidden bg-white rounded-4xl sm:rounded-[3rem] border border-[#F3E9DC] shadow-sm  flex-col h-[500px] sm:h-[580px] lg:h-[650px]">
                <div class="p-4 sm:p-6 border-b border-[#FDF8F1] flex justify-between items-center" id="chatHeader"></div>
                <div class="flex-1 p-4 sm:p-8 overflow-y-auto space-y-4 sm:space-y-6 bg-[#FDFDFD]" id="chatWindow"></div>
                <div class="p-3 sm:p-6 border-t border-[#FDF8F1]">
                    <form onsubmit="sendMessage(event)" class="flex gap-2 sm:gap-4 items-center">
                        <input type="text" id="messageInput" placeholder="Write a reply..."
                               class="flex-1 bg-[#FDF8F1] border-none rounded-2xl px-4 sm:px-6 py-3 sm:py-4 focus:ring-2 focus:ring-[#E68A39] text-sm" required>
                        <button type="submit" class="bg-[#E68A39] text-white p-3 sm:p-4 rounded-2xl shadow-lg hover:bg-[#cf7529] transition-all text-base sm:text-lg shrink-0">
                            🚀
                        </button>
                    </form>
                </div>
            </div>
            <div id="emptyState" class="bg-white rounded-4xl sm:rounded-[3rem] border border-[#F3E9DC] h-[500px] sm:h-[580px] lg:h-[650px] flex flex-col items-center justify-center text-center p-8 sm:p-10">
                <span class="text-5xl sm:text-6xl mb-4">💬</span>
                <h3 class="text-xl sm:text-2xl font-serif-brand text-[#2D241E]">No conversation selected</h3>
                <p class="text-gray-400 text-sm mt-1">Select a contact from the list to start messaging.</p>
            </div>
        </div>
    </div>
</div>

<script>
    const API      = '/api/v1';
    const CSRF     = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    let conversations  = [];
    let activeChatId   = null;
    let activeMessages = [];

    // ── Fetch & Render Contacts ───────────────────────────────
    async function loadConversations() {
        try {
            const res  = await fetch(`${API}/conversations`);
            conversations = await res.json();
            renderContacts();
        } catch (e) {
            document.getElementById('contactList').innerHTML =
                '<p class="text-center text-red-400 py-10 text-sm">Failed to load conversations.</p>';
        }
    }

    function renderContacts() {
        const list = document.getElementById('contactList');
        if (!conversations.length) {
            list.innerHTML = '<p class="text-center text-gray-400 py-10 text-sm">No messages found.</p>';
            return;
        }
        list.innerHTML = conversations.map(chat => `
            <div onclick="switchChat(${chat.id})"
                 class="contact-item bg-white p-4 sm:p-5 rounded-3xl sm:rounded-4xl border-2 transition-all cursor-pointer relative
                        ${chat.id === activeChatId ? 'border-[#E68A39] shadow-md' : 'border-[#F3E9DC] shadow-sm hover:bg-[#FDF2E9]'}"
                 data-name="${chat.name.toLowerCase()}">
                <div class="flex justify-between items-start mb-1 sm:mb-2">
                    <h4 class="font-bold text-[#2D241E] text-sm sm:text-base">${chat.name}</h4>
                    <span class="text-[10px] text-gray-400">${chat.lastTime}</span>
                </div>
                <p class="text-xs ${chat.id === activeChatId ? 'text-[#E68A39]' : 'text-gray-400'} font-bold mb-1">${chat.category ?? ''}</p>
                <p class="text-xs sm:text-sm text-gray-500 line-clamp-1">${chat.lastMessage}</p>
                ${chat.id === activeChatId ? '<div class="absolute top-4 -left-1 w-2 h-7 sm:h-8 bg-[#E68A39] rounded-full"></div>' : ''}
            </div>
        `).join('');
    }

    // ── Fetch & Render Chat ───────────────────────────────────
    async function switchChat(id) {
        activeChatId = id;
        renderContacts();
        await loadChat(id);
    }

    async function loadChat(id) {
        const chatInterface = document.getElementById('chatInterface');
        const empty         = document.getElementById('emptyState');

        chatInterface.classList.remove('hidden');
        chatInterface.classList.add('flex');
        empty.classList.add('hidden');

        try {
            const res  = await fetch(`${API}/conversations/${id}/messages`);
            const data = await res.json();

            activeMessages = data.messages;
            const chat     = data.conversation;

            // Header
            document.getElementById('chatHeader').innerHTML = `
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#FDF2E9] rounded-xl sm:rounded-2xl flex items-center justify-center text-[#E68A39] font-bold text-sm sm:text-base">${chat.initials}</div>
                    <div>
                        <h3 class="font-serif-brand text-lg sm:text-xl text-[#2D241E]">${chat.name}</h3>
                        <p class="text-[10px] ${chat.status === 'Online' ? 'text-[#34A853]' : 'text-gray-400'} font-bold uppercase">${chat.status}</p>
                    </div>
                </div>
                <button onclick="deleteConversation(${chat.id})" class="text-gray-400 hover:text-red-500 text-lg sm:text-xl transition-colors p-1">🗑️</button>
            `;

            renderMessages();
        } catch (e) {
            document.getElementById('chatWindow').innerHTML =
                '<p class="text-center text-red-400 text-sm">Failed to load messages.</p>';
        }
    }

    function renderMessages() {
        const chatWindow = document.getElementById('chatWindow');
        chatWindow.innerHTML = activeMessages.map(msg => `
            <div class="flex flex-col ${msg.type === 'sent' ? 'items-end ml-auto' : 'items-start'} max-w-[85%] sm:max-w-[80%]">
                <div class="${msg.type === 'sent' ? 'bg-[#E68A39] text-white rounded-t-3xl rounded-bl-3xl shadow-md' : 'bg-[#FDF2E9] text-[#2D241E] rounded-t-3xl rounded-br-3xl shadow-sm'} p-3 sm:p-4 text-xs sm:text-sm">
                    ${msg.text}
                </div>
                <span class="text-[10px] text-gray-400 mt-1.5 sm:mt-2 ${msg.type === 'sent' ? 'mr-2' : 'ml-2'}">${msg.time}</span>
            </div>
        `).join('');
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }

    // ── Send Message ─────────────────────────────────────────
    async function sendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('messageInput');
        const text  = input.value.trim();
        if (!text || !activeChatId) return;

        input.value = '';

        try {
            const res  = await fetch(`${API}/conversations/${activeChatId}/messages`, {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body:    JSON.stringify({ text }),
            });
            const msg = await res.json();
            activeMessages.push(msg);
            renderMessages();

            // Refresh contact preview
            const convo = conversations.find(c => c.id === activeChatId);
            if (convo) { convo.lastMessage = msg.text; convo.lastTime = msg.time; }
            renderContacts();
        } catch (err) {
            console.error('Send failed', err);
        }
    }

    // ── Delete Conversation ──────────────────────────────────
    async function deleteConversation(id) {
        try {
            await fetch(`${API}/conversations/${id}`, {
                method:  'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF },
            });
        } catch (e) { /* optimistic delete still proceeds */ }

        conversations  = conversations.filter(c => c.id !== id);
        activeChatId   = conversations.length ? conversations[0].id : null;

        toggleModal(true);
        renderContacts();

        if (activeChatId) {
            await loadChat(activeChatId);
        } else {
            document.getElementById('chatInterface').classList.add('hidden');
            document.getElementById('chatInterface').classList.remove('flex');
            document.getElementById('emptyState').classList.remove('hidden');
        }
    }

    // ── Search Filter ────────────────────────────────────────
    function filterContacts() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.contact-item').forEach(item => {
            item.style.display = item.getAttribute('data-name').includes(query) ? 'block' : 'none';
        });
    }

    // ── Modal ────────────────────────────────────────────────
    function toggleModal(show) {
        const modal   = document.getElementById('msgModal');
        const content = document.getElementById('msgModalContent');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.add('scale-100', 'opacity-100');
                content.classList.remove('scale-95', 'opacity-0');
            }, 10);
        } else {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    }

    document.addEventListener('DOMContentLoaded', loadConversations);
</script>
@endsection