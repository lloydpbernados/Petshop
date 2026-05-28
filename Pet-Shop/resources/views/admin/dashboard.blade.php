@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1]">

    <div class="mb-6 sm:mb-10">
        {{-- ✅ Displaying the Auth user's name here --}}
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#2D241E]">Welcome Back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-500 mt-2 text-sm sm:text-base">Here is what's happening with PawHaven today.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 mb-6 sm:mb-10">
        <div class="bg-white p-5 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-4 sm:gap-6">
            <div class="p-3 sm:p-4 bg-[#FDF2E9] text-[#E68A39] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">🐾</div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Pets</p>
                <h3 class="text-2xl sm:text-3xl font-bold text-[#2D241E]">{{ number_format($stats['total_pets']) }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-4 sm:gap-6">
            <div class="p-3 sm:p-4 bg-[#E9F7F2] text-[#34A853] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">📅</div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Years Active</p>
                <h3 class="text-2xl sm:text-3xl font-bold text-[#2D241E]">10+</h3>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-4 sm:gap-6 sm:col-span-2 md:col-span-1">
            <div class="p-3 sm:p-4 bg-[#E9F0FE] text-[#4285F4] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">📋</div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">New Inquiries</p>
                <h3 class="text-2xl sm:text-3xl font-bold text-[#2D241E]">{{ $stats['new_inquiries'] }}</h3>
            </div>
        </div>
    </div>

    {{-- Activity Feed Table --}}
    <div class="bg-white rounded-4xl sm:rounded-[3rem] border border-[#F3E9DC] shadow-sm overflow-hidden">
        <div class="p-5 sm:p-8 border-b border-[#FDF8F1] flex justify-between items-center">
            <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#2D241E]">Recent Activity</h2>
            <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-[#E68A39] uppercase tracking-widest hover:underline">View Orders</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-[#FDF8F1]/50 text-[10px] uppercase tracking-[0.15em] text-gray-400">
                        <th class="px-4 sm:px-8 py-4 font-bold">Activity</th>
                        <th class="px-4 sm:px-8 py-4 font-bold">User</th>
                        <th class="px-4 sm:px-8 py-4 font-bold hidden sm:table-cell">Details</th>
                        <th class="px-4 sm:px-8 py-4 font-bold hidden md:table-cell">Time</th>
                        <th class="px-4 sm:px-8 py-4 font-bold text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#FDF8F1]">
                    @forelse($recentActivities as $activity)
                    <tr class="hover:bg-[#FDF2E9]/20 transition-colors group">
                        <td class="px-4 sm:px-8 py-4 sm:py-5">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-base sm:text-lg">{{ $activity['icon'] }}</span>
                                <span class="text-xs sm:text-sm font-bold text-[#2D241E]">{{ $activity['type'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 sm:px-8 py-4 sm:py-5 text-xs sm:text-sm text-gray-600 font-medium whitespace-nowrap">{{ $activity['user'] }}</td>
                        <td class="px-4 sm:px-8 py-4 sm:py-5 text-xs sm:text-sm text-gray-500 hidden sm:table-cell max-w-[200px] truncate">{{ $activity['detail'] }}</td>
                        <td class="px-4 sm:px-8 py-4 sm:py-5 text-xs text-gray-400 font-bold tracking-tighter whitespace-nowrap hidden md:table-cell">{{ $activity['time'] }}</td>
                        <td class="px-4 sm:px-8 py-4 sm:py-5 text-right">
                            <span class="px-2 sm:px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest
                                {{ $activity['status'] === 'Alert' ? 'bg-red-50 text-red-500' : 'bg-[#F3E9DC] text-[#A68B6D]' }}">
                                {{ $activity['status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16 text-gray-400 text-sm">No recent activity yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection