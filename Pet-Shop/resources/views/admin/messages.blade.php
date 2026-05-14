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
                <input type="text" id="searchInput" onkeyup="filterContacts()" placeholder="Search inquiries..." class="w-full bg-[#FDF8F1] border-none rounded-xl px-3 sm:px-4 py-2 text-sm focus:ring-1 focus:ring-[#E68A39]">
            </div>

            <div id="contactList" class="space-y-3 sm:space-y-4">
                <!-- Contacts will be rendered by JS -->
            </div>
        </div>

        {{-- Message Conversation View --}}
        <div class="lg:col-span-2">
            <div id="chatInterface" class=" bg-white rounded-4xl sm:rounded-[3rem] border border-[#F3E9DC] shadow-sm flex flex-col h-[500px] sm:h-[580px] lg:h-[650px]">
                <!-- Chat Header -->
                <div class="p-4 sm:p-6 border-b border-[#FDF8F1] flex justify-between items-center" id="chatHeader">
                    <!-- Dynamic Header -->
                </div>

                <!-- Chat Bubbles -->
                <div class="flex-1 p-4 sm:p-8 overflow-y-auto space-y-4 sm:space-y-6 bg-[#FDFDFD]" id="chatWindow">
                    <!-- Messages will be rendered here -->
                </div>

                <!-- Reply Input -->
                <div class="p-3 sm:p-6 border-t border-[#FDF8F1]">
                    <form onsubmit="sendMessage(event)" class="flex gap-2 sm:gap-4 items-center">
                        <input type="text" id="messageInput" placeholder="Write a reply..." class="flex-1 bg-[#FDF8F1] border-none rounded-2xl px-4 sm:px-6 py-3 sm:py-4 focus:ring-2 focus:ring-[#E68A39] text-sm" required>
                        <button type="submit" class="bg-[#E68A39] text-white p-3 sm:p-4 rounded-2xl shadow-lg hover:bg-[#cf7529] transition-all text-base sm:text-lg shrink-0">
                            🚀
                        </button>
                    </form>
                </div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="bg-white rounded-4xl sm:rounded-[3rem] border border-[#F3E9DC] h-[500px] sm:h-[580px] lg:h-[650px] flex flex-col items-center justify-center text-center p-8 sm:p-10">
                <span class="text-5xl sm:text-6xl mb-4">💬</span>
                <h3 class="text-xl sm:text-2xl font-serif-brand text-[#2D241E]">No conversation selected</h3>
                <p class="text-gray-400 text-sm mt-1">Select a contact from the list to start messaging.</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Initial Mock Data
    let conversations = [
        {
            id: 1,
            name: "Maria Santos",
            initials: "MS",
            status: "Online",
            category: "Inquiry: Golden Retriever",
            messages: [
                { type: 'received', text: "Hi PawHaven! I saw the Golden Retriever on your landing page. Is he still available for adoption? 🐾", time: "9:30 AM" },
                { type: 'sent', text: "Hello Maria! Yes, he is still available. Would you like to schedule a visit to meet him?", time: "9:45 AM" }
            ]
        },
        {
            id: 2,
            name: "Kevin Lee",
            initials: "KL",
            status: "Away",
            category: "Service: Grooming",
            messages: [
                { type: 'received', text: "Do you have available slots for grooming this weekend?", time: "Yesterday" }
            ]
        }
    ];

    let activeChatId = null;

    function renderContacts() {
        const list = document.getElementById('contactList');
        if (conversations.length === 0) {
            list.innerHTML = '<p class="text-center text-gray-400 py-10 text-sm">No messages found.</p>';
            return;
        }

        list.innerHTML = conversations.map(chat => `
            <div onclick="switchChat(${chat.id})" class="contact-item bg-white p-4 sm:p-5 rounded-3xl sm:rounded-4xl border-2 transition-all cursor-pointer relative ${chat.id === activeChatId ? 'border-[#E68A39] shadow-md' : 'border-[#F3E9DC] shadow-sm hover:bg-[#FDF2E9]'}" data-name="${chat.name.toLowerCase()}">
                <div class="flex justify-between items-start mb-1 sm:mb-2">
                    <h4 class="font-bold text-[#2D241E] text-sm sm:text-base">${chat.name}</h4>
                    <span class="text-[10px] text-gray-400">active</span>
                </div>
                <p class="text-xs ${chat.id === activeChatId ? 'text-[#E68A39]' : 'text-gray-400'} font-bold mb-1">${chat.category}</p>
                <p class="text-xs sm:text-sm text-gray-500 line-clamp-1">${chat.messages[chat.messages.length - 1].text}</p>
                ${chat.id === activeChatId ? '<div class="absolute top-4 -left-1 w-2 h-7 sm:h-8 bg-[#E68A39] rounded-full"></div>' : ''}
            </div>
        `).join('');
    }

    function renderChat() {
        const chatInterface = document.getElementById('chatInterface');
        const empty = document.getElementById('emptyState');
        
        if (!activeChatId) {
            chatInterface.classList.add('hidden');
            chatInterface.classList.remove('flex');
            empty.classList.remove('hidden');
            return;
        }

        chatInterface.classList.remove('hidden');
        chatInterface.classList.add('flex');
        empty.classList.add('hidden');

        const chat = conversations.find(c => c.id === activeChatId);
        
        // Render Header with Functional Delete
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

        // Render Messages
        const chatWindow = document.getElementById('chatWindow');
        chatWindow.innerHTML = chat.messages.map(msg => `
            <div class="flex flex-col ${msg.type === 'sent' ? 'items-end ml-auto' : 'items-start'} max-w-[85%] sm:max-w-[80%]">
                <div class="${msg.type === 'sent' ? 'bg-[#E68A39] text-white rounded-t-3xl rounded-bl-3xl shadow-md' : 'bg-[#FDF2E9] text-[#2D241E] rounded-t-3xl rounded-br-3xl shadow-sm'} p-3 sm:p-4 text-xs sm:text-sm">
                    ${msg.text}
                </div>
                <span class="text-[10px] text-gray-400 mt-1.5 sm:mt-2 ${msg.type === 'sent' ? 'mr-2' : 'ml-2'}">${msg.time}</span>
            </div>
        `).join('');
        
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }

    function deleteConversation(id) {
        conversations = conversations.filter(c => c.id !== id);
        activeChatId = conversations.length > 0 ? conversations[0].id : null;
        
        toggleModal(true);
        renderContacts();
        renderChat();
    }

    function switchChat(id) {
        activeChatId = id;
        renderContacts();
        renderChat();
    }

    function sendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('messageInput');
        if (!input.value.trim() || !activeChatId) return;

        const chat = conversations.find(c => c.id === activeChatId);
        const now = new Date();
        const timeStr = now.getHours() + ":" + now.getMinutes().toString().padStart(2, '0') + (now.getHours() >= 12 ? ' PM' : ' AM');

        chat.messages.push({
            type: 'sent',
            text: input.value,
            time: timeStr
        });

        input.value = '';
        renderChat();
        renderContacts();
    }

    function filterContacts() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.contact-item').forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(query) ? 'block' : 'none';
        });
    }

    function toggleModal(show) {
        const modal = document.getElementById('msgModal');
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

    document.addEventListener('DOMContentLoaded', () => {
        renderContacts();
        renderChat();
    });
</script>
@endsection