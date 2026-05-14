@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="font-serif-modern text-3xl text-gray-800">Welcome Back!</h1>
    <p class="text-gray-500">Here is what's happening with PawHaven today.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="p-4 bg-orange-100 text-orange-600 rounded-2xl text-2xl">🐾</div>
        <div>
            <p class="text-sm text-gray-400 font-medium uppercase tracking-tight">Total Pets</p>
            <h3 class="text-2xl font-bold">500+</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="p-4 bg-green-100 text-green-600 rounded-2xl text-2xl">📅</div>
        <div>
            <p class="text-sm text-gray-400 font-medium uppercase tracking-tight">Years Active</p>
            <h3 class="text-2xl font-bold">10+</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="p-4 bg-blue-100 text-blue-600 rounded-2xl text-2xl">📋</div>
        <div>
            <p class="text-sm text-gray-400 font-medium uppercase tracking-tight">New Inquiries</p>
            <h3 class="text-2xl font-bold">12</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
    <div class="p-6 border-b border-gray-100">
        <h2 class="font-serif-modern text-xl text-gray-800">Recent Activity</h2>
    </div>
    <div class="p-20 text-center text-gray-400 italic">
        Activity logs will appear here...
    </div>
</div>
@endsection