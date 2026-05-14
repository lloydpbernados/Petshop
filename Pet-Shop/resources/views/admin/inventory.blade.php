{{-- inventory.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#FDF8F1]">

    <div class="flex flex-col sm:flex-row sm:items-start lg:items-center justify-between mb-6 sm:mb-10 gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="text-2xl sm:text-3xl">🐾</span>
                <h1 class="font-serif-brand text-3xl sm:text-4xl font-bold text-[#2D241E]">Pets Inventory</h1>
            </div>
            <p class="text-gray-500 text-sm sm:text-base">Track available pets, manage arrivals, and monitor availability across all animal categories.</p>
        </div>
        <div class="flex gap-3 sm:gap-4 shrink-0">
            <button class="bg-white border border-[#EBD7BC] text-[#5C4D3C] px-4 sm:px-6 py-2.5 sm:py-3 rounded-full font-bold shadow-sm hover:bg-[#FDF8F1] transition-all flex items-center gap-2 text-sm" onclick="exportCSV()">
                <span>⬇</span> <span class="hidden xs:inline">Export CSV</span><span class="xs:hidden">CSV</span>
            </button>
            <button class="bg-[#E68A39] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-full font-bold shadow-lg hover:bg-[#cf7529] transition-all flex items-center gap-2 text-sm" onclick="openAddModal()">
                <span class="text-lg sm:text-xl">+</span> Add Pet
            </button>
        </div>
    </div>

    <div class="bg-[#FFF8E1] border border-[#FDE68A] rounded-2xl p-3 sm:p-4 mb-6 sm:mb-8 flex items-start sm:items-center gap-3" id="alertBanner">
        <span class="text-lg sm:text-xl shrink-0">⚠️</span>
        <span class="text-[#92400E] text-xs sm:text-sm font-bold flex-1" id="alertText">Loading availability alerts…</span>
        <button class="text-[#B45309] hover:bg-[#FDE68A] p-1.5 rounded-lg transition-colors shrink-0" onclick="document.getElementById('alertBanner').style.display='none'">✕</button>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-10">
        <div class="bg-white p-4 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-3 sm:gap-5">
            <div class="p-3 sm:p-4 bg-[#E9F7F2] text-[#34A853] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">🏷️</div>
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-tight">Unique Breeds/Types</p>
                <h3 class="text-xl sm:text-2xl font-bold text-[#2D241E] mt-1" id="statSku">—</h3>
            </div>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-3 sm:gap-5">
            <div class="p-3 sm:p-4 bg-[#E9F0FE] text-[#4285F4] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">🐾</div>
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-tight">Total Live Pets</p>
                <h3 class="text-xl sm:text-2xl font-bold text-[#2D241E] mt-1" id="statUnits">—</h3>
            </div>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-3 sm:gap-5">
            <div class="p-3 sm:p-4 bg-[#FEF3C7] text-[#D97706] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">⚠️</div>
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-tight">Low / Unavailable</p>
                <h3 class="text-xl sm:text-2xl font-bold text-[#2D241E] mt-1" id="statLow">—</h3>
            </div>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm flex items-center gap-3 sm:gap-5">
            <div class="p-3 sm:p-4 bg-[#FDF2E9] text-[#E68A39] rounded-xl sm:rounded-2xl text-xl sm:text-2xl shrink-0">💰</div>
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-tight">Total Value</p>
                <h3 class="text-xl sm:text-2xl font-bold text-[#2D241E] mt-1" id="statVal">—</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] xl:grid-cols-[1fr_320px] gap-6 sm:gap-8 items-start">

        <div class="bg-white rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-[#FDF8F1] flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                <h3 class="font-serif-brand text-lg sm:text-xl text-[#2D241E]">Available Pets</h3>
                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <div class="relative flex-1 min-w-[140px]">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
                        <input type="text" id="searchQ" placeholder="Search pets…" oninput="renderTable()" 
                               class="pl-9 pr-3 py-2 sm:py-2.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-xs sm:text-sm focus:outline-none focus:border-[#E68A39] focus:ring-1 focus:ring-[#E68A39] transition-all w-full text-[#2D241E]">
                    </div>
                    <select id="filterCat" onchange="renderTable()" class="px-3 py-2 sm:py-2.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-xs sm:text-sm focus:outline-none focus:border-[#E68A39] text-[#5C4D3C] cursor-pointer">
                        <option value="">All Categories</option>
                        <option>Dogs</option>
                        <option>Cats</option>
                        <option>Birds</option>
                        <option>Small Pets</option>
                        <option>Fish</option>
                        <option>Reptiles</option>
                    </select>
                    <select id="filterStatus" onchange="renderTable()" class="px-3 py-2 sm:py-2.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl text-xs sm:text-sm focus:outline-none focus:border-[#E68A39] text-[#5C4D3C] cursor-pointer">
                        <option value="">All Status</option>
                        <option value="ok">Available</option>
                        <option value="low">Few Left</option>
                        <option value="out">Unavailable</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[680px] text-left border-collapse">
                    <thead>
                        <tr class="bg-[#FDF8F1]">
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Pet / Breed</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Category</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Status</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Headcount</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Price / Total Value</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody" class="divide-y divide-[#FDF8F1]"></tbody>
                </table>
            </div>
            <div id="emptyMsg" class="hidden text-center py-12 sm:py-16 text-gray-400">
                <div class="text-4xl mb-4 opacity-50">📭</div>
                <p>No pets match your filters.</p>
            </div>
        </div>

        <div class="flex flex-col gap-4 sm:gap-6">

            <div class="bg-white p-5 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="font-serif-brand text-lg sm:text-xl text-[#2D241E]">Categories</h3>
                    <span id="breakdownTotal" class="text-xs font-bold text-gray-400 bg-[#FDF8F1] px-2 py-1 rounded-md"></span>
                </div>
                <div id="catBreakdown" class="space-y-3 sm:space-y-4"></div>
            </div>

            <div class="bg-white p-5 sm:p-6 rounded-4xl sm:rounded-[2.5rem] border border-[#F3E9DC] shadow-sm">
                <h3 class="font-serif-brand text-lg sm:text-xl text-[#2D241E] mb-1 sm:mb-2">Needs Attention</h3>
                <p class="text-xs text-gray-400 mb-3 sm:mb-4">Pets currently running low or unavailable.</p>
                <div id="restockList" class="space-y-1"></div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL: ADD/EDIT PET --}}
<div id="itemModal" class="fixed inset-0 bg-[#2D241E]/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-4xl sm:rounded-[2.5rem] p-6 sm:p-8 w-full max-w-[520px] shadow-2xl transform transition-all overflow-y-auto max-h-[90vh]">
        <div class="flex items-center justify-between mb-5 sm:mb-6">
            <h3 id="modalTitle" class="font-serif-brand text-xl sm:text-2xl text-[#2D241E]">Add New Pet</h3>
            <button onclick="closeModal('itemModal')" class="text-gray-400 hover:text-[#2D241E] hover:bg-[#FDF8F1] p-2 rounded-xl transition-colors">✕</button>
        </div>
        
        <div class="space-y-4 sm:space-y-5">
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Pet Photo</label>
                <div class="flex items-center gap-4">
                    <div id="imagePreview" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#FDF8F1] border border-[#F3E9DC] flex items-center justify-center text-2xl sm:text-3xl shrink-0 overflow-hidden">
                        <span id="previewPlaceholder">📸</span>
                    </div>
                    <div class="flex-1">
                        <input id="mImage" type="file" accept="image/*" onchange="handleImageUpload(event)" class="text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 sm:file:py-2 sm:file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#FDF2E9] file:text-[#E68A39] hover:file:bg-[#FCE1CC] cursor-pointer w-full" />
                        <p class="text-[10px] text-gray-400 mt-2 italic">Recommended: Square image, max 2MB</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Pet Breed / Type</label>
                <input id="mName" type="text" placeholder="e.g. Golden Retriever" class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Category</label>
                    <select id="mCat" class="w-full px-3 sm:px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm">
                        <option value="">Select Category</option>
                        <option>Dogs</option>
                        <option>Cats</option>
                        <option>Birds</option>
                        <option>Small Pets</option>
                        <option>Fish</option>
                        <option>Reptiles</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Gender</label>
                    <select id="mGender" class="w-full px-3 sm:px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="N/A">Not Applicable / Unknown</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">SKU / ID</label>
                    <input id="mSku" type="text" placeholder="e.g. DOG-001" class="w-full px-3 sm:px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Price (₱)</label>
                    <input id="mPrice" type="number" placeholder="0.00" step="0.01" min="0" class="w-full px-3 sm:px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Initial Stock</label>
                    <input id="mStock" type="number" placeholder="0" min="0" class="w-full px-3 sm:px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Low Stock Alert</label>
                    <input id="mThresh" type="number" placeholder="2" min="1" class="w-full px-3 sm:px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
                </div>
            </div>
        </div>

        <div class="flex gap-3 sm:gap-4 mt-6 sm:mt-8">
            <button onclick="closeModal('itemModal')" class="flex-1 px-4 sm:px-6 py-3 border border-[#EBD7BC] text-[#5C4D3C] rounded-xl font-bold hover:bg-[#FDF8F1] transition-colors text-sm">Cancel</button>
            <button onclick="saveItem()" class="flex-1 px-4 sm:px-6 py-3 bg-[#E68A39] text-white rounded-xl font-bold shadow-md hover:bg-[#cf7529] transition-colors text-sm">Save Pet</button>
        </div>
    </div>
</div>

{{-- MODAL: RESTOCK/ARRIVAL --}}
<div id="restockModal" class="fixed inset-0 bg-[#2D241E]/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-4xl sm:rounded-[2.5rem] p-6 sm:p-8 w-full max-w-[400px] shadow-2xl">
        <div class="flex items-center justify-between mb-5 sm:mb-6">
            <h3 class="font-serif-brand text-xl sm:text-2xl text-[#2D241E]">Log Pet Arrival</h3>
            <button onclick="closeModal('restockModal')" class="text-gray-400 hover:text-[#2D241E] hover:bg-[#FDF8F1] p-2 rounded-xl transition-colors">✕</button>
        </div>
        <div class="bg-[#FDF8F1] border border-[#F3E9DC] rounded-2xl p-4 flex items-center gap-4 mb-5 sm:mb-6">
            <div id="rIcon" class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-xl flex items-center justify-center text-xl sm:text-2xl shadow-sm overflow-hidden shrink-0"></div>
            <div>
                <div id="rName" class="font-bold text-[#2D241E] text-sm sm:text-base"></div>
                <div id="rCur" class="text-xs text-gray-500 mt-1"></div>
            </div>
        </div>
        <div class="space-y-3 sm:space-y-4">
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Quantity Arrived</label>
                <input id="rQty" type="number" placeholder="Enter quantity" min="1" class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
            </div>
            <div>
                <label class="block text-xs font-bold text-[#5C4D3C] uppercase tracking-wider mb-2">Source / Breeder</label>
                <input id="rNote" type="text" placeholder="e.g. Local Certified Breeder" class="w-full px-4 py-3 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl focus:outline-none focus:border-[#E68A39] text-[#2D241E] text-sm"/>
            </div>
        </div>
        <div class="flex gap-3 sm:gap-4 mt-6 sm:mt-8">
            <button onclick="closeModal('restockModal')" class="flex-1 px-4 sm:px-6 py-3 border border-[#EBD7BC] text-[#5C4D3C] rounded-xl font-bold hover:bg-[#FDF8F1] transition-colors text-sm">Cancel</button>
            <button onclick="confirmRestock()" class="flex-1 px-4 sm:px-6 py-3 bg-[#34A853] text-white rounded-xl font-bold shadow-md hover:bg-[#2c8d46] transition-colors text-sm">Confirm Arrival</button>
        </div>
    </div>
</div>

<div id="toast" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-xl font-bold text-xs sm:text-sm transform translate-y-10 opacity-0 pointer-events-none transition-all duration-300 flex items-center gap-3"></div>

<script>
/* ─── DATA ─── */
const CAT_EMOJI  = {Dogs:'🐶', Cats:'🐱', Birds:'🦜', 'Small Pets':'🐹', Fish:'🐠', Reptiles:'🦎'};
const CAT_CLASS  = {
    Dogs:        'bg-[#FEF9C3] text-[#854D0E]',
    Cats:        'bg-[#FCE7F3] text-[#9D174D]',
    Birds:       'bg-[#E9F0FE] text-[#1E3A8A]',
    'Small Pets':'bg-[#EDE9FE] text-[#5B21B6]',
    Fish:        'bg-[#E9F7F2] text-[#166534]',
    Reptiles:    'bg-[#FFEDD5] text-[#C2410C]'
};
const CAT_BAR    = {
    Dogs:        'bg-[#F59E0B]', 
    Cats:        'bg-[#EC4899]',
    Birds:       'bg-[#3B82F6]', 
    'Small Pets':'bg-[#8B5CF6]', 
    Fish:        'bg-[#22C55E]',
    Reptiles:    'bg-[#EA580C]'
};

let inventory = [
  {id:1, name:'Golden Retriever Puppy', sku:'DOG-001', category:'Dogs', gender:'Male', stock:3, price:18000, thresh:1, image:null},
  {id:2, name:'Siamese Kitten', sku:'CAT-001', category:'Cats', gender:'Female', stock:2, price:12000, thresh:1, image:null},
  {id:3, name:'Holland Lop Bunny', sku:'SML-001', category:'Small Pets', gender:'Female', stock:5, price:3500, thresh:2, image:null},
  {id:6, name:'Bearded Dragon', sku:'RPT-001', category:'Reptiles', gender:'Male', stock:0, price:6500, thresh:1, image:null},
];

let nextId = 10;
let editId = null;
let restockId = null;
let currentImageData = null;

/* ─── IMAGE HANDLER ─── */
function handleImageUpload(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            currentImageData = e.target.result;
            document.getElementById('imagePreview').innerHTML = `<img src="${currentImageData}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    }
}

/* ─── STATUS HELPERS ─── */
function status(item){
  if(item.stock===0) return 'out';
  if(item.stock<=item.thresh) return 'low';
  return 'ok';
}
function statusBadge(item){
  const s = status(item);
  const labels = {ok:'Available', low:'Few Left', out:'Unavailable'};
  const classes = {
      ok:  'bg-[#E9F7F2] text-[#166634]',
      low: 'bg-[#FFF8E1] text-[#92400E]',
      out: 'bg-[#FEE2E2] text-[#991B1B]'
  };
  const dots = {ok:'bg-[#22C55E]', low:'bg-[#F59E0B]', out:'bg-[#EF4444]'};
  
  return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide ${classes[s]}">
            <span class="w-1.5 h-1.5 rounded-full ${dots[s]}"></span>
            ${labels[s]}
          </span>`;
}

/* ─── RENDER TABLE ─── */
function renderTable(){
  const q   = document.getElementById('searchQ').value.toLowerCase();
  const cat = document.getElementById('filterCat').value;
  const st  = document.getElementById('filterStatus').value;
  const tbody= document.getElementById('tbody');
  let rows='', count=0;

  inventory.forEach(item=>{
    const s=status(item);
    if(q && !item.name.toLowerCase().includes(q) && !item.sku.toLowerCase().includes(q)) return;
    if(cat && item.category!==cat) return;
    if(st && s!==st) return;
    count++;
    
    const em=CAT_EMOJI[item.category]||'🐾';
    const displayImage = item.image 
        ? `<img src="${item.image}" class="w-full h-full object-cover">` 
        : `<span class="text-lg opacity-40">${em}</span>`;
    
    const genderIcon = item.gender === 'Male' ? '<span class="text-blue-500 ml-1">♂</span>' : 
                      item.gender === 'Female' ? '<span class="text-pink-500 ml-1">♀</span>' : '';

    const val=(item.stock*item.price).toLocaleString('en-PH',{minimumFractionDigits:0});
    
    rows+=`
    <tr class="hover:bg-[#FDF8F1]/60 transition-colors group">
      <td class="px-4 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center gap-3 sm:gap-4">
          <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#FDF8F1] border border-[#F3E9DC] flex items-center justify-center shrink-0 overflow-hidden">
            ${displayImage}
          </div>
          <div>
            <div class="font-bold text-[#2D241E] text-xs sm:text-sm flex items-center">
                ${item.name} ${genderIcon}
            </div>
            <div class="text-[10px] text-gray-400 font-mono mt-0.5">${item.sku}</div>
          </div>
        </div>
      </td>
      <td class="px-4 sm:px-6 py-3 sm:py-4">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase ${CAT_CLASS[item.category]}">${em} <span class="hidden sm:inline">${item.category}</span></span>
      </td>
      <td class="px-4 sm:px-6 py-3 sm:py-4">${statusBadge(item)}</td>
      <td class="px-4 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center gap-1 bg-[#FDF8F1] border border-[#F3E9DC] rounded-xl p-1 w-fit">
          <button class="w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center rounded-lg text-[#991B1B] hover:bg-[#FEE2E2] font-bold transition-colors" onclick="adjustStock(${item.id},-1)">−</button>
          <span class="text-xs sm:text-sm font-bold text-[#2D241E] w-6 sm:w-8 text-center" id="qty-${item.id}">${item.stock}</span>
          <button class="w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center rounded-lg text-[#166534] hover:bg-[#E9F7F2] font-bold transition-colors" onclick="adjustStock(${item.id},+1)">+</button>
        </div>
      </td>
      <td class="px-4 sm:px-6 py-3 sm:py-4">
        <div class="font-bold text-xs sm:text-sm text-[#2D241E]">₱${item.price.toLocaleString('en-PH',{minimumFractionDigits:2})}</div>
        <div class="text-[10px] text-gray-400 mt-0.5">Total: ₱${val}</div>
      </td>
      <td class="px-4 sm:px-6 py-3 sm:py-4 text-right whitespace-nowrap">
        <div class="flex items-center justify-end gap-1 sm:gap-2">
          <button class="px-2 sm:px-3 py-1.5 text-[10px] sm:text-xs font-bold rounded-xl bg-[#F3E9DC]/50 text-gray-600 hover:bg-[#EBD7BC] transition-colors" onclick="openEditModal(${item.id})">Edit</button>
          <button class="px-2 sm:px-3 py-1.5 text-[10px] sm:text-xs font-bold rounded-xl bg-[#FDF2E9] text-[#E68A39] hover:bg-[#FCE1CC] transition-colors" onclick="openRestockModal(${item.id})">Arrival</button>
          <button class="px-2 sm:px-3 py-1.5 text-[10px] sm:text-xs font-bold rounded-xl bg-red-50 text-red-500 hover:bg-red-100 transition-colors" onclick="deleteItem(${item.id})">Delete</button>
        </div>
      </td>
    </tr>`;
  });

  tbody.innerHTML = rows;
  document.getElementById('emptyMsg').classList.toggle('hidden', count > 0);
  updateStats();
  updateBreakdown();
  updateRestockList();
}

/* ─── STATS ─── */
function updateStats(){
  const total=inventory.reduce((s,i)=>s+i.stock*i.price,0);
  const units=inventory.reduce((s,i)=>s+i.stock,0);
  const lows =inventory.filter(i=>status(i)!=='ok').length;
  document.getElementById('statSku').textContent=inventory.length;
  document.getElementById('statUnits').textContent=units.toLocaleString();
  document.getElementById('statLow').textContent=lows;
  document.getElementById('statVal').textContent='₱'+total.toLocaleString('en-PH',{minimumFractionDigits:0});

  const outItems=inventory.filter(i=>i.stock===0).map(i=>i.name);
  const lowItems=inventory.filter(i=>status(i)==='low').map(i=>i.name);
  const banner=document.getElementById('alertBanner');
  const alertTxt=document.getElementById('alertText');
  if(outItems.length||lowItems.length){
    banner.classList.remove('hidden');
    let msg='';
    if(outItems.length) msg+=`<span class="font-extrabold">Unavailable:</span> ${outItems.join(', ')}. `;
    if(lowItems.length) msg+=`<span class="font-extrabold">Few left:</span> ${lowItems.join(', ')}.`;
    alertTxt.innerHTML=msg;
  } else {
    banner.classList.add('hidden');
  }
}

/* ─── CATEGORY BREAKDOWN ─── */
function updateBreakdown(){
  const counts={};
  inventory.forEach(i=>{ counts[i.category]=(counts[i.category]||0)+i.stock; });
  const total=Object.values(counts).reduce((a,b)=>a+b,0)||1;
  const cats=Object.entries(counts).sort((a,b)=>b[1]-a[1]);
  document.getElementById('breakdownTotal').textContent=`${total} live pets`;
  document.getElementById('catBreakdown').innerHTML=cats.map(([cat,cnt])=>`
    <div class="flex items-center gap-2 sm:gap-3">
      <div class="text-xs sm:text-sm font-bold text-[#5C4D3C] w-24 sm:w-28 flex shrink-0 items-center gap-1 sm:gap-2">${CAT_EMOJI[cat]} ${cat}</div>
      <div class="flex-1 h-2 sm:h-2.5 bg-[#FDF8F1] border border-[#F3E9DC] rounded-full overflow-hidden">
        <div class="h-full rounded-full transition-all duration-500 ${CAT_BAR[cat]}" style="width:${(cnt/total*100).toFixed(1)}%"></div>
      </div>
      <div class="text-xs font-bold text-gray-400 w-6 sm:w-8 text-right">${cnt}</div>
    </div>`).join('');
}

/* ─── RESTOCK LIST ─── */
function updateRestockList(){
  const need=inventory.filter(i=>status(i)!=='ok').slice(0,4);
  if(!need.length){
    document.getElementById('restockList').innerHTML=`<p class="text-sm text-gray-400 text-center py-4 bg-[#FDF8F1] rounded-2xl border border-[#F3E9DC]">✅ All pet categories are well-supplied!</p>`;
    return;
  }
  document.getElementById('restockList').innerHTML=need.map(item=>`
    <div class="flex items-center justify-between py-3 border-b border-[#FDF8F1] last:border-0">
      <div class="flex items-center gap-2 sm:gap-3">
        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#FDF8F1] border border-[#F3E9DC] overflow-hidden flex items-center justify-center text-xs">
            ${item.image ? `<img src="${item.image}" class="w-full h-full object-cover">` : CAT_EMOJI[item.category]}
        </div>
        <div>
            <div class="text-xs sm:text-sm font-bold text-[#2D241E]">${item.name}</div>
            <div class="text-[10px] ${status(item)==='out'?'text-red-500':'text-[#E68A39]'} font-bold mt-0.5 uppercase tracking-tighter">${status(item)==='out'?'Unavailable':'Low Stock'}</div>
        </div>
      </div>
      <button class="px-2.5 sm:px-3 py-1.5 rounded-xl bg-[#FDF2E9] text-[#E68A39] text-[10px] sm:text-xs font-bold hover:bg-[#FCE1CC] transition-colors shrink-0" onclick="openRestockModal(${item.id})">Arrival</button>
    </div>`).join('');
}

/* ─── STOCK ADJUST ─── */
function adjustStock(id, delta){
  const item=inventory.find(i=>i.id===id);
  if(!item) return;
  const newVal=Math.max(0,item.stock+delta);
  item.stock=newVal;
  const el=document.getElementById('qty-'+id);
  if(el) el.textContent=newVal;
  renderTable();
}

/* ─── ADD ITEM MODAL ─── */
function openAddModal(){
  editId=null;
  currentImageData = null;
  document.getElementById('modalTitle').textContent='Add New Pet';
  ['mName','mSku','mStock','mPrice','mImage'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('mCat').value='';
  document.getElementById('mGender').value='';
  document.getElementById('mThresh').value='2';
  document.getElementById('imagePreview').innerHTML = '<span id="previewPlaceholder">📸</span>';
  
  const m = document.getElementById('itemModal');
  m.classList.remove('hidden'); m.classList.add('flex');
}

function openEditModal(id){
  const item=inventory.find(i=>i.id===id);
  if(!item) return;
  editId=id;
  currentImageData = item.image;
  
  document.getElementById('modalTitle').textContent='Edit Pet Details';
  document.getElementById('mName').value=item.name;
  document.getElementById('mSku').value=item.sku;
  document.getElementById('mCat').value=item.category;
  document.getElementById('mGender').value=item.gender || '';
  document.getElementById('mStock').value=item.stock;
  document.getElementById('mPrice').value=item.price;
  document.getElementById('mThresh').value=item.thresh;
  
  document.getElementById('imagePreview').innerHTML = item.image 
      ? `<img src="${item.image}" class="w-full h-full object-cover">` 
      : '<span id="previewPlaceholder">📸</span>';

  const m = document.getElementById('itemModal');
  m.classList.remove('hidden'); m.classList.add('flex');
}

function saveItem(){
  const name=document.getElementById('mName').value.trim();
  const sku =document.getElementById('mSku').value.trim();
  const cat =document.getElementById('mCat').value;
  const gender =document.getElementById('mGender').value;
  const stock=parseInt(document.getElementById('mStock').value)||0;
  const price=parseFloat(document.getElementById('mPrice').value)||0;
  const thresh=parseInt(document.getElementById('mThresh').value)||2;

  if(!name||!cat){ showToast('Please fill in pet breed and category.','error'); return; }

  if(editId){
    const item=inventory.find(i=>i.id===editId);
    Object.assign(item,{name,sku,category:cat, gender, stock,price,thresh, image: currentImageData});
    showToast(`"${name}" updated.`,'success');
  } else {
    inventory.push({
        id:nextId++,
        name,
        sku:sku||`PET-${nextId}`,
        category:cat,
        gender,
        stock,
        price,
        thresh,
        image: currentImageData
    });
    showToast(`"${name}" added to inventory.`,'success');
  }
  closeModal('itemModal');
  renderTable();
}

/* ─── RESTOCK MODAL ─── */
function openRestockModal(id){
  const item=inventory.find(i=>i.id===id);
  if(!item) return;
  restockId=id;
  
  document.getElementById('rIcon').innerHTML = item.image 
      ? `<img src="${item.image}" class="w-full h-full object-cover">` 
      : CAT_EMOJI[item.category]||'🐾';
      
  document.getElementById('rName').textContent=item.name;
  document.getElementById('rCur').textContent=`Current count: ${item.stock} · Alert threshold: ${item.thresh}`;
  document.getElementById('rQty').value='';
  document.getElementById('rNote').value='';
  
  const m = document.getElementById('restockModal');
  m.classList.remove('hidden'); m.classList.add('flex');
}

function confirmRestock(){
  const item=inventory.find(i=>i.id===restockId);
  if(!item) return;
  const qty=parseInt(document.getElementById('rQty').value)||0;
  if(qty<=0){ showToast('Enter a valid arrival quantity.','error'); return; }
  item.stock+=qty;
  closeModal('restockModal');
  renderTable();
  showToast(`✅ Logged arrival of ${qty}x ${item.name}.`,'success');
}

/* ─── HELPERS ─── */
function deleteItem(id){
  const item=inventory.find(i=>i.id===id);
  if(!item||!confirm(`Remove "${item.name}" from inventory listings?`)) return;
  inventory=inventory.filter(i=>i.id!==id);
  renderTable();
  showToast(`"${item.name}" removed.`,'success');
}
function closeModal(id){
  const m = document.getElementById(id);
  m.classList.add('hidden'); m.classList.remove('flex');
  editId=null; restockId=null;
}
function showToast(msg,type='success'){
  const t=document.getElementById('toast');
  t.innerHTML = `<span class="text-lg">${type === 'success' ? '✅' : '⚠️'}</span> <span>${msg}</span>`; 
  t.className = `fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 ${type === 'success' ? 'bg-[#34A853]' : 'bg-[#EF4444]'} text-white px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-xl font-bold text-xs sm:text-sm transform transition-all duration-300 flex items-center gap-3`;
  
  requestAnimationFrame(() => { t.classList.remove('translate-y-10', 'opacity-0'); });
  setTimeout(()=>{ t.classList.add('translate-y-10', 'opacity-0'); }, 3000);
}
function exportCSV(){
  const header='Breed/Type,SKU,Category,Gender,Headcount,Price\n';
  const rows=inventory.map(i=>`"${i.name}","${i.sku}","${i.category}","${i.gender||'N/A'}",${i.stock},${i.price}`).join('\n');
  const blob=new Blob([header+rows],{type:'text/csv'});
  const a=document.createElement('a'); a.href=URL.createObjectURL(blob);
  a.download='pets-inventory.csv'; a.click();
}

['itemModal','restockModal'].forEach(id=>{
  document.getElementById(id).addEventListener('click',function(e){
    if(e.target===this) closeModal(id);
  });
});

renderTable();
</script>
@endsection