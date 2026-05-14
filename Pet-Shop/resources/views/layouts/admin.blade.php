<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawHaven Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for Sidebar Toggle Logic -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap');
        .font-serif-brand { font-family: 'DM Serif Display', serif; }
        
        /* Smooth scrolling for chat/content areas */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #EBD7BC; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#FDF8F1] text-[#2D241E] font-sans overflow-x-hidden" x-data="{ mobileMenuOpen: false }">
    <div class="flex min-h-screen relative">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-[#2D241E]/50 backdrop-blur-sm z-40 lg:hidden"
             @click="mobileMenuOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed lg:sticky top-0 left-0 z-50 w-64 xl:w-72 h-screen bg-[#F5E6D3] border-r border-[#EBD7BC] flex flex-col shadow-sm transition-transform duration-300 ease-in-out">
            
            <div class="p-6 xl:p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🐾</span>
                        <h2 class="font-serif-brand text-2xl xl:text-3xl text-[#2D241E]">PawHaven</h2>
                    </div>
                    <!-- Close button for mobile -->
                    <button @click="mobileMenuOpen = false" class="lg:hidden w-8 h-8 flex items-center justify-center rounded-xl bg-[#EBD7BC] text-[#2D241E] font-bold text-lg leading-none">✕</button>
                </div>
                <p class="text-[10px] text-[#A68B6D] uppercase tracking-[0.3em] font-bold mt-2 ml-9">Admin Portal</p>
            </div>
            
            <nav class="flex-1 px-4 xl:px-6 space-y-1 overflow-y-auto custom-scrollbar">
                @php
                    $navItems = [
                        ['url' => '/admin/dashboard', 'label' => 'Dashboard', 'icon' => '📊'],
                        ['url' => '/admin/inventory', 'label' => 'Pet Inventory', 'icon' => '🐕'],
                        ['url' => '/admin/supplies', 'label' => 'Pet Supplies', 'icon' => '🦴'],
                        ['url' => '/admin/services', 'label' => 'Services', 'icon' => '✂️'],
                        ['url' => '/admin/orders', 'label' => 'Orders', 'icon' => '📦'],
                        ['url' => '/admin/inquiries', 'label' => 'Messages', 'icon' => '✉️'],
                    ];
                @endphp

                @foreach($navItems as $item)
                <a href="{{ $item['url'] }}" 
                   class="flex items-center gap-3 xl:gap-4 px-4 xl:px-6 py-3 xl:py-4 rounded-2xl transition-all duration-200 
                   {{ request()->is(ltrim($item['url'], '/')) 
                      ? 'bg-[#E68A39] text-white font-bold shadow-md' 
                      : 'text-[#5C4D3C] hover:bg-[#EBD7BC] hover:text-[#2D241E]' }}">
                    <span class="text-lg xl:text-xl {{ request()->is(ltrim($item['url'], '/')) ? 'opacity-100' : 'opacity-70' }}">
                        {{ $item['icon'] }}
                    </span>
                    <span class="text-sm tracking-tight">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </nav>

            <!-- User Profile at Bottom -->
            <div class="p-6 xl:p-8 border-t border-[#EBD7BC]">
                <div class="flex items-center gap-3 xl:gap-4">
                    <div class="w-10 h-10 xl:w-12 xl:h-12 bg-white rounded-2xl flex items-center justify-center text-[#E68A39] font-bold shadow-sm shrink-0 text-sm">
                        JB
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-[#2D241E] truncate">John Lloyd Bernados</p>
                        <p class="text-[10px] text-[#A68B6D] uppercase font-bold">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 w-full">
            <!-- Header -->
            <header class="h-16 sm:h-20 bg-white border-b border-[#F3E9DC] flex items-center justify-between px-4 sm:px-6 lg:px-10 sticky top-0 z-30">
                <div class="flex items-center gap-3 xl:gap-4">
                    <!-- Hamburger Button — visible on all screens smaller than lg -->
                    <button @click="mobileMenuOpen = true" class="lg:hidden p-2 rounded-xl bg-[#FDF8F1] text-[#E68A39]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                    <span class="font-serif-brand text-lg sm:text-xl text-[#2D241E] opacity-60">Overview</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="hidden sm:block text-[10px] font-bold text-[#A68B6D] uppercase tracking-widest">Active Session</span>
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="p-4 sm:p-6 lg:p-10 overflow-x-hidden">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>