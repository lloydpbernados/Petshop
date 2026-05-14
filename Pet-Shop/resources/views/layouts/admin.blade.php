<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawHaven Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Modern Serif for headings */
        .font-serif-modern { font-family: 'Georgia', 'Times New Roman', serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="p-6 border-b border-gray-100">
                <h2 class="font-serif-modern text-2xl font-bold text-green-800">PawHaven</h2>
                <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Admin Portal</p>
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <a href="/admin/dashboard" 
                class="flex items-center p-3 rounded-lg transition {{ request()->is('admin/dashboard') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    Dashboard
                </a>

                <a href="/admin/inventory" 
                class="flex items-center p-3 rounded-lg transition {{ request()->is('admin/inventory') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    Pet Inventory
                </a>

                <a href="/admin/supplies" 
                class="flex items-center p-3 rounded-lg transition {{ request()->is('admin/supplies') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    Pet Supplies
                </a>

                <a href="/admin/services" 
                class="flex items-center p-3 rounded-lg transition {{ request()->is('admin/services') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    Services
                </a>

                <a href="/admin/inquiries" 
                class="flex items-center p-3 rounded-lg transition {{ request()->is('admin/inquiries') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    Messages
                </a>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <span class="font-serif-modern text-lg text-gray-600">Overview</span>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-700">John Lloyd Bernados</span>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">JB</div>
                </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>