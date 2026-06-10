@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1] px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">

    {{-- Welcome Section --}}
    <div class="mb-6 sm:mb-8 lg:mb-10">
        <h1 class="font-serif text-2xl sm:text-3xl md:text-4xl font-bold text-[#2D241E] leading-tight">
            Welcome Back, {{ Auth::user()->name }}!
        </h1>
        <p class="text-gray-500 mt-2 text-sm sm:text-base">Here is what's happening with PawHaven today.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 mb-6 sm:mb-8 lg:mb-10">
        
        {{-- Total Pets --}}
        <div class="bg-white p-4 sm:p-5 lg:p-6 rounded-2xl sm:rounded-3xl lg:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-3 sm:gap-4 lg:gap-6 hover:shadow-md transition-shadow">
            <div class="p-3 sm:p-4 bg-[#FDF2E9] text-[#E68A39] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">
                🐾
            </div>
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-widest">Total Pets</p>
                <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#2D241E] truncate">
                    {{ number_format($stats['total_pets']) }}
                </h3>
            </div>
        </div>

        {{-- Years Active --}}
        <div class="bg-white p-4 sm:p-5 lg:p-6 rounded-2xl sm:rounded-3xl lg:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-3 sm:gap-4 lg:gap-6 hover:shadow-md transition-shadow">
            <div class="p-3 sm:p-4 bg-[#E9F7F2] text-[#34A853] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">
                📅
            </div>
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-widest">Years Active</p>
                <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#2D241E]">10+</h3>
            </div>
        </div>

        {{-- New Inquiries --}}
        <div class="bg-white p-4 sm:p-5 lg:p-6 rounded-2xl sm:rounded-3xl lg:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-3 sm:gap-4 lg:gap-6 sm:col-span-2 lg:col-span-1 hover:shadow-md transition-shadow">
            <div class="p-3 sm:p-4 bg-[#E9F0FE] text-[#4285F4] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">
                📋
            </div>
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-widest">New Inquiries</p>
                <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#2D241E]">
                    {{ $stats['new_inquiries'] }}
                </h3>
            </div>
        </div>
    </div>

    {{-- Activity Feed Table --}}
    <div class="bg-white rounded-2xl sm:rounded-3xl lg:rounded-[3rem] border border-[#F3E9DC] shadow-sm overflow-hidden">
        
        {{-- Header --}}
        <div class="p-4 sm:p-5 lg:p-8 border-b border-[#FDF8F1] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0">
            <h2 class="font-serif text-lg sm:text-xl lg:text-2xl font-bold text-[#2D241E]">Recent Activity</h2>
            <a href="{{ route('admin.orders') }}" 
               class="inline-flex items-center gap-2 text-xs font-bold text-[#E68A39] uppercase tracking-widest hover:underline py-2 px-3 -mx-3">
                View Orders
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Mobile Cards (visible on small screens) --}}
        <div class="sm:hidden divide-y divide-[#FDF8F1]">
            @forelse($recentActivities as $activity)
            <div class="p-4 hover:bg-[#FDF2E9]/20 transition-colors">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-base">{{ $activity['icon'] }}</span>
                        <span class="text-sm font-bold text-[#2D241E]">{{ $activity['type'] }}</span>
                    </div>
                    <span class="px-2 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest shrink-0
                        {{ $activity['status'] === 'Alert' ? 'bg-red-50 text-red-500' : 'bg-[#F3E9DC] text-[#A68B6D]' }}">
                        {{ $activity['status'] }}
                    </span>
                </div>
                <div class="ml-7 space-y-1">
                    <p class="text-xs text-gray-600 font-medium">{{ $activity['user'] }}</p>
                    <p class="text-xs text-gray-500 line-clamp-2">{{ $activity['detail'] }}</p>
                    <p class="text-[10px] text-gray-400 font-bold">{{ $activity['time'] }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400 text-sm">No recent activity yet.</div>
            @endforelse
        </div>

        {{-- Desktop Table (hidden on small screens) --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-[#FDF8F1]/50 text-[10px] uppercase tracking-[0.15em] text-gray-400">
                        <th class="px-4 sm:px-6 lg:px-8 py-4 font-bold">Activity</th>
                        <th class="px-4 sm:px-6 lg:px-8 py-4 font-bold">User</th>
                        <th class="px-4 sm:px-6 lg:px-8 py-4 font-bold hidden md:table-cell">Details</th>
                        <th class="px-4 sm:px-6 lg:px-8 py-4 font-bold hidden lg:table-cell">Time</th>
                        <th class="px-4 sm:px-6 lg:px-8 py-4 font-bold text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#FDF8F1]">
                    @forelse($recentActivities as $activity)
                    <tr class="hover:bg-[#FDF2E9]/20 transition-colors group">
                        <td class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-base sm:text-lg">{{ $activity['icon'] }}</span>
                                <span class="text-xs sm:text-sm font-bold text-[#2D241E]">{{ $activity['type'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5 text-xs sm:text-sm text-gray-600 font-medium whitespace-nowrap">
                            {{ $activity['user'] }}
                        </td>
                        <td class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5 text-xs sm:text-sm text-gray-500 hidden md:table-cell max-w-[200px] truncate">
                            {{ $activity['detail'] }}
                        </td>
                        <td class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5 text-xs text-gray-400 font-bold tracking-tighter whitespace-nowrap hidden lg:table-cell">
                            {{ $activity['time'] }}
                        </td>
                        <td class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5 text-right">
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