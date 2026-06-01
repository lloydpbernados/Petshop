@extends('layouts.admin')

@section('page-title', 'Sales Monitoring')

@section('content')
<div class="max-w-7xl mx-auto" x-data="salesMonitoring()">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="font-serif-brand text-3xl text-[#2D241E]">💰 Sales Monitoring</h2>
        <p class="text-[#A68B6D] mt-1">Track your revenue with daily & monthly breakdowns</p>
    </div>

    <!-- Controls Card -->
    <div class="bg-white rounded-2xl border border-[#EBD7BC] p-5 mb-6 shadow-sm">
        <div class="flex flex-wrap gap-4 items-end">
            
            <!-- View Type -->
            <div>
                <label class="block text-xs font-bold text-[#A68B6D] uppercase tracking-wide mb-2">View Type</label>
                <select x-model="view" @change="fetchData" 
                        class="block w-48 rounded-xl border-[#EBD7BC] bg-[#FDF8F1] text-[#2D241E] shadow-sm focus:border-[#E68A39] focus:ring-[#E68A39] text-sm p-3 border">
                    <option value="monthly">📅 Monthly (Daily Breakdown)</option>
                    <option value="yearly">📆 Yearly (Monthly Breakdown)</option>
                </select>
            </div>

            <!-- Year -->
            <div>
                <label class="block text-xs font-bold text-[#A68B6D] uppercase tracking-wide mb-2">Year</label>
                <select x-model="year" @change="fetchData" 
                        class="block w-32 rounded-xl border-[#EBD7BC] bg-[#FDF8F1] text-[#2D241E] shadow-sm focus:border-[#E68A39] focus:ring-[#E68A39] text-sm p-3 border">
                    <template x-for="y in years" :key="y">
                        <option :value="y" x-text="y"></option>
                    </template>
                </select>
            </div>

            <!-- Month (only for monthly view) -->
            <div x-show="view === 'monthly'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <label class="block text-xs font-bold text-[#A68B6D] uppercase tracking-wide mb-2">Month</label>
                <select x-model="month" @change="fetchData" 
                        class="block w-40 rounded-xl border-[#EBD7BC] bg-[#FDF8F1] text-[#2D241E] shadow-sm focus:border-[#E68A39] focus:ring-[#E68A39] text-sm p-3 border">
                    <template x-for="(m, index) in months" :key="index">
                        <option :value="index + 1" x-text="m"></option>
                    </template>
                </select>
            </div>

            <!-- Refresh Button -->
            <button @click="fetchData" 
                    class="ml-auto px-5 py-3 bg-[#E68A39] hover:bg-[#D47A29] text-white font-bold rounded-xl shadow-sm transition-colors flex items-center gap-2 text-sm">
                <span>🔄</span> Refresh
            </button>
        </div>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="text-center py-12">
        <div class="inline-flex items-center gap-3 text-[#A68B6D]">
            <div class="w-5 h-5 border-2 border-[#E68A39] border-t-transparent rounded-full animate-spin"></div>
            <span class="font-medium">Loading sales data...</span>
        </div>
    </div>

    <!-- Error State -->
    <div x-show="error" class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-start gap-3" x-text="error"></div>

    <!-- Data Display -->
    <template x-if="!loading && salesData.length > 0">
        <div class="space-y-6">
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Revenue Card -->
                <div class="bg-linear-to-br from-[#F5E6D3] to-[#EBD7BC] p-6 rounded-2xl border border-[#EBD7BC] shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-[#A68B6D] uppercase tracking-wide">Total Revenue</p>
                            <p class="text-3xl font-serif-brand text-[#2D241E] mt-1" x-text="formatCurrency(totals.total_sales)"></p>
                        </div>
                        <span class="text-4xl opacity-60">💰</span>
                    </div>
                </div>
                
                <!-- Orders Card -->
                <div class="bg-linear-to-br from-[#E8F5E9] to-[#C8E6C9] p-6 rounded-2xl border border-[#A5D6A7] shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-[#66BB6A] uppercase tracking-wide">Total Orders</p>
                            <p class="text-3xl font-serif-brand text-[#1B5E20] mt-1" x-text="totals.orders.toLocaleString()"></p>
                        </div>
                        <span class="text-4xl opacity-60">📦</span>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-2xl border border-[#EBD7BC] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#F3E9DC]">
                        <thead class="bg-[#FDF8F1]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#A68B6D] uppercase tracking-wider" 
                                    x-text="view === 'monthly' ? '📅 Date' : '📆 Month'"></th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#A68B6D] uppercase tracking-wider">📦 Orders</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#A68B6D] uppercase tracking-wider">💰 Revenue</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#A68B6D] uppercase tracking-wider">📈 Avg. Order</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-[#F3E9DC]">
                            <template x-for="(item, index) in salesData" :key="index">
                                <tr class="hover:bg-[#FDF8F1] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#2D241E]" x-text="item.label"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#5C4D3C]" x-text="item.orders.toLocaleString()"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[#E68A39]" x-text="formatCurrency(item.total_sales)"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#5C4D3C]" 
                                        x-text="item.orders > 0 ? formatCurrency(item.total_sales / item.orders) : '$0.00'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                
                <!-- Empty State (if needed) -->
                <div x-show="salesData.length === 0 && !loading" class="text-center py-12 text-[#A68B6D]">
                    <p class="text-sm">No sales data found for this period.</p>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
<script>
function salesMonitoring() {
    return {
        view: 'monthly',
        year: new Date().getFullYear(),
        month: new Date().getMonth() + 1,
        salesData: [],
        totals: { orders: 0, total_sales: 0 },
        loading: false,
        error: null,
        years: Array.from({length: 5}, (_, i) => new Date().getFullYear() - 2 + i),
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],

        init() {
            this.fetchData();
        },

        async fetchData() {
            this.loading = true;
            this.error = null;
            try {
                const params = new URLSearchParams({ 
                    view: this.view, 
                    year: this.year,
                    _token: document.querySelector('meta[name="csrf-token"]').content
                });
                if (this.view === 'monthly') params.append('month', this.month);

                const res = await fetch(`{{ route('admin.sales.data') }}?${params}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (!res.ok) {
                    const errData = await res.json().catch(() => ({}));
                    throw new Error(errData.message || 'Failed to fetch sales data');
                }
                
                const json = await res.json();
                this.salesData = json.data;
                this.totals = json.totals;
            } catch (err) {
                console.error('Sales fetch error:', err);
                this.error = err.message;
                this.salesData = [];
                this.totals = { orders: 0, total_sales: 0 };
            } finally {
                this.loading = false;
            }
        },

        formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', { 
                style: 'currency', 
                currency: 'USD',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2 
            }).format(amount || 0);
        }
    }
}
</script>
@endpush
@endsection