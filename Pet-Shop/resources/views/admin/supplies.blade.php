@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="font-serif-modern text-3xl text-gray-800">Shop Supplies</h1>
    <p class="text-gray-500">Manage premium food, toys, and accessories.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <h2 class="font-serif-modern text-xl mb-4 text-green-800">Add New Item</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Image</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-green-400 transition cursor-pointer bg-gray-50">
                        <span class="text-gray-400 text-sm">Upload Photo</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                    <input type="text" placeholder="e.g. Organic Cat Nip" class="w-full p-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. of Items</label>
                    <input type="number" placeholder="0" class="w-full p-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (₱)</label>
                    <input type="number" placeholder="0.00" class="w-full p-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <button type="button" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition">
                    Add to Inventory
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-gray-400 font-bold">
                    <tr>
                        <th class="px-6 py-4">Item</th>
                        <th class="px-6 py-4">Stocks</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-xl">🛒</div>
                                <span class="font-bold text-gray-800 text-sm">Premium Leash</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-700">10</td>
                        <td class="px-6 py-4 text-sm font-bold text-green-700">₱850.00</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <button class="text-gray-400 hover:text-green-600 font-bold mr-2">Edit</button>
                            <button class="text-red-400 hover:text-red-600">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection