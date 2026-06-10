{{-- services.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1]">

    {{-- Page Tabs --}}
    <div class="flex gap-1 sm:gap-2 mb-6 sm:mb-10 border-b border-[#F3E9DC] overflow-x-auto pb-px -mx-3 sm:mx-0 px-3 sm:px-0">
        <button onclick="switchTab('services')" id="tab-services"
                class="tab-main-btn px-4 sm:px-8 py-2.5 sm:py-4 border-b-4 border-[#E68A39] text-[#E68A39] text-[10px] sm:text-xs tracking-[0.15em] font-bold whitespace-nowrap transition-all">
            ✂️ Services
        </button>
        <button onclick="switchTab('bookings')" id="tab-bookings"
                class="tab-main-btn px-4 sm:px-8 py-2.5 sm:py-4 border-b-4 border-transparent text-gray-400 text-[10px] sm:text-xs tracking-[0.15em] font-bold whitespace-nowrap transition-all">
            📅 Booking Schedule
        </button>
    </div>

    {{-- ══════════════════════════════════════════
         TAB 1: SERVICES
    ══════════════════════════════════════════ --}}
    <div id="page-services">
        <div class="flex flex-col gap-4 mb-6 sm:mb-10 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 sm:gap-3 mb-1 sm:mb-2">
                    <span class="text-xl sm:text-3xl">✂️</span>
                    <h1 class="font-serif-brand text-2xl sm:text-4xl font-bold text-[#2D241E] leading-tight">Services</h1>
                </div>
                <p class="text-gray-500 text-xs sm:text-base">Manage grooming, training, and healthcare offerings for PawHaven.</p>
            </div>
            <button onclick="openServiceModal()"
                    class="w-full sm:w-auto bg-[#E68A39] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-full font-bold shadow-lg hover:bg-[#cf7529] transition-all flex items-center justify-center gap-2 text-sm">
                <span class="text-lg sm:text-xl">+</span> Add New Service
            </button>
        </div>

        <div id="servicesGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            <div class="col-span-full text-center py-16 text-gray-400">
                <div class="text-4xl mb-3 animate-pulse">✂️</div>
                <p class="text-sm">Loading services…</p>
            </div>
        </div>

        <div id="emptyState" class="hidden flex-col items-center justify-center py-16 sm:py-20 text-gray-400">
            <span class="text-5xl sm:text-6xl mb-4">✨</span>
            <p class="text-sm sm:text-base">No services found. Start by adding one!</p>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         TAB 2: BOOKING SCHEDULE
    ══════════════════════════════════════════ --}}
    <div id="page-bookings" class="hidden">
        <div class="flex flex-col gap-4 mb-6 sm:mb-10 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 sm:gap-3 mb-1 sm:mb-2">
                    <span class="text-xl sm:text-3xl">📅</span>
                    <h1 class="font-serif-brand text-2xl sm:text-4xl font-bold text-[#2D241E] leading-tight">Booking Schedule</h1>
                </div>
                <p class="text-gray-500 text-xs sm:text-base">Set open dates, daily slot limits, and view customer bookings.</p>
            </div>
            <button onclick="openScheduleModal()"
                    class="w-full sm:w-auto bg-[#2D241E] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-full font-bold shadow-lg hover:bg-black transition-all flex items-center justify-center gap-2 text-sm">
                <span class="text-lg sm:text-xl">+</span> Open New Date(s)
            </button>
        </div>

        {{-- Schedule Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-10">
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-[#F3E9DC] shadow-sm">
                <div class="text-xl sm:text-2xl mb-2">📅</div>
                <div class="text-xl sm:text-2xl font-bold text-[#2D241E]" id="stat-open-dates">—</div>
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Open Dates</div>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-[#F3E9DC] shadow-sm">
                <div class="text-xl sm:text-2xl mb-2">🐾</div>
                <div class="text-xl sm:text-2xl font-bold text-[#2D241E]" id="stat-total-bookings">—</div>
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Total Bookings</div>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-[#F3E9DC] shadow-sm">
                <div class="text-xl sm:text-2xl mb-2">✅</div>
                <div class="text-xl sm:text-2xl font-bold text-[#34A853]" id="stat-confirmed">—</div>
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Confirmed</div>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-[#F3E9DC] shadow-sm">
                <div class="text-xl sm:text-2xl mb-2">⏳</div>
                <div class="text-xl sm:text-2xl font-bold text-[#E68A39]" id="stat-pending-bookings">—</div>
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Pending</div>
            </div>
        </div>

        {{-- Schedule Table --}}
        <div class="bg-white rounded-2xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm overflow-hidden mb-6 sm:mb-10">
            <div class="p-4 sm:p-6 border-b border-[#FDF8F1] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <h3 class="font-serif-brand text-lg sm:text-xl text-[#2D241E]">Open Dates & Slots</h3>
                <div class="flex gap-2 flex-wrap">
                    <select id="schedServiceFilter" onchange="renderSchedules()"
                            class="px-3 py-2 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-xs font-bold text-[#5C4D3C] focus:outline-none focus:border-[#E68A39] cursor-pointer">
                        <option value="">All Services</option>
                    </select>
                    <select id="schedStatusFilter" onchange="renderSchedules()"
                            class="px-3 py-2 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-xs font-bold text-[#5C4D3C] focus:outline-none focus:border-[#E68A39] cursor-pointer">
                        <option value="">All Status</option>
                        <option value="open">Open</option>
                        <option value="full">Full</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>

            {{-- Mobile Cards --}}
            <div id="scheduleMobileCards" class="sm:hidden p-4 space-y-4"></div>

            {{-- Desktop Table --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full min-w-[700px] text-left border-collapse">
                    <thead>
                        <tr class="bg-[#FDF8F1]">
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Date</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Service</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Slots</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Booked</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Status</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="scheduleTableBody" class="divide-y divide-[#FDF8F1]">
                        <tr><td colspan="6" class="text-center py-12 text-gray-400 text-sm">Loading…</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bookings List --}}
        <div class="bg-white rounded-2xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-[#FDF8F1] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <h3 class="font-serif-brand text-lg sm:text-xl text-[#2D241E]">Customer Bookings</h3>
                <div class="flex gap-2 flex-wrap">
                    <input type="date" id="bookingDateFilter" onchange="renderBookings()"
                           class="px-3 py-2 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-xs font-bold text-[#5C4D3C] focus:outline-none focus:border-[#E68A39]">
                    <select id="bookingStatusFilter" onchange="renderBookings()"
                            class="px-3 py-2 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-xs font-bold text-[#5C4D3C] focus:outline-none focus:border-[#E68A39] cursor-pointer">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            <div id="bookingsList" class="divide-y divide-[#FDF8F1]">
                <div class="text-center py-12 text-gray-400 text-sm">Loading bookings…</div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL: ADD / EDIT SERVICE
══════════════════════════════════════════ --}}
<div id="serviceModal" class="fixed inset-0 bg-[#2D241E]/40 backdrop-blur-sm z-40 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 w-full max-w-[500px] shadow-2xl overflow-y-auto max-h-[92vh]">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <h3 id="modalTitle" class="font-serif-brand text-lg sm:text-2xl text-[#2D241E]">Add New Service</h3>
            <button onclick="closeModal('serviceModal')" class="text-gray-400 hover:text-[#2D241E] hover:bg-[#FDF8F1] p-2 rounded-xl transition-colors">✕</button>
        </div>
        <div class="space-y-3 sm:space-y-4">

            {{-- ── IMAGE UPLOAD ── --}}
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-1.5 sm:mb-2">Service Photo</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    {{-- Preview box — shows uploaded image or icon emoji --}}
                    <div id="sImagePreview"
                         class="w-20 h-20 rounded-2xl bg-[#FDF8F1] border-2 border-dashed border-[#F3E9DC] flex items-center justify-center text-3xl shrink-0 overflow-hidden">
                        <span id="sPreviewPlaceholder">📸</span>
                    </div>
                    <div class="flex-1 w-full">
                        <label class="inline-flex items-center gap-2 px-4 py-2 bg-[#FDF8F1] border border-[#F3E9DC] text-[#5C4D3C] rounded-xl text-xs font-bold cursor-pointer hover:bg-[#EBD7BC]/30 transition-colors">
                            📁 Choose Photo
                            <input id="sImage" type="file" accept="image/*" class="hidden" onchange="handleServiceImageUpload(event)"/>
                        </label>
                        <p class="text-[10px] text-gray-400 mt-2 italic">JPG, PNG or WEBP · Max 2MB · Square recommended</p>
                        {{-- Clear button shown only when an image is selected --}}
                        <button id="sClearImage" type="button" onclick="clearServiceImage()"
                                class="hidden mt-2 text-[10px] text-red-400 hover:text-red-600 font-bold underline">
                            ✕ Remove photo
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-1.5 sm:mb-2">Service Name</label>
                <input id="sName" type="text" placeholder="e.g. Full Grooming"
                       class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
            </div>
            <div class="grid grid-cols-2 gap-2 sm:gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-1.5 sm:mb-2">Category Icon</label>
                    <select id="sIcon" class="w-full px-2 sm:px-4 py-2.5 sm:py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm">
                        <option value="🛁">🛁 Grooming</option>
                        <option value="🎾">🎾 Training</option>
                        <option value="🩺">🩺 Health</option>
                        <option value="🏠">🏠 Boarding</option>
                        <option value="🚶">🚶 Walking</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-1.5 sm:mb-2">Status</label>
                    <select id="sStatus" class="w-full px-2 sm:px-4 py-2.5 sm:py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm">
                        <option value="Active">Active</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-1.5 sm:mb-2">Price (PHP)</label>
                <div class="relative">
                    <span class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">₱</span>
                    <input id="sPrice" type="number" placeholder="0.00"
                           class="w-full pl-7 sm:pl-8 pr-3 sm:pr-4 py-2.5 sm:py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-1.5 sm:mb-2">Description</label>
                <textarea id="sDesc" rows="3" placeholder="Describe the service…"
                          class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] resize-none text-sm"></textarea>
            </div>
        </div>
        <div class="flex gap-2 sm:gap-4 mt-5 sm:mt-8">
            <button onclick="closeModal('serviceModal')"
                    class="flex-1 px-3 sm:px-6 py-2.5 sm:py-3 border border-[#EBD7BC] text-[#5C4D3C] rounded-xl font-bold hover:bg-[#FDF8F1] transition-colors text-sm">Cancel</button>
            <button onclick="saveService()" id="saveBtn"
                    class="flex-1 px-3 sm:px-6 py-2.5 sm:py-3 bg-[#E68A39] text-white rounded-xl font-bold shadow-md hover:bg-[#cf7529] transition-colors text-sm">Save Service</button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL: OPEN NEW DATE(S) / SCHEDULE
══════════════════════════════════════════ --}}
<div id="scheduleModal" class="fixed inset-0 bg-[#2D241E]/40 backdrop-blur-sm z-40 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 w-full max-w-[520px] shadow-2xl overflow-y-auto max-h-[92vh]">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <h3 id="schedModalTitle" class="font-serif-brand text-lg sm:text-2xl text-[#2D241E]">Open New Date(s)</h3>
            <button onclick="closeModal('scheduleModal')" class="text-gray-400 hover:text-[#2D241E] hover:bg-[#FDF8F1] p-2 rounded-xl transition-colors">✕</button>
        </div>
        <div class="space-y-4">

            {{-- Service --}}
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Service</label>
                <select id="schedService"
                        class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm">
                    <option value="">Select a service…</option>
                </select>
            </div>

            {{-- Multi-date picker --}}
            <div id="schedDatesSection">
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">
                    Date(s)
                    <span id="schedDatesHint" class="text-[9px] font-normal text-[#A68B6D] ml-1">(click multiple dates to open several at once)</span>
                </label>

                {{-- Mini calendar grid rendered by JS --}}
                <div id="schedCalendarWrap" class="border border-[#F3E9DC] rounded-2xl overflow-hidden bg-[#FDF8F1]">
                    {{-- Month nav --}}
                    <div class="flex items-center justify-between px-4 py-3 bg-white border-b border-[#F3E9DC]">
                        <button type="button" onclick="calNav(-1)"
                                class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-[#FDF8F1] text-[#5C4D3C] font-bold transition-colors">‹</button>
                        <span id="calMonthLabel" class="text-sm font-bold text-[#2D241E]"></span>
                        <button type="button" onclick="calNav(+1)"
                                class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-[#FDF8F1] text-[#5C4D3C] font-bold transition-colors">›</button>
                    </div>
                    {{-- Day headers --}}
                    <div class="grid grid-cols-7 px-2 pt-2">
                        @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $d)
                            <div class="text-center text-[9px] font-bold text-gray-400 uppercase py-1">{{ $d }}</div>
                        @endforeach
                    </div>
                    {{-- Day cells --}}
                    <div id="calDays" class="grid grid-cols-7 gap-0.5 p-2"></div>
                </div>

                {{-- Selected dates chips --}}
                <div id="selectedDatesChips" class="flex flex-wrap gap-1.5 mt-2 min-h-7"></div>
                <p class="text-[10px] text-gray-400 mt-1">
                    <span id="selectedDatesCount" class="font-bold text-[#E68A39]">0</span> date(s) selected
                </p>
            </div>

            {{-- Edit mode: single date read-only --}}
            <div id="schedSingleDate" class="hidden">
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Date</label>
                <input id="schedDate" type="date" readonly
                       class="w-full px-4 py-3 bg-[#F3E9DC] border border-[#F3E9DC] rounded-xl text-[#2D241E] text-sm cursor-not-allowed opacity-70"/>
                <p class="text-[10px] text-gray-400 mt-1">Date cannot be changed. Delete and recreate to pick a new date.</p>
            </div>

            {{-- Slot limit --}}
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Daily Slot Limit</label>
                <input id="schedSlots" type="number" min="1" max="500" placeholder="e.g. 10"
                       class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
                <p class="text-[10px] text-gray-400 mt-1.5">Max bookings accepted per date.</p>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Notes <span class="font-normal text-gray-400">(optional)</span></label>
                <textarea id="schedNotes" rows="2" placeholder="e.g. Morning slots only, bring vaccination record…"
                          class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] resize-none text-sm"></textarea>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Status</label>
                <select id="schedStatus"
                        class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm">
                    <option value="open">Open — accepting bookings</option>
                    <option value="closed">Closed — not accepting bookings</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3 mt-6 sm:mt-8">
            <button onclick="closeModal('scheduleModal')"
                    class="flex-1 px-4 py-3 border border-[#EBD7BC] text-[#5C4D3C] rounded-xl font-bold hover:bg-[#FDF8F1] transition-colors text-sm">Cancel</button>
            <button onclick="saveSchedule()" id="saveSchedBtn"
                    class="flex-1 px-4 py-3 bg-[#2D241E] text-white rounded-xl font-bold shadow-md hover:bg-black transition-colors text-sm">Save Date(s)</button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL: VIEW BOOKINGS FOR A DATE
══════════════════════════════════════════ --}}
<div id="viewBookingsModal" class="fixed inset-0 bg-[#2D241E]/40 backdrop-blur-sm z-50 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 w-full max-w-[580px] shadow-2xl overflow-y-auto max-h-[90vh]">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <div>
                <h3 id="viewBookingsTitle" class="font-serif-brand text-lg sm:text-2xl text-[#2D241E]">Bookings</h3>
                <p id="viewBookingsSubtitle" class="text-xs text-gray-400 mt-0.5"></p>
            </div>
            <button onclick="closeModal('viewBookingsModal')" class="text-gray-400 hover:text-[#2D241E] hover:bg-[#FDF8F1] p-2 rounded-xl transition-colors">✕</button>
        </div>
        <div id="viewBookingsList" class="space-y-3"></div>
        <button onclick="closeModal('viewBookingsModal')"
                class="w-full mt-6 px-4 py-3 border border-[#EBD7BC] text-[#5C4D3C] rounded-xl font-bold hover:bg-[#FDF8F1] transition-colors text-sm">Close</button>
    </div>
</div>

{{-- Confirmation/Alert Modal --}}
<div id="confirmModal" class="fixed inset-0 bg-[#2D241E]/60 backdrop-blur-sm z-50 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 w-full max-w-[400px] shadow-2xl text-center">
        <div id="confirmIcon" class="text-4xl sm:text-5xl mb-3 sm:mb-4">⚠️</div>
        <h3 id="confirmTitle" class="font-serif-brand text-xl sm:text-2xl text-[#2D241E] mb-2">Are you sure?</h3>
        <p id="confirmMessage" class="text-gray-500 text-sm mb-5 sm:mb-8">This action cannot be undone.</p>
        <div class="flex gap-2 sm:gap-3">
            <button onclick="closeModal('confirmModal')" id="cancelBtn"
                    class="flex-1 px-3 sm:px-6 py-2.5 sm:py-3 border border-[#F3E9DC] text-[#5C4D3C] rounded-xl font-bold hover:bg-[#FDF8F1] text-sm">No, Cancel</button>
            <button id="confirmBtn"
                    class="flex-1 px-3 sm:px-6 py-2.5 sm:py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg text-sm">Yes, Delete</button>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="toast" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-xl font-bold text-xs sm:text-sm transform translate-y-20 opacity-0 transition-all duration-300 flex items-center gap-3 pointer-events-none"></div>

<script>
const API  = '/api/v1';
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

// ── State ─────────────────────────────────────────────────────────────────────
let services          = [];
let schedules         = [];
let bookings          = [];
let editId            = null;
let editSchedId       = null;
let pendingDeleteId   = null;
let currentServiceImg = null; 

// Calendar state
let calYear  = new Date().getFullYear();
let calMonth = new Date().getMonth();         
let selectedDates = new Set();                
const MONTH_NAMES = ['January','February','March','April','May','June',
                     'July','August','September','October','November','December'];

// ── Tab switching ─────────────────────────────────────────────────────────────
function switchTab(tab) {
    ['services', 'bookings'].forEach(t => {
        document.getElementById(`page-${t}`).classList.toggle('hidden', t !== tab);
        const btn = document.getElementById(`tab-${t}`);
        if (t === tab) {
            btn.classList.add('border-[#E68A39]', 'text-[#E68A39]');
            btn.classList.remove('border-transparent', 'text-gray-400');
        } else {
            btn.classList.remove('border-[#E68A39]', 'text-[#E68A39]');
            btn.classList.add('border-transparent', 'text-gray-400');
        }
    });
    if (tab === 'bookings') {
        loadSchedules();
        loadBookings();
    }
}

// ══════════════════════════════════════════════════════════════════════════════
// SERVICES
// ══════════════════════════════════════════════════════════════════════════════
async function loadServices() {
    try {
        const res = await fetch(`${API}/services`);
        services  = await res.json();
        renderServices();
        populateServiceDropdowns();
    } catch (e) {
        document.getElementById('servicesGrid').innerHTML =
            '<p class="col-span-full text-center text-red-400 py-16 text-sm">Failed to load services.</p>';
    }
}

function populateServiceDropdowns() {
    const opts = services.map(s => `<option value="${s.id}">${s.icon} ${s.name}</option>`).join('');
    document.getElementById('schedService').innerHTML        = `<option value="">Select a service…</option>${opts}`;
    document.getElementById('schedServiceFilter').innerHTML  = `<option value="">All Services</option>${opts}`;
}

function renderServices() {
    const grid  = document.getElementById('servicesGrid');
    const empty = document.getElementById('emptyState');
    if (!services.length) {
        grid.innerHTML = '';
        empty.classList.replace('hidden', 'flex');
        return;
    }
    empty.classList.replace('flex', 'hidden');
    grid.innerHTML = services.map(s => {
        const mediaHtml = s.image
            ? `<img src="${s.image}" alt="${s.name}" class="w-full h-full object-cover">`
            : `<span class="text-2xl sm:text-3xl">${s.icon}</span>`;

        return `
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm hover:shadow-md transition-shadow group overflow-hidden flex flex-col">
            <div class="relative ${s.image ? 'h-40 sm:h-48' : 'p-5 sm:p-8 pb-0'}">
                ${s.image
                    ? `<div class="w-full h-full overflow-hidden">${mediaHtml}</div>`
                    : `<div class="w-14 h-14 sm:w-16 sm:h-16 ${getIconBg(s.icon)} rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">${mediaHtml}</div>`
                }
                <span class="absolute top-3 right-3 ${s.status === 'Active' ? 'bg-[#E9F7F2] text-[#34A853]' : 'bg-gray-100 text-gray-400'} text-[10px] font-bold uppercase px-3 py-1 rounded-full shadow-sm">
                    ${s.status}
                </span>
            </div>
            <div class="p-5 sm:p-6 flex flex-col flex-1 ${s.image ? '' : 'pt-4 sm:pt-5'}">
                <h3 class="font-serif-brand text-lg sm:text-2xl text-[#2D241E] mb-2">${s.name}</h3>
                <p class="text-gray-500 text-xs sm:text-sm mb-4 sm:mb-6 leading-relaxed flex-1 line-clamp-3">${s.desc}</p>
                <div class="flex items-center justify-between border-t border-[#FDF8F1] pt-4 sm:pt-5">
                    <span class="text-base sm:text-xl font-bold text-[#E68A39]">₱${parseFloat(s.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</span>
                    <div class="flex gap-1 sm:gap-2">
                        <button onclick="openServiceModal(${s.id})" class="p-2 hover:bg-[#FDF8F1] rounded-xl text-gray-400 hover:text-[#2D241E] transition-colors text-sm sm:text-base" title="Edit">⚙️</button>
                        <button onclick="promptDelete(${s.id},'service')" class="p-2 hover:bg-red-50 rounded-xl text-gray-400 hover:text-red-500 transition-colors text-sm sm:text-base" title="Delete">🗑️</button>
                    </div>
                </div>
            </div>
        </div>`;
    }).join('');
}

function getIconBg(icon) {
    const map = { '🛁': 'bg-[#FDF2E9]', '🎾': 'bg-[#E9F0FE]', '🩺': 'bg-[#FEE9E9]' };
    return map[icon] || 'bg-[#F3E9DC]';
}

function handleServiceImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        currentServiceImg = e.target.result;
        document.getElementById('sImagePreview').innerHTML =
            `<img src="${currentServiceImg}" style="width:100%;height:100%;object-fit:cover;" class="rounded-2xl">`;
        document.getElementById('sClearImage').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function clearServiceImage() {
    currentServiceImg = null;
    document.getElementById('sImage').value = '';
    document.getElementById('sImagePreview').innerHTML = '<span id="sPreviewPlaceholder">📸</span>';
    document.getElementById('sClearImage').classList.add('hidden');
}

function openServiceModal(id = null) {
    editId = id;
    currentServiceImg = null;
    document.getElementById('sImage').value = '';
    document.getElementById('sImagePreview').innerHTML = '<span id="sPreviewPlaceholder">📸</span>';
    document.getElementById('sClearImage').classList.add('hidden');

    if (id) {
        const s = services.find(x => x.id === id);
        document.getElementById('modalTitle').innerText = 'Edit Service';
        document.getElementById('sName').value   = s.name;
        document.getElementById('sIcon').value   = s.icon;
        document.getElementById('sStatus').value = s.status;
        document.getElementById('sPrice').value  = s.price;
        document.getElementById('sDesc').value   = s.desc;
        if (s.image) {
            document.getElementById('sImagePreview').innerHTML =
                `<img src="${s.image}" style="width:100%;height:100%;object-fit:cover;" class="rounded-2xl">`;
            document.getElementById('sClearImage').classList.remove('hidden');
        }
    } else {
        document.getElementById('modalTitle').innerText = 'Add New Service';
        ['sName', 'sPrice', 'sDesc'].forEach(i => document.getElementById(i).value = '');
        document.getElementById('sIcon').value   = '🛁';
        document.getElementById('sStatus').value = 'Active';
    }
    document.getElementById('serviceModal').classList.replace('hidden', 'flex');
}

async function saveService() {
    const name   = document.getElementById('sName').value.trim();
    const price  = parseFloat(document.getElementById('sPrice').value);
    const desc   = document.getElementById('sDesc').value.trim();
    const icon   = document.getElementById('sIcon').value;
    const status = document.getElementById('sStatus').value;

    if (!name || isNaN(price) || !desc) {
        showAlert('Missing Info', 'Please provide a name, price, and description.');
        return;
    }

    const btn = document.getElementById('saveBtn');
    btn.disabled = true; btn.innerText = 'Saving…';

    const form = new FormData();
    form.append('name',        name);
    form.append('icon',        icon);
    form.append('status',      status);
    form.append('price',       price);
    form.append('description', desc);

    const fileInput = document.getElementById('sImage');
    if (fileInput.files[0]) {
        form.append('image', fileInput.files[0]);
    }

    if (editId) form.append('_method', 'PUT');

    try {
        const url = editId ? `${API}/services/${editId}` : `${API}/services`;
        const res = await fetch(url, {
            method:  'POST',
            headers: { 'X-CSRF-TOKEN': CSRF },
            body:    form,
        });
        if (!res.ok) throw new Error(await res.text());
        const saved = await res.json();
        const normalized = { ...saved, desc: saved.desc ?? saved.description };

        if (editId) {
            const idx = services.findIndex(x => x.id === editId);
            services[idx] = normalized;
            showToast('Service updated!');
        } else {
            services.push(normalized);
            showToast('Service added!');
        }

        renderServices();
        populateServiceDropdowns();
        closeModal('serviceModal');
    } catch (e) {
        showAlert('Error', 'Could not save service. Please try again.');
    } finally {
        btn.disabled = false; btn.innerText = 'Save Service';
    }
}

// ══════════════════════════════════════════════════════════════════════════════
// SCHEDULES (Open Dates)
// ══════════════════════════════════════════════════════════════════════════════
async function loadSchedules() {
    try {
        const res = await fetch(`${API}/service-schedules`);
        schedules = await res.json();
        renderSchedules();
        updateBookingStats();
    } catch (e) {
        document.getElementById('scheduleTableBody').innerHTML =
            '<tr><td colspan="6" class="text-center py-12 text-red-400 text-sm">Failed to load schedules.</td></tr>';
    }
}

function renderSchedules() {
    const serviceFilter = document.getElementById('schedServiceFilter').value;
    const statusFilter  = document.getElementById('schedStatusFilter').value;

    let filtered = schedules;
    if (serviceFilter) filtered = filtered.filter(s => String(s.service_id) === String(serviceFilter));
    if (statusFilter)  filtered = filtered.filter(s => s.status === statusFilter);

    filtered.sort((a, b) => new Date(a.date) - new Date(b.date));

    const tbody       = document.getElementById('scheduleTableBody');
    const mobileCards = document.getElementById('scheduleMobileCards');

    if (!filtered.length) {
        tbody.innerHTML       = '<tr><td colspan="6" class="text-center py-12 text-gray-400 text-sm">No schedule entries found.</td></tr>';
        mobileCards.innerHTML = '<div class="text-center py-10 text-gray-400 text-sm bg-[#FDF8F1] rounded-2xl border border-dashed border-[#F3E9DC]">No schedule entries found.</div>';
        return;
    }

    tbody.innerHTML = filtered.map(s => {
        const svc       = services.find(x => x.id === s.service_id);
        const svcName   = svc ? `${svc.icon} ${svc.name}` : '—';
        const booked    = s.booked_count ?? 0;
        const pct       = s.slot_limit > 0 ? Math.min(100, Math.round((booked / s.slot_limit) * 100)) : 0;
        const isFull    = booked >= s.slot_limit;
        const statusBadge = _schedStatusBadge(isFull ? 'full' : s.status);
        const dateLabel = new Date(s.date + 'T00:00:00').toLocaleDateString('en-PH', { weekday:'short', month:'short', day:'numeric', year:'numeric' });
        return `
        <tr class="hover:bg-[#FDF8F1]/60 transition-colors">
            <td class="px-6 py-4 text-sm font-bold text-[#2D241E]">${dateLabel}</td>
            <td class="px-6 py-4 text-sm text-[#5C4D3C] font-medium">${svcName}</td>
            <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                    <div class="flex-1 h-2 bg-[#F3E9DC] rounded-full overflow-hidden min-w-[60px]">
                        <div class="h-full rounded-full transition-all ${pct >= 100 ? 'bg-red-400' : pct >= 75 ? 'bg-[#E68A39]' : 'bg-[#34A853]'}"
                             style="width:${pct}%"></div>
                    </div>
                    <span class="text-xs font-bold text-[#5C4D3C] whitespace-nowrap">${s.slot_limit} slots</span>
                </div>
            </td>
            <td class="px-6 py-4">
                <span class="text-sm font-bold ${booked >= s.slot_limit ? 'text-red-500' : 'text-[#2D241E]'}">${booked}</span>
                <span class="text-xs text-gray-400"> / ${s.slot_limit}</span>
            </td>
            <td class="px-6 py-4">${statusBadge}</td>
            <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                    <button onclick="viewDateBookings(${s.id})"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-[#FDF2E9] text-[#E68A39] hover:bg-[#FCE1CC]">
                        View (${booked})
                    </button>
                    <button onclick="openScheduleModal(${s.id})"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-[#F3E9DC]/50 text-gray-600 hover:bg-[#EBD7BC]">
                        Edit
                    </button>
                    <button onclick="promptDelete(${s.id},'schedule')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-red-50 text-red-500 hover:bg-red-100">
                        Delete
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');

    mobileCards.innerHTML = filtered.map(s => {
        const svc     = services.find(x => x.id === s.service_id);
        const svcName = svc ? `${svc.icon} ${svc.name}` : '—';
        const booked  = s.booked_count ?? 0;
        const pct     = s.slot_limit > 0 ? Math.min(100, Math.round((booked / s.slot_limit) * 100)) : 0;
        const isFull  = booked >= s.slot_limit;
        const dateLabel = new Date(s.date + 'T00:00:00').toLocaleDateString('en-PH', { weekday:'short', month:'short', day:'numeric', year:'numeric' });
        return `
        <div class="bg-white border border-[#F3E9DC] rounded-2xl p-4 shadow-sm">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <div class="font-bold text-[#2D241E] text-sm">${dateLabel}</div>
                    <div class="text-xs text-[#A68B6D] mt-0.5">${svcName}</div>
                </div>
                ${_schedStatusBadge(isFull ? 'full' : s.status)}
            </div>
            <div class="mb-3">
                <div class="flex justify-between text-xs font-bold text-[#5C4D3C] mb-1">
                    <span>Slots filled</span>
                    <span>${booked} / ${s.slot_limit}</span>
                </div>
                <div class="h-2 bg-[#F3E9DC] rounded-full overflow-hidden">
                    <div class="h-full rounded-full ${pct >= 100 ? 'bg-red-400' : pct >= 75 ? 'bg-[#E68A39]' : 'bg-[#34A853]'}"
                         style="width:${pct}%"></div>
                </div>
            </div>
            ${s.notes ? `<p class="text-[10px] text-gray-400 mb-3 italic">${s.notes}</p>` : ''}
            <div class="flex gap-2 pt-3 border-t border-[#F3E9DC]">
                <button onclick="viewDateBookings(${s.id})"
                        class="flex-1 py-2 text-xs font-bold rounded-xl bg-[#FDF2E9] text-[#E68A39] hover:bg-[#FCE1CC]">
                    View (${booked})
                </button>
                <button onclick="openScheduleModal(${s.id})"
                        class="flex-1 py-2 text-xs font-bold rounded-xl bg-white border border-[#F3E9DC] text-gray-600 hover:bg-gray-50">
                    Edit
                </button>
                <button onclick="promptDelete(${s.id},'schedule')"
                        class="flex-1 py-2 text-xs font-bold rounded-xl bg-red-50 text-red-500 hover:bg-red-100">
                    Delete
                </button>
            </div>
        </div>`;
    }).join('');
}

function _schedStatusBadge(status) {
    const map = {
        open:   'bg-[#E9F7F2] text-[#166534]',
        full:   'bg-[#FEE2E2] text-[#991B1B]',
        closed: 'bg-gray-100 text-gray-500',
    };
    const labels = { open: 'Open', full: 'Full', closed: 'Closed' };
    const cls = map[status] || 'bg-gray-100 text-gray-500';
    return `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide ${cls}">${labels[status] ?? status}</span>`;
}

// ── Mini Calendar Logic ───────────────────────────────────────────────────────
function calNav(delta) {
    calMonth += delta;
    if (calMonth > 11) { calMonth = 0; calYear++; }
    if (calMonth < 0)  { calMonth = 11; calYear--; }
    renderCalendar();
}

function renderCalendar() {
    document.getElementById('calMonthLabel').textContent =
        `${MONTH_NAMES[calMonth]} ${calYear}`;

    const today     = new Date(); today.setHours(0,0,0,0);
    const firstDay  = new Date(calYear, calMonth, 1).getDay(); // 0=Sun
    const daysInMo  = new Date(calYear, calMonth + 1, 0).getDate();

    const serviceId = document.getElementById('schedService').value;
    const taken = new Set(
        schedules
            .filter(s => String(s.service_id) === String(serviceId))
            .map(s => s.date)
    );

    let html = '';

    for (let i = 0; i < firstDay; i++) {
        html += '<div></div>';
    }

    for (let d = 1; d <= daysInMo; d++) {
        const iso  = `${calYear}-${String(calMonth+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const date = new Date(calYear, calMonth, d);
        const isPast    = date <= today;
        const isTaken   = taken.has(iso);
        const isSelected= selectedDates.has(iso);

        let cls = 'w-8 h-8 mx-auto flex items-center justify-center rounded-xl text-xs font-bold transition-colors ';

        if (isPast || isTaken) {
            cls += 'text-gray-300 cursor-not-allowed';
        } else if (isSelected) {
            cls += 'bg-[#E68A39] text-white cursor-pointer';
        } else {
            cls += 'text-[#2D241E] hover:bg-[#FDF2E9] cursor-pointer';
        }

        const title    = isTaken ? 'Already scheduled' : isPast ? 'Past date' : iso;

        html += `<div class="py-0.5">
            <button type="button"
                    class="${cls}"
                    title="${title}"
                    ${isPast || isTaken ? 'disabled' : `onclick="toggleDate('${iso}')"`}>
                ${d}
            </button>
        </div>`;
    }

    document.getElementById('calDays').innerHTML = html;
    renderChips();
}

function toggleDate(iso) {
    if (selectedDates.has(iso)) {
        selectedDates.delete(iso);
    } else {
        selectedDates.add(iso);
    }
    renderCalendar();
}

function renderChips() {
    const sorted = [...selectedDates].sort();
    document.getElementById('selectedDatesCount').textContent = sorted.length;
    document.getElementById('selectedDatesChips').innerHTML = sorted.map(iso => {
        const [y,m,d] = iso.split('-');
        const label   = `${MONTH_NAMES[parseInt(m)-1].slice(0,3)} ${parseInt(d)}, ${y}`;
        return `<span class="inline-flex items-center gap-1 bg-[#FDF2E9] text-[#E68A39] border border-orange-200 px-2.5 py-1 rounded-full text-[10px] font-bold">
            ${label}
            <button type="button" onclick="toggleDate('${iso}')" class="hover:text-red-500 font-bold leading-none ml-0.5">✕</button>
        </span>`;
    }).join('');
}

function openScheduleModal(id = null) {
    editSchedId = id;

    const now = new Date();
    calYear  = now.getFullYear();
    calMonth = now.getMonth();
    selectedDates.clear();

    if (id) {
        const s = schedules.find(x => x.id === id);
        document.getElementById('schedModalTitle').innerText  = 'Edit Schedule';
        document.getElementById('schedService').value         = s.service_id;
        document.getElementById('schedService').disabled      = true;
        document.getElementById('schedSlots').value           = s.slot_limit;
        document.getElementById('schedNotes').value           = s.notes ?? '';
        document.getElementById('schedStatus').value          = s.status;
        document.getElementById('schedDate').value            = s.date;
        document.getElementById('schedDatesSection').classList.add('hidden');
        document.getElementById('schedSingleDate').classList.remove('hidden');
        document.getElementById('saveSchedBtn').textContent   = 'Save Changes';
    } else {
        document.getElementById('schedModalTitle').innerText  = 'Open New Date(s)';
        document.getElementById('schedService').disabled      = false;
        document.getElementById('schedService').value         = '';
        document.getElementById('schedSlots').value           = '';
        document.getElementById('schedNotes').value           = '';
        document.getElementById('schedStatus').value          = 'open';
        document.getElementById('schedDatesSection').classList.remove('hidden');
        document.getElementById('schedSingleDate').classList.add('hidden');
        document.getElementById('saveSchedBtn').textContent   = 'Save Date(s)';
        renderCalendar();
    }

    document.getElementById('scheduleModal').classList.replace('hidden', 'flex');
}

async function saveSchedule() {
    const service_id = document.getElementById('schedService').value;
    const slot_limit = parseInt(document.getElementById('schedSlots').value);
    const notes      = document.getElementById('schedNotes').value.trim();
    const status     = document.getElementById('schedStatus').value;

    const btn = document.getElementById('saveSchedBtn');

    if (editSchedId) {
        if (!slot_limit || slot_limit < 1) {
            showAlert('Missing Info', 'Please enter a valid slot limit.');
            return;
        }

        btn.disabled = true; btn.innerText = 'Saving…';

        try {
            const res = await fetch(`${API}/service-schedules/${editSchedId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ slot_limit, notes, status }),
            });
            if (!res.ok) throw new Error(await res.text());
            const saved = await res.json();
            const idx   = schedules.findIndex(x => x.id === editSchedId);
            schedules[idx] = { ...schedules[idx], ...saved };
            showToast('Schedule updated!');
            renderSchedules();
            updateBookingStats();
            closeModal('scheduleModal');
        } catch (e) {
            showAlert('Error', 'Could not update schedule.');
        } finally {
            btn.disabled = false; btn.innerText = 'Save Changes';
        }
    } else {
        if (!service_id) { showAlert('Missing Info', 'Please select a service.'); return; }
        if (selectedDates.size === 0) { showAlert('Missing Info', 'Please select at least one date on the calendar.'); return; }
        if (!slot_limit || slot_limit < 1) { showAlert('Missing Info', 'Please enter a valid slot limit.'); return; }

        btn.disabled = true;
        btn.innerText = `Saving ${selectedDates.size} date(s)…`;

        try {
            const res = await fetch(`${API}/service-schedules`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({
                    service_id,
                    dates:      [...selectedDates].sort(),
                    slot_limit,
                    notes,
                    status,
                }),
            });
            if (!res.ok) throw new Error(await res.text());
            const result = await res.json();

            schedules.push(...result.created);

            const created = result.created.length;
            const skipped = result.skipped.length;

            let msg = `${created} date(s) opened for bookings!`;
            if (skipped > 0) msg += ` (${skipped} skipped — already scheduled)`;

            showToast(msg);
            renderSchedules();
            updateBookingStats();
            closeModal('scheduleModal');
        } catch (e) {
            showAlert('Error', 'Could not save schedules. Please try again.');
        } finally {
            btn.disabled = false; btn.innerText = 'Save Date(s)';
        }
    }
}

// ══════════════════════════════════════════════════════════════════════════════
// BOOKINGS
// ══════════════════════════════════════════════════════════════════════════════
async function loadBookings() {
    try {
        const res = await fetch(`${API}/service-bookings`);
        bookings  = await res.json();
        renderBookings();
        updateBookingStats();
    } catch (e) {
        document.getElementById('bookingsList').innerHTML =
            '<div class="text-center py-10 text-red-400 text-sm">Failed to load bookings.</div>';
    }
}

function renderBookings() {
    const dateFilter   = document.getElementById('bookingDateFilter').value;
    const statusFilter = document.getElementById('bookingStatusFilter').value;

    let filtered = bookings;
    if (dateFilter)   filtered = filtered.filter(b => b.scheduled_at === dateFilter);
    if (statusFilter) filtered = filtered.filter(b => b.status === statusFilter);

    filtered.sort((a, b) => new Date(a.scheduled_at) - new Date(b.scheduled_at));

    const container = document.getElementById('bookingsList');
    if (!filtered.length) {
        container.innerHTML = `
            <div class="text-center py-12 text-gray-400 text-sm">
                <div class="text-3xl mb-3">📭</div>
                No bookings found for the selected filters.
            </div>`;
        return;
    }

    container.innerHTML = filtered.map(b => {
        const svc       = services.find(x => x.id === b.service_id);
        const svcName   = svc ? `${svc.icon} ${svc.name}` : b.service_name ?? '—';
        const dateLabel = b.scheduled_at
            ? new Date(b.scheduled_at + 'T00:00:00').toLocaleDateString('en-PH', { weekday:'short', month:'short', day:'numeric', year:'numeric' })
            : '—';
        const statusMap = {
            pending:   'bg-[#FEF9C3] text-[#854D0E]',
            confirmed: 'bg-[#DCFCE7] text-[#166534]',
            cancelled: 'bg-[#FEE2E2] text-[#991B1B]',
            completed: 'bg-[#E9F7F2] text-[#166534]',
        };
        const statusCls = statusMap[b.status] || 'bg-gray-100 text-gray-500';
        const iconHtml  = svc?.image
            ? `<img src="${svc.image}" class="w-full h-full object-cover" style="border-radius:inherit;">`
            : (svc?.icon ?? '🐾');
        return `
        <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-[#FDF8F1]/50 transition-colors">
            <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                <div class="w-10 h-10 bg-[#FDF2E9] rounded-xl flex items-center justify-center text-xl shrink-0 overflow-hidden">
                    ${iconHtml}
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-[#2D241E] text-sm truncate">${b.customer_name ?? b.order?.customer_name ?? 'Unknown'}</div>
                    <div class="text-xs text-[#A68B6D] mt-0.5 truncate">${svcName} · ${dateLabel}</div>
                    ${b.order_number ? `<div class="text-[10px] text-gray-400 mt-0.5 font-mono">Order #${b.order_number}</div>` : ''}
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-auto">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide ${statusCls}">
                    ${b.status}
                </span>
                <select onchange="updateBookingStatus(${b.id}, this.value)"
                        class="px-2 py-1.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-xs font-bold text-[#5C4D3C] focus:outline-none focus:border-[#E68A39] cursor-pointer">
                    <option value="">Change…</option>
                    <option value="pending"   ${b.status==='pending'   ? 'selected':''}>Pending</option>
                    <option value="confirmed" ${b.status==='confirmed' ? 'selected':''}>Confirmed</option>
                    <option value="completed" ${b.status==='completed' ? 'selected':''}>Completed</option>
                    <option value="cancelled" ${b.status==='cancelled' ? 'selected':''}>Cancelled</option>
                </select>
            </div>
        </div>`;
    }).join('');
}

async function updateBookingStatus(id, status) {
    if (!status) return;
    try {
        const res = await fetch(`${API}/service-bookings/${id}/status`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ status }),
        });
        if (!res.ok) throw new Error();
        const idx = bookings.findIndex(b => b.id === id);
        if (idx > -1) bookings[idx].status = status;
        renderBookings();
        updateBookingStats();
        showToast(`Booking marked as ${status}!`);
    } catch {
        showToast('Failed to update booking status.', 'error');
    }
}

function viewDateBookings(scheduleId) {
    const sched     = schedules.find(x => x.id === scheduleId);
    const svc       = sched ? services.find(x => x.id === sched.service_id) : null;
    const dateLabel = sched
        ? new Date(sched.date + 'T00:00:00').toLocaleDateString('en-PH', { weekday:'long', month:'long', day:'numeric', year:'numeric' })
        : '';
    const related   = bookings.filter(b => b.schedule_id === scheduleId || b.scheduled_at === sched?.date);

    document.getElementById('viewBookingsTitle').innerText    = svc ? `${svc.icon} ${svc.name}` : 'Bookings';
    document.getElementById('viewBookingsSubtitle').innerText = `${dateLabel} · ${related.length} of ${sched?.slot_limit ?? '?'} slots filled`;

    const list = document.getElementById('viewBookingsList');
    if (!related.length) {
        list.innerHTML = `<div class="text-center py-8 text-gray-400 text-sm"><div class="text-3xl mb-2">📭</div>No bookings yet for this date.</div>`;
    } else {
        const statusMap = {
            pending:   'bg-[#FEF9C3] text-[#854D0E]',
            confirmed: 'bg-[#DCFCE7] text-[#166534]',
            cancelled: 'bg-[#FEE2E2] text-[#991B1B]',
            completed: 'bg-[#E9F7F2] text-[#166534]',
        };
        list.innerHTML = related.map((b, i) => `
            <div class="flex items-center justify-between gap-3 p-3 bg-[#FDF8F1] rounded-2xl border border-[#F3E9DC]">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 bg-[#E68A39]/10 rounded-xl flex items-center justify-center text-xs font-bold text-[#E68A39] shrink-0">${i+1}</div>
                    <div class="min-w-0">
                        <div class="font-bold text-[#2D241E] text-sm truncate">${b.customer_name ?? b.order?.customer_name ?? 'Unknown'}</div>
                        ${b.order_number ? `<div class="text-[10px] text-gray-400 font-mono">Order #${b.order_number}</div>` : ''}
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide ${statusMap[b.status] ?? 'bg-gray-100 text-gray-500'} shrink-0">
                    ${b.status}
                </span>
            </div>`).join('');
    }
    document.getElementById('viewBookingsModal').classList.replace('hidden', 'flex');
}

function updateBookingStats() {
    const openDates      = schedules.length;
    const totalBookings  = bookings.length;
    const confirmed      = bookings.filter(b => b.status === 'confirmed' || b.status === 'completed').length;
    const pending        = bookings.filter(b => b.status === 'pending').length;
    document.getElementById('stat-open-dates').textContent       = openDates;
    document.getElementById('stat-total-bookings').textContent   = totalBookings;
    document.getElementById('stat-confirmed').textContent        = confirmed;
    document.getElementById('stat-pending-bookings').textContent = pending;
}

// ══════════════════════════════════════════════════════════════════════════════
// SHARED HELPERS
// ══════════════════════════════════════════════════════════════════════════════
function promptDelete(id, type) {
    pendingDeleteId = { id, type };
    document.getElementById('confirmIcon').innerText    = '🗑️';
    document.getElementById('confirmTitle').innerText   = type === 'schedule' ? 'Remove Date?' : 'Remove Service?';
    document.getElementById('confirmMessage').innerText = type === 'schedule'
        ? 'This will permanently delete this schedule date and cannot be undone.'
        : 'This will permanently delete this service.';
    const btn = document.getElementById('confirmBtn');
    btn.innerText = 'Yes, Delete';
    btn.className = 'flex-1 px-3 sm:px-6 py-2.5 sm:py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg text-sm';
    btn.onclick   = executeDelete;
    document.getElementById('cancelBtn').classList.remove('hidden');
    document.getElementById('confirmModal').classList.replace('hidden', 'flex');
}

async function executeDelete() {
    const { id, type } = pendingDeleteId;
    const endpoint = type === 'schedule' ? `${API}/service-schedules/${id}` : `${API}/services/${id}`;
    try {
        await fetch(endpoint, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF } });
    } catch (e) { /* optimistic */ }
    if (type === 'schedule') {
        schedules = schedules.filter(x => x.id !== id);
        renderSchedules();
        updateBookingStats();
        showToast('Schedule date removed.');
    } else {
        services = services.filter(x => x.id !== id);
        renderServices();
        populateServiceDropdowns();
        showToast('Service removed.', 'error');
    }
    closeModal('confirmModal');
}

function closeModal(id) {
    document.getElementById(id)?.classList.replace('flex', 'hidden');
    if (id === 'scheduleModal') {
        document.getElementById('schedService').disabled = false;
        selectedDates.clear();
    }
    editId = null; editSchedId = null;
}

function showAlert(title, msg) {
    document.getElementById('confirmIcon').innerText    = '❌';
    document.getElementById('confirmTitle').innerText   = title;
    document.getElementById('confirmMessage').innerText = msg;
    const btn = document.getElementById('confirmBtn');
    btn.innerText = 'Okay';
    btn.className = 'flex-1 px-3 sm:px-6 py-2.5 sm:py-3 bg-[#2D241E] text-white rounded-xl font-bold text-sm';
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

document.addEventListener('DOMContentLoaded', () => {
    loadServices();
    document.getElementById('schedService')?.addEventListener('change', () => {
        if (!editSchedId) renderCalendar();
    });
});
</script>
@endsection