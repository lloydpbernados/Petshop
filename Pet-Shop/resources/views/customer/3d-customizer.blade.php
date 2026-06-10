@extends('layouts.app')
@section('title', '3D Habitat Builder — PawHaven')
@section('content')
<style>
:root {
    --cream:#FDF8F1;--cream-mid:#FDF2E9;--orange:#E68A39;--orange-dark:#CF7529;
    --brown:#2D241E;--brown-sub:#5C4D3C;--brown-muted:#A68B6D;
    --border:#F3E9DC;--border-mid:#EBD7BC;--white:#ffffff;
    --shadow-md:0 6px 24px rgba(45,36,30,0.10);
    --radius-md:1.25rem;--radius-lg:1.75rem;--serif:'DM Serif Display',serif;
    --green:#34A853;--red:#EF4444;
}
*,*::before,*::after{box-sizing:border-box;}
body{background:#0a1418;margin:0;font-family:'Segoe UI',system-ui,sans-serif;overflow-x:hidden;}

/* ── Top bar ── */
.three-top-bar{height:56px;background:#0f1d24;border-bottom:1px solid #1a2f38;display:flex;align-items:center;justify-content:space-between;padding:0 1rem;position:sticky;top:0;z-index:100;}
.three-back-btn{background:transparent;border:1.5px solid #2a3f48;color:#8bc5d6;padding:7px 14px;border-radius:99px;font-size:0.82rem;font-weight:600;cursor:pointer;transition:all 0.2s;text-decoration:none;white-space:nowrap;}
.three-back-btn:hover{border-color:var(--orange);color:var(--orange);background:rgba(255,255,255,0.05);}
.three-title{color:#e8f4f8;font-family:var(--serif);font-size:1.1rem;margin:0;}

/* ── Layout ── */
.three-container{width:100%;height:calc(100vh - 56px);display:flex;flex-direction:row;overflow:hidden;}
#threejs-container{flex:1;position:relative;cursor:grab;overflow:hidden;min-width:0;background:radial-gradient(ellipse at center,#1a3a4a 0%,#0a1418 100%);}
#threejs-container.dragging{cursor:grabbing!important;}
#threejs-container canvas{display:block;width:100%!important;height:100%!important;}

/* ── Sidebar ── */
.builder-sidebar{width:320px;min-width:280px;max-width:360px;background:#faf7f2;display:flex;flex-direction:column;border-left:1px solid var(--border);flex-shrink:0;overflow:hidden;}
.sidebar-top{padding:0.9rem 1rem 0;flex-shrink:0;}
.sidebar-scroll{flex:1;overflow-y:auto;padding:0 1rem 1rem;}

/* ── Cage type tabs ── */
.cage-type-tabs{display:flex;gap:3px;background:#0a0f14;border-radius:10px;padding:3px;margin-bottom:0.75rem;}
.cage-type-tab{flex:1;padding:8px 4px;background:transparent;border:none;color:#8a9aa5;font-size:0.75rem;font-weight:700;cursor:pointer;border-radius:7px;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:4px;font-family:inherit;}
.cage-type-tab:hover{color:#e8f4f8;}
.cage-type-tab.active{color:var(--orange);background:rgba(230,138,57,0.1);}

/* ── Size selector ── */
.size-row{display:flex;gap:6px;margin-bottom:0.85rem;}
.size-btn{flex:1;padding:8px 6px;border:2px solid var(--border);border-radius:10px;background:var(--white);cursor:pointer;text-align:center;font-family:inherit;transition:all 0.18s;}
.size-btn:hover{border-color:var(--orange);background:#FFF8F0;}
.size-btn.active{border-color:var(--orange);background:#FFF3E5;box-shadow:0 0 0 3px rgba(230,138,57,0.18);}
.size-btn .size-label{display:block;font-size:0.78rem;font-weight:800;color:var(--brown);}
.size-btn .size-dim{display:block;font-size:0.65rem;color:var(--brown-muted);margin-top:1px;}
.size-btn .size-price{display:block;font-size:0.72rem;font-weight:700;color:var(--orange);margin-top:2px;}

/* ── Slot list ── */
.slots-heading{font-size:0.68rem;font-weight:800;color:var(--brown-muted);text-transform:uppercase;letter-spacing:0.1em;margin:0.85rem 0 0.5rem;}
.slot-row{display:flex;align-items:center;gap:0.65rem;padding:0.6rem 0.75rem;border:2px solid var(--border);border-radius:10px;background:var(--white);cursor:pointer;transition:all 0.18s;margin-bottom:0.4rem;width:100%;text-align:left;font-family:inherit;}
.slot-row:hover{border-color:var(--orange);background:#FFFAF5;}
.slot-row.filled{border-color:var(--border-mid);background:var(--cream);}
.slot-row.active-slot{border-color:var(--orange);box-shadow:0 0 0 3px rgba(230,138,57,0.2);}
.slot-icon{width:36px;height:36px;border-radius:8px;background:var(--cream-mid);border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;overflow:hidden;}
.slot-icon img{width:100%;height:100%;object-fit:cover;border-radius:inherit;}
.slot-info{flex:1;min-width:0;}
.slot-label{font-size:0.68rem;font-weight:800;color:var(--brown-muted);text-transform:uppercase;letter-spacing:0.06em;}
.slot-value{font-size:0.85rem;font-weight:700;color:var(--brown);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-top:1px;}
.slot-price{font-size:0.72rem;color:var(--orange);font-weight:600;margin-top:1px;}
.slot-arrow{font-size:0.7rem;color:var(--brown-muted);flex-shrink:0;}
.slot-clear{width:22px;height:22px;border-radius:50%;background:#FEE2E2;border:none;color:#EF4444;font-size:0.7rem;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.15s;}
.slot-clear:hover{background:#FECACA;}

/* ── Summary box ── */
.summary-box{background:linear-gradient(135deg,#FDF8F1,#FDF2E9);padding:1rem;border-radius:10px;border:1.5px solid var(--border-mid);margin-top:0.75rem;}
.summary-line{display:flex;justify-content:space-between;font-size:0.82rem;color:var(--brown-sub);margin-bottom:0.3rem;}
.total-row{border-top:2px dashed var(--border-mid);margin-top:0.5rem;padding-top:0.5rem;display:flex;justify-content:space-between;align-items:center;}
.total-label{font-weight:800;color:var(--brown);font-size:0.95rem;}
.total-price{font-weight:800;color:var(--orange);font-size:1.15rem;}
.add-btn{width:100%;background:linear-gradient(135deg,var(--orange),var(--orange-dark));color:white;border:none;padding:0.85rem;border-radius:30px;font-size:0.92rem;font-weight:700;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 16px rgba(230,138,57,0.35);margin-top:0.75rem;font-family:inherit;}
.add-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(230,138,57,0.5);}

/* ── Picker panel (slides over the scene) ── */
.picker-panel{position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(10,20,24,0.96);z-index:50;display:flex;flex-direction:column;transform:translateY(100%);transition:transform 0.28s cubic-bezier(0.4,0,0.2,1);backdrop-filter:blur(6px);}
.picker-panel.open{transform:translateY(0);}
.picker-header{padding:1rem 1.25rem;border-bottom:1px solid #1a2f38;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
.picker-title{color:#e8f4f8;font-weight:800;font-size:1rem;}
.picker-close{background:rgba(255,255,255,0.08);border:1px solid #2a3f48;color:#8bc5d6;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:0.9rem;display:flex;align-items:center;justify-content:center;transition:all 0.15s;}
.picker-close:hover{border-color:var(--orange);color:var(--orange);}
.picker-search{padding:0.75rem 1.25rem;flex-shrink:0;}
.picker-search input{width:100%;padding:9px 14px 9px 38px;background:#0f1d24;border:1.5px solid #1a2f38;border-radius:10px;color:#e8f4f8;font-size:0.88rem;outline:none;transition:border-color 0.2s;}
.picker-search input:focus{border-color:var(--orange);}
.picker-search-wrap{position:relative;}
.picker-search-wrap::before{content:'🔍';position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:0.85rem;pointer-events:none;}
.picker-grid{flex:1;overflow-y:auto;padding:0.75rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:0.75rem;align-content:start;}
.picker-card{background:#0f1d24;border:2px solid #1a2f38;border-radius:12px;padding:0.85rem 0.75rem;cursor:pointer;transition:all 0.18s;display:flex;flex-direction:column;align-items:center;gap:0.5rem;text-align:center;position:relative;}
.picker-card:hover{border-color:var(--orange);background:#162530;}
.picker-card.selected{border-color:var(--orange);background:#1a2e20;box-shadow:0 0 0 3px rgba(230,138,57,0.25);}
.picker-card.selected::after{content:'✓';position:absolute;top:8px;right:10px;font-size:0.65rem;font-weight:800;color:var(--orange);}
.picker-card-icon{width:52px;height:52px;border-radius:10px;background:#162530;display:flex;align-items:center;justify-content:center;font-size:1.6rem;overflow:hidden;}
.picker-card-icon img{width:100%;height:100%;object-fit:cover;border-radius:inherit;}
.picker-card-name{font-size:0.8rem;font-weight:700;color:#e8f4f8;line-height:1.3;}
.picker-card-price{font-size:0.75rem;font-weight:700;color:var(--orange);}
.picker-card-badge{font-size:0.6rem;font-weight:800;background:#FEF9C3;color:#92400E;border:1px solid #FDE68A;padding:1px 6px;border-radius:99px;}
.picker-empty{grid-column:1/-1;text-align:center;color:#4a6b7c;padding:3rem 1rem;font-size:0.9rem;}

/* ── 3D overlays ── */
.drag-hint-overlay{position:absolute;bottom:0.75rem;left:50%;transform:translateX(-50%);background:rgba(10,20,30,0.8);color:#fff;padding:7px 14px;border-radius:99px;font-size:0.75rem;font-weight:600;pointer-events:none;transition:opacity 0.3s;z-index:10;backdrop-filter:blur(8px);white-space:nowrap;border:1px solid rgba(255,255,255,0.15);}
.drag-hint-overlay.hidden{opacity:0;}
.selection-panel{position:absolute;top:0.75rem;left:0.75rem;background:rgba(255,255,255,0.95);border:1.5px solid var(--border);border-radius:10px;padding:10px 14px;box-shadow:var(--shadow-md);z-index:10;display:none;min-width:160px;backdrop-filter:blur(8px);}
.selection-panel.show{display:block;}
.selection-panel h4{font-size:0.72rem;font-weight:800;color:var(--brown-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;}
.selection-panel .sel-name{font-size:0.85rem;font-weight:700;color:var(--brown);margin-bottom:6px;}
.selection-panel .sel-actions{display:flex;gap:5px;}
.sel-btn{flex:1;padding:5px 8px;border-radius:7px;border:1.5px solid var(--border);background:var(--white);font-size:0.72rem;font-weight:700;cursor:pointer;transition:all 0.15s;font-family:inherit;}
.sel-btn.rotate:hover{border-color:#3B82F6;color:#3B82F6;background:#EFF6FF;}
.sel-btn.danger:hover{border-color:#EF4444;color:#EF4444;background:#FEF2F2;}
.tank-controls-bar{position:absolute;top:0.75rem;right:0.75rem;display:flex;gap:5px;z-index:10;}
.tank-ctrl-btn{width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.9);border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.9rem;transition:all 0.15s;box-shadow:var(--shadow-md);backdrop-filter:blur(8px);}
.tank-ctrl-btn:hover{border-color:var(--orange);transform:scale(1.05);}
.tank-ctrl-btn.active{background:var(--orange);color:white;border-color:var(--orange);}

/* ── Skeleton ── */
.supply-skeleton{height:52px;background:linear-gradient(90deg,#f0e8df 25%,#fdf8f1 50%,#f0e8df 75%);background-size:200% 100%;animation:shimmer 1.4s infinite;border-radius:10px;margin-bottom:0.4rem;}
@keyframes shimmer{0%{background-position:200% 0;}100%{background-position:-200% 0;}}

@media(max-width:768px){
    .three-container{flex-direction:column;height:auto;min-height:calc(100vh - 56px);}
    #threejs-container{width:100%;height:55vw;min-height:240px;max-height:360px;flex:none;}
    .builder-sidebar{width:100%;min-width:unset;max-width:unset;border-left:none;border-top:2px solid var(--border-mid);max-height:50vh;overflow-y:auto;}
    .picker-grid{grid-template-columns:repeat(auto-fill,minmax(120px,1fr));}
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<div class="three-top-bar">
    <a href="{{ route('shop') }}" class="three-back-btn">← Back to Shop</a>
    <h1 class="three-title">🎨 3D Habitat Builder</h1>
</div>

<div class="three-container">
    {{-- 3D Viewport --}}
    <div id="threejs-container">
        <div id="dragHint" class="drag-hint-overlay">🖱️ Click items to select · Drag to reposition · Scroll to zoom</div>

        <div id="selectionPanel" class="selection-panel">
            <h4>Selected</h4>
            <div class="sel-name" id="selItemName">—</div>
            <div class="sel-actions">
                <button class="sel-btn rotate" id="selRotateBtn">↻ Rotate</button>
                <button class="sel-btn danger" id="selDeleteBtn">🗑 Remove</button>
            </div>
        </div>

        <div class="tank-controls-bar">
            <button class="tank-ctrl-btn" id="tankResetView" title="Reset Camera">🎥</button>
        </div>

        {{-- Picker panel — slides up from bottom of viewport --}}
        <div class="picker-panel" id="pickerPanel">
            <div class="picker-header">
                <span class="picker-title" id="pickerTitle">Choose an item</span>
                <button class="picker-close" id="pickerClose">✕</button>
            </div>
            <div class="picker-search">
                <div class="picker-search-wrap">
                    <input type="text" id="pickerSearch" placeholder="Search…">
                </div>
            </div>
            <div class="picker-grid" id="pickerGrid"></div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="builder-sidebar">
        <div class="sidebar-top">
            {{-- Pet type tabs --}}
            <div class="cage-type-tabs" id="cageTypeTabs">
                <button class="cage-type-tab active" data-cage="fish">🐠 Fish</button>
                <button class="cage-type-tab" data-cage="bird">🦜 Bird</button>
                <button class="cage-type-tab" data-cage="hamster">🐹 Hamster</button>
            </div>

            {{-- Cage size selector --}}
            <div class="size-row" id="sizeRow"></div>
        </div>

        <div class="sidebar-scroll">
            {{-- Slot list populated by JS --}}
            <div id="slotList"></div>

            {{-- Summary --}}
            <div class="summary-box">
                <div id="summaryLines"></div>
                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-price" id="grandTotal">₱0</span>
                </div>
                <button class="add-btn" id="addToCartBtn">Add Habitat to Cart 🛒</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

// ═══════════════════════════════════════════════════════════════════════════
// CONFIG — cage types, sizes, and their slots
// ═══════════════════════════════════════════════════════════════════════════
const CAGE_TYPES = {
    fish: {
        label: 'Aquarium',
        emoji: '🐠',
        sizes: [
            { id: 'sm', label: 'Small',  dim: '30×20cm', price: 800,  bounds: { minX:-1.0, maxX:1.0, minY:-0.8, maxY:0.6, minZ:-0.7, maxZ:0.7 } },
            { id: 'md', label: 'Medium', dim: '60×35cm', price: 1200, bounds: { minX:-1.75,maxX:1.75,minY:-1.0, maxY:0.9, minZ:-1.05,maxZ:1.05} },
            { id: 'lg', label: 'Large',  dim: '90×45cm', price: 2200, bounds: { minX:-2.5, maxX:2.5, minY:-1.3, maxY:1.2, minZ:-1.4, maxZ:1.4 } },
        ],
        // Each slot: id, label, emoji, acceptedCategories (from API category field)
        slots: [
            { id: 'pet',    label: 'Fish / Breed',  emoji: '🐠', acceptedCategories: ['Fish'],                   slotType: 'pet'    },
            { id: 'food',   label: 'Food',           emoji: '🍖', acceptedCategories: ['Food'],                   slotType: 'supply' },
            { id: 'deco1',  label: 'Decoration',     emoji: '🎀', acceptedCategories: ['Accessories'],            slotType: 'supply' },
            { id: 'deco2',  label: 'Plant / Rock',   emoji: '🪨', acceptedCategories: ['Accessories','Toys'],     slotType: 'supply' },
            { id: 'health', label: 'Health',         emoji: '💊', acceptedCategories: ['Health'],                 slotType: 'supply' },
        ],
    },
    bird: {
        label: 'Bird Cage',
        emoji: '🦜',
        sizes: [
            { id: 'sm', label: 'Small',  dim: '40×40cm', price: 900,  bounds: { minX:-0.7, maxX:0.7, minY:-1.0, maxY:1.0, minZ:-0.7, maxZ:0.7 } },
            { id: 'md', label: 'Medium', dim: '60×60cm', price: 1800, bounds: { minX:-1.1, maxX:1.1, minY:-1.2, maxY:1.2, minZ:-1.1, maxZ:1.1 } },
            { id: 'lg', label: 'Large',  dim: '80×80cm', price: 3200, bounds: { minX:-1.6, maxX:1.6, minY:-1.5, maxY:1.5, minZ:-1.4, maxZ:1.4 } },
        ],
        slots: [
            { id: 'pet',    label: 'Bird / Breed',  emoji: '🦜', acceptedCategories: ['Bird'],                   slotType: 'pet'    },
            { id: 'food',   label: 'Food',           emoji: '🍖', acceptedCategories: ['Food'],                   slotType: 'supply' },
            { id: 'perch',  label: 'Perch / Toy',   emoji: '🎾', acceptedCategories: ['Toys','Accessories'],     slotType: 'supply' },
            { id: 'health', label: 'Health',         emoji: '💊', acceptedCategories: ['Health'],                 slotType: 'supply' },
        ],
    },
    hamster: {
        label: 'Hamster Home',
        emoji: '🐹',
        sizes: [
            { id: 'sm', label: 'Small',  dim: '40×25cm', price: 700,  bounds: { minX:-1.0, maxX:1.0, minY:-0.6, maxY:0.6, minZ:-0.8, maxZ:0.8 } },
            { id: 'md', label: 'Medium', dim: '60×40cm', price: 1500, bounds: { minX:-1.5, maxX:1.5, minY:-0.8, maxY:0.8, minZ:-1.1, maxZ:1.1 } },
            { id: 'lg', label: 'Large',  dim: '80×50cm', price: 2500, bounds: { minX:-2.0, maxX:2.0, minY:-1.0, maxY:1.0, minZ:-1.4, maxZ:1.4 } },
        ],
        slots: [
            { id: 'pet',     label: 'Hamster / Breed', emoji: '🐹', acceptedCategories: ['Hamster','Rabbit','Small Animal'], slotType: 'pet'    },
            { id: 'food',    label: 'Food',             emoji: '🍖', acceptedCategories: ['Food'],                             slotType: 'supply' },
            { id: 'wheel',   label: 'Wheel / Toy',      emoji: '🎾', acceptedCategories: ['Toys'],                             slotType: 'supply' },
            { id: 'bedding', label: 'Accessory',        emoji: '🎀', acceptedCategories: ['Accessories'],                      slotType: 'supply' },
            { id: 'health',  label: 'Health',           emoji: '💊', acceptedCategories: ['Health'],                           slotType: 'supply' },
        ],
    },
};

const CAT_EMOJI = { Food:'🍖',Toys:'🎾',Accessories:'🎀',Health:'💊',Grooming:'🪮',Fish:'🐟',Bird:'🦜',Hamster:'🐹',Rabbit:'🐰',Cat:'🐱',Dog:'🐶','Small Animal':'🐭',Reptile:'🦎' };

// ═══════════════════════════════════════════════════════════════════════════
// STATE
// ═══════════════════════════════════════════════════════════════════════════
let currentCageType = 'fish';
let currentSizeId   = 'md';
let slotSelections  = {};  // { slotId: apiItem }
let activePickerSlot = null;

let apiSupplies = [];
let apiPets     = [];

// Three.js
const container = document.getElementById('threejs-container');
let scene, camera, renderer, orbitControls;
let habitatGroup;
let placedMeshes   = {};   // { slotId: THREE.Group }
let selectedObject = null;
let isDragging     = false;
let raycaster, mouse;
let dragOffset     = new THREE.Vector3();
let highlightOutlines = [];
let is3DInitialized   = false;
let animationTime     = 0;
let bubbleParticles   = null;
let causticLight      = null;
let waterSurfaceMesh  = null;

// ═══════════════════════════════════════════════════════════════════════════
// API FETCH
// ═══════════════════════════════════════════════════════════════════════════
async function fetchAll() {
    try {
        const [supRes, petRes] = await Promise.all([
            fetch('/api/v1/supplies'),
            fetch('/api/v1/pets'),
        ]);
        apiSupplies = supRes.ok ? await supRes.json() : [];
        apiPets     = petRes.ok ? await petRes.json() : [];
    } catch(e) {
        console.error('API fetch failed', e);
    }
    renderSidebar();
}

// ═══════════════════════════════════════════════════════════════════════════
// SIDEBAR — size buttons + slot rows
// ═══════════════════════════════════════════════════════════════════════════
function renderSidebar() {
    const cfg   = CAGE_TYPES[currentCageType];
    const sizes = cfg.sizes;

    // Size buttons
    const sizeRow = document.getElementById('sizeRow');
    sizeRow.innerHTML = sizes.map(s => `
        <button class="size-btn${s.id === currentSizeId ? ' active' : ''}" data-size="${s.id}">
            <span class="size-label">${s.label}</span>
            <span class="size-dim">${s.dim}</span>
            <span class="size-price">₱${s.price.toLocaleString()}</span>
        </button>`).join('');
    sizeRow.querySelectorAll('.size-btn').forEach(btn =>
        btn.addEventListener('click', () => {
            currentSizeId = btn.dataset.size;
            rebuildCage();
            renderSidebar();
        })
    );

    // Slot list
    const slotList = document.getElementById('slotList');
    slotList.innerHTML = `<div class="slots-heading">Configure Slots</div>`;

    cfg.slots.forEach(slot => {
        const sel   = slotSelections[slot.id];
        const row   = document.createElement('button');
        row.className = `slot-row${sel ? ' filled' : ''}${activePickerSlot === slot.id ? ' active-slot' : ''}`;
        row.dataset.slotId = slot.id;

        let iconHtml = `<span style="font-size:1.1rem;">${slot.emoji}</span>`;
        if (sel) {
            if (sel.image) iconHtml = `<img src="${sel.image}" alt="${sel.name}">`;
            else iconHtml = `<span style="font-size:1.1rem;">${sel.emoji || slot.emoji}</span>`;
        }

        row.innerHTML = `
            <div class="slot-icon">${iconHtml}</div>
            <div class="slot-info">
                <div class="slot-label">${slot.label}</div>
                <div class="slot-value">${sel ? sel.name : '— Empty —'}</div>
                ${sel ? `<div class="slot-price">₱${getItemPrice(sel).toLocaleString()}</div>` : ''}
            </div>
            ${sel
                ? `<button class="slot-clear" data-slot="${slot.id}" title="Remove">✕</button>`
                : `<span class="slot-arrow">›</span>`
            }`;

        row.addEventListener('click', e => {
            if (e.target.closest('.slot-clear')) {
                clearSlot(e.target.closest('.slot-clear').dataset.slot);
                return;
            }
            openPicker(slot);
        });
        slotList.appendChild(row);
    });

    renderSummary();
}

function getItemPrice(item) {
    if (Array.isArray(item.weight_options) && item.weight_options.length) {
        return Math.min(...item.weight_options.map(o => parseFloat(o.price)));
    }
    return parseFloat(item.price) || 0;
}

function renderSummary() {
    const cfg     = CAGE_TYPES[currentCageType];
    const size    = cfg.sizes.find(s => s.id === currentSizeId);
    let total     = size.price;
    const lines   = document.getElementById('summaryLines');
    lines.innerHTML = `<div class="summary-line"><span>${cfg.label} (${size.label})</span><span>₱${size.price.toLocaleString()}</span></div>`;

    Object.entries(slotSelections).forEach(([slotId, item]) => {
        const price = getItemPrice(item);
        total += price;
        lines.innerHTML += `<div class="summary-line"><span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:170px;">${item.emoji || '📦'} ${item.name}</span><span>₱${price.toLocaleString()}</span></div>`;
    });

    document.getElementById('grandTotal').textContent = '₱' + total.toLocaleString();
}

// ═══════════════════════════════════════════════════════════════════════════
// PICKER PANEL
// ═══════════════════════════════════════════════════════════════════════════
function openPicker(slot) {
    activePickerSlot = slot.id;
    renderSidebar(); // highlight active slot

    document.getElementById('pickerTitle').textContent = `Choose: ${slot.label}`;
    document.getElementById('pickerSearch').value = '';
    renderPickerGrid(slot, '');

    document.getElementById('pickerPanel').classList.add('open');
    document.getElementById('pickerSearch').focus();
}

function closePicker() {
    document.getElementById('pickerPanel').classList.remove('open');
    activePickerSlot = null;
    renderSidebar();
}

function renderPickerGrid(slot, query) {
    const grid = document.getElementById('pickerGrid');
    const q    = query.toLowerCase();

    // Build candidate list from API
    let candidates = [];

    if (slot.slotType === 'pet') {
        candidates = apiPets
            .filter(p => p.status !== 'out')
            .filter(p => slot.acceptedCategories.includes(p.category))
            .map(p => ({
                _type:    'pet',
                id:       p.id,
                key:      'pet-' + p.id,
                name:     p.name,
                category: p.category,
                price:    parseFloat(p.price) || 0,
                emoji:    p.emoji || CAT_EMOJI[p.category] || '🐾',
                image:    p.image || null,
                status:   p.status,
                weight_options: [],
            }));
    } else {
        candidates = apiSupplies
            .filter(s => s.status !== 'out')
            .filter(s => slot.acceptedCategories.includes(s.category))
            .map(s => ({
                _type:    'supply',
                id:       s.id,
                key:      'supply-' + s.id,
                name:     s.name,
                category: s.category,
                price:    getItemPrice(s),
                emoji:    s.emoji || CAT_EMOJI[s.category] || '📦',
                image:    s.image || null,
                status:   s.status,
                weight_options: s.weight_options || [],
            }));
    }

    if (q) candidates = candidates.filter(c => c.name.toLowerCase().includes(q));

    if (!candidates.length) {
        grid.innerHTML = `<div class="picker-empty">😔 No items found for this slot.<br><small style="color:#3a5a6a;font-size:0.75rem;">Add some in the admin inventory panel.</small></div>`;
        return;
    }

    const currentSel = slotSelections[activePickerSlot];

    grid.innerHTML = candidates.map(item => {
        const isSelected = currentSel && currentSel.key === item.key;
        const iconHtml   = item.image
            ? `<img src="${item.image}" alt="${item.name}">`
            : `<span>${item.emoji}</span>`;
        const lowBadge   = item.status === 'low' ? `<div class="picker-card-badge">Low Stock</div>` : '';
        const weightNote = item.weight_options.length ? `<div style="font-size:0.62rem;color:#4a7a6a;margin-top:2px;">⚖️ ${item.weight_options.map(o=>o.kg+'kg').join(' · ')}</div>` : '';
        return `
            <div class="picker-card${isSelected ? ' selected' : ''}" data-item-key="${item.key}">
                <div class="picker-card-icon">${iconHtml}</div>
                <div class="picker-card-name">${item.name}</div>
                <div class="picker-card-price">₱${item.price.toLocaleString()}</div>
                ${weightNote}
                ${lowBadge}
            </div>`;
    }).join('');

    grid.querySelectorAll('.picker-card').forEach(card => {
        card.addEventListener('click', () => {
            const key  = card.dataset.itemKey;
            const item = candidates.find(c => c.key === key);
            if (item) selectSlotItem(activePickerSlot, item);
        });
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// SLOT MANAGEMENT
// ═══════════════════════════════════════════════════════════════════════════
function selectSlotItem(slotId, item) {
    slotSelections[slotId] = item;
    placeMeshForSlot(slotId, item);
    closePicker();
}

function clearSlot(slotId) {
    delete slotSelections[slotId];
    removeMeshForSlot(slotId);
    renderSidebar();
}

// ═══════════════════════════════════════════════════════════════════════════
// 3D — MESH PLACEMENT PER SLOT
// ═══════════════════════════════════════════════════════════════════════════

// Each slot has a default spawn position inside the cage
const SLOT_SPAWN = {
    pet:    { x:  0.0, z:  0.0 },
    food:   { x: -0.8, z:  0.5 },
    deco1:  { x:  0.7, z: -0.4 },
    deco2:  { x: -0.6, z: -0.6 },
    health: { x:  0.6, z:  0.6 },
    perch:  { x:  0.0, z: -0.5 },
    wheel:  { x:  0.5, z:  0.3 },
    bedding:{ x: -0.5, z:  0.5 },
};

function placeMeshForSlot(slotId, item) {
    removeMeshForSlot(slotId);

    const group = createItemMesh(item);
    if (!group) return;

    const spawn = SLOT_SPAWN[slotId] || { x: 0, z: 0 };
    group.position.x = spawn.x + (Math.random() - 0.5) * 0.15;
    group.position.z = spawn.z + (Math.random() - 0.5) * 0.15;
    group.userData.draggable = true;
    group.userData.slotId    = slotId;
    group.userData.itemName  = item.name;
    group.userData.itemKey   = item.key;

    habitatGroup.add(group);
    placedMeshes[slotId] = group;
    renderSidebar();
}

function removeMeshForSlot(slotId) {
    if (!placedMeshes[slotId]) return;
    const g = placedMeshes[slotId];
    if (selectedObject === g) deselectObject();
    habitatGroup.remove(g);
    g.traverse(c => {
        if (c.geometry) c.geometry.dispose();
        if (c.material) { if (Array.isArray(c.material)) c.material.forEach(m => m.dispose()); else c.material.dispose(); }
    });
    delete placedMeshes[slotId];
}

// ═══════════════════════════════════════════════════════════════════════════
// MESH CREATORS
// ═══════════════════════════════════════════════════════════════════════════
function createItemMesh(item) {
    if (item._type === 'pet') return createPetMesh(item);
    const cat = (item.category || '').toLowerCase();
    if (cat === 'food')        return createFoodMesh();
    if (cat === 'toys')        return createToyMesh();
    if (cat === 'accessories') return createAccessoryMesh();
    if (cat === 'health')      return createHealthMesh();
    if (cat === 'grooming')    return createGroomingMesh();
    return createGenericBox(item);
}

function createPetMesh(item) {
    const group = new THREE.Group();
    const petColors = { Fish:0xff6b35, Bird:0x4fc3f7, Hamster:0xe8b97e, Rabbit:0xf5f5f5, Cat:0xc8a96e, Dog:0xd4a574, 'Small Animal':0xe8b97e, Reptile:0x81c784 };
    const color = petColors[item.category] || 0xe68a39;
    const mat   = new THREE.MeshPhysicalMaterial({ color, roughness:0.55, metalness:0.05, clearcoat:0.3 });

    // Body
    const body = new THREE.Mesh(new THREE.SphereGeometry(0.18,16,12), mat);
    body.castShadow = true; group.add(body);
    // Head
    const head = new THREE.Mesh(new THREE.SphereGeometry(0.13,14,10), mat);
    head.position.set(0.15, 0.15, 0); head.castShadow = true; group.add(head);
    // Ears
    const earMat = new THREE.MeshStandardMaterial({ color, roughness:0.7 });
    [-0.04, 0.04].forEach(z => {
        const ear = new THREE.Mesh(new THREE.ConeGeometry(0.035, 0.08, 5), earMat);
        ear.position.set(0.15, 0.29, z); group.add(ear);
    });
    // Eyes
    const eyeMat = new THREE.MeshStandardMaterial({ color:0x1a1410 });
    [-0.04, 0.04].forEach(z => {
        const eye = new THREE.Mesh(new THREE.SphereGeometry(0.018,6,4), eyeMat);
        eye.position.set(0.27, 0.16, z); group.add(eye);
    });
    // Tail
    const tailCurve = new THREE.QuadraticBezierCurve3(
        new THREE.Vector3(-0.18,0,0), new THREE.Vector3(-0.28,0.18,0), new THREE.Vector3(-0.22,0.28,0));
    group.add(new THREE.Mesh(new THREE.TubeGeometry(tailCurve,8,0.025,6,false), new THREE.MeshStandardMaterial({ color, roughness:0.6 })));

    group.position.set(0, -0.85, 0);
    group.userData.idlePhase = Math.random() * Math.PI * 2;
    return group;
}

function createFoodMesh() {
    const group = new THREE.Group();
    const mat   = new THREE.MeshPhysicalMaterial({ color:0xe76f51, roughness:0.3, metalness:0.1, clearcoat:0.7 });
    const bowl  = new THREE.Mesh(new THREE.LatheGeometry([
        new THREE.Vector2(0,0), new THREE.Vector2(0.14,0), new THREE.Vector2(0.17,0.05),
        new THREE.Vector2(0.17,0.11), new THREE.Vector2(0.15,0.13), new THREE.Vector2(0.13,0.11),
    ], 24), mat);
    bowl.castShadow = true; group.add(bowl);
    const fc = [0xd4a574,0xc8956a,0xb8835a,0xe0b888];
    for (let i=0;i<18;i++) {
        const p = new THREE.Mesh(new THREE.SphereGeometry(0.018,6,4), new THREE.MeshStandardMaterial({ color:fc[i%4], roughness:0.9 }));
        p.position.set((Math.random()-.5)*0.14, 0.07+Math.random()*0.04, (Math.random()-.5)*0.14);
        p.scale.y = 0.55; group.add(p);
    }
    group.position.y = -1.18;
    return group;
}

function createToyMesh() {
    const group = new THREE.Group();
    const cols  = [0xff6b35,0x4fc3f7,0x81c784,0xffb74d,0xce93d8];
    const c1    = cols[Math.floor(Math.random()*cols.length)];
    const c2    = cols[(cols.indexOf(c1)+2)%cols.length];
    group.add(Object.assign(new THREE.Mesh(new THREE.SphereGeometry(0.18,24,18), new THREE.MeshPhysicalMaterial({ color:c1, roughness:0.35, clearcoat:0.6 })), { castShadow:true }));
    const stripe = new THREE.Mesh(new THREE.TorusGeometry(0.185,0.02,8,32), new THREE.MeshPhysicalMaterial({ color:c2, roughness:0.35, clearcoat:0.6 }));
    stripe.rotation.x = Math.PI/2; group.add(stripe);
    group.position.y = -0.82;
    return group;
}

function createAccessoryMesh() {
    const group = new THREE.Group();
    const pot   = new THREE.Mesh(new THREE.LatheGeometry([
        new THREE.Vector2(0,0),new THREE.Vector2(0.1,0),new THREE.Vector2(0.12,0.05),
        new THREE.Vector2(0.1,0.16),new THREE.Vector2(0.13,0.18),
    ],20), new THREE.MeshStandardMaterial({ color:0xbf8040, roughness:0.7 }));
    pot.castShadow = true; group.add(pot);
    group.add(Object.assign(new THREE.Mesh(new THREE.CylinderGeometry(0.10,0.10,0.02,20), new THREE.MeshStandardMaterial({ color:0x5c3a1e, roughness:0.95 })), { position: { x:0, y:0.18, z:0 } }));
    const soil = new THREE.Mesh(new THREE.CylinderGeometry(0.10,0.10,0.02,20), new THREE.MeshStandardMaterial({ color:0x5c3a1e, roughness:0.95 }));
    soil.position.y = 0.18; group.add(soil);
    const leafMat = new THREE.MeshStandardMaterial({ color:0x4caf50, roughness:0.65, side:THREE.DoubleSide });
    for (let i=0;i<5;i++) {
        const a = (i/5)*Math.PI*2, h = 0.18+Math.random()*0.14;
        const leaf = new THREE.Mesh(new THREE.ConeGeometry(0.04,h,5), leafMat);
        leaf.position.set(Math.cos(a)*0.04, 0.18+h/2, Math.sin(a)*0.04);
        leaf.rotation.z = (Math.random()-.5)*0.6; group.add(leaf);
    }
    group.position.y = -0.95;
    return group;
}

function createHealthMesh() {
    const group = new THREE.Group();
    const bottle = new THREE.Mesh(new THREE.CylinderGeometry(0.1,0.1,0.35,16), new THREE.MeshPhysicalMaterial({ color:0x80cbc4, transparent:true, opacity:0.55, roughness:0.1, transmission:0.65, clearcoat:0.8 }));
    bottle.position.y = 0.22; group.add(bottle);
    const cap = new THREE.Mesh(new THREE.CylinderGeometry(0.11,0.11,0.06,16), new THREE.MeshStandardMaterial({ color:0x00897b, roughness:0.4, metalness:0.3 }));
    cap.position.y = 0.42; group.add(cap);
    const label = new THREE.Mesh(new THREE.CylinderGeometry(0.101,0.101,0.16,16,1,true), new THREE.MeshStandardMaterial({ color:0xffffff, roughness:0.5 }));
    label.position.y = 0.22; group.add(label);
    [new THREE.BoxGeometry(0.06,0.015,0.005), new THREE.BoxGeometry(0.015,0.06,0.005)].forEach(geo => {
        const m = new THREE.Mesh(geo, new THREE.MeshStandardMaterial({ color:0xe53935 }));
        m.position.set(0,0.22,0.102); group.add(m);
    });
    group.position.y = -0.55;
    return group;
}

function createGroomingMesh() {
    const group = new THREE.Group();
    const handle = new THREE.Mesh(new THREE.CylinderGeometry(0.04,0.035,0.5,12), new THREE.MeshPhysicalMaterial({ color:0x8b5e3c, roughness:0.6, clearcoat:0.3 }));
    handle.rotation.z = Math.PI/2; handle.position.x = -0.2; group.add(handle);
    const pad = new THREE.Mesh(new THREE.BoxGeometry(0.26,0.08,0.14), new THREE.MeshStandardMaterial({ color:0x5d4037, roughness:0.7 }));
    pad.position.x = 0.15; group.add(pad);
    const bm = new THREE.MeshStandardMaterial({ color:0xfff8e1, roughness:0.9 });
    for (let r=0;r<3;r++) for (let c=0;c<6;c++) {
        const b = new THREE.Mesh(new THREE.CylinderGeometry(0.006,0.006,0.07,4), bm);
        b.position.set(0.04+c*0.04,-0.08,-0.05+r*0.05); group.add(b);
    }
    group.rotation.y = Math.PI/6; group.position.y = -0.95;
    return group;
}

function createGenericBox(item) {
    const group   = new THREE.Group();
    const palette = [0xe68a39,0x4fc3f7,0x81c784,0xce93d8,0xf48fb1,0xffb74d];
    const mat     = new THREE.MeshPhysicalMaterial({ color: palette[item.id % palette.length] || 0xe68a39, roughness:0.45, clearcoat:0.4 });
    const box     = new THREE.Mesh(new THREE.BoxGeometry(0.22,0.22,0.22), mat);
    box.castShadow = true; group.add(box);
    group.position.y = -0.88;
    return group;
}

// ═══════════════════════════════════════════════════════════════════════════
// CAGE BUILDER
// ═══════════════════════════════════════════════════════════════════════════
function rebuildCage() {
    // Clear habitat
    while (habitatGroup.children.length) {
        const c = habitatGroup.children[0];
        habitatGroup.remove(c);
        c.traverse(ch => {
            if (ch.geometry) ch.geometry.dispose();
            if (ch.material) { if (Array.isArray(ch.material)) ch.material.forEach(m=>m.dispose()); else ch.material.dispose(); }
        });
    }
    placedMeshes     = {};
    waterSurfaceMesh = null;
    bubbleParticles  = null;
    deselectObject();

    // Rebuild enclosure
    const sizeScale = { sm:0.65, md:1.0, lg:1.45 }[currentSizeId] || 1.0;
    if      (currentCageType === 'fish')    buildFishTank(sizeScale);
    else if (currentCageType === 'bird')    buildBirdCage(sizeScale);
    else if (currentCageType === 'hamster') buildHamsterCage(sizeScale);

    // Re-place any existing slot selections
    Object.entries(slotSelections).forEach(([slotId, item]) => placeMeshForSlot(slotId, item));
}

function buildFishTank(scale = 1) {
    const W=4*scale, H=2.5*scale, D=2.5*scale, GT=0.08, FT=0.1;
    const glassMat = new THREE.MeshPhysicalMaterial({ color:0xd4f1f9, transparent:true, opacity:0.18, roughness:0.02, transmission:0.92, thickness:0.15, ior:1.5, clearcoat:1.0, clearcoatRoughness:0.02, reflectivity:0.5, side:THREE.DoubleSide });
    const frameMat = new THREE.MeshStandardMaterial({ color:0x1a1410, roughness:0.35, metalness:0.75 });

    [{ g:[W,GT,D], p:[0,-H/2,0] },{ g:[W,H,GT], p:[0,0,D/2] },{ g:[W,H,GT], p:[0,0,-D/2] },{ g:[GT,H,D], p:[-W/2,0,0] },{ g:[GT,H,D], p:[W/2,0,0] }]
    .forEach(({g,p}) => { const m=new THREE.Mesh(new THREE.BoxGeometry(...g), glassMat); m.position.set(...p); m.receiveShadow=true; habitatGroup.add(m); });

    [[-1,1],[1,1],[-1,-1],[1,-1]].forEach(([sx,sz]) => {
        const fv=new THREE.Mesh(new THREE.BoxGeometry(FT,H+FT*2,FT), frameMat); fv.position.set(sx*W/2,0,sz*D/2); fv.castShadow=true; habitatGroup.add(fv);
    });

    const waterMat = new THREE.MeshPhysicalMaterial({ color:0x3fa9c4, transparent:true, opacity:0.22, roughness:0.05, transmission:0.85, thickness:2.0*scale, ior:1.33, attenuationColor:new THREE.Color(0x1a5a7a), attenuationDistance:2.5, side:THREE.DoubleSide });
    const wv = new THREE.Mesh(new THREE.BoxGeometry(W-0.16, H-0.3, D-0.16), waterMat);
    wv.position.y = -H*0.07; habitatGroup.add(wv);

    const wsMat = new THREE.ShaderMaterial({
        uniforms:{ uTime:{value:0}, uColor:{value:new THREE.Color(0x7fd4e8)}, uOpacity:{value:0.55} },
        vertexShader:`uniform float uTime;varying vec2 vUv;varying float vWave;void main(){vUv=uv;vec3 pos=position;float w1=sin(pos.x*4.0+uTime*1.5)*0.015;float w2=cos(pos.z*3.0+uTime*1.2)*0.012;float w3=sin((pos.x+pos.z)*6.0+uTime*2.0)*0.008;pos.y+=w1+w2+w3;vWave=w1+w2+w3;gl_Position=projectionMatrix*modelViewMatrix*vec4(pos,1.0);}`,
        fragmentShader:`uniform vec3 uColor;uniform float uOpacity;uniform float uTime;varying vec2 vUv;varying float vWave;void main(){float caustic=sin(vUv.x*20.0+uTime)*sin(vUv.y*15.0+uTime*0.7);caustic=smoothstep(0.6,1.0,caustic)*0.3;vec3 c=uColor+caustic+vWave*3.0;gl_FragColor=vec4(c,uOpacity+caustic*0.2);}`,
        transparent:true, side:THREE.DoubleSide,
    });
    waterSurfaceMesh = new THREE.Mesh(new THREE.PlaneGeometry(W-0.16, D-0.16, 48, 48), wsMat);
    waterSurfaceMesh.rotation.x = -Math.PI/2; waterSurfaceMesh.position.y = H/2 - 0.08;
    habitatGroup.add(waterSurfaceMesh);
    createBubbleSystem(scale);
    habitatGroup.position.y = 0.5 * scale;
}

function createBubbleSystem(scale=1) {
    const N=40, geo=new THREE.BufferGeometry();
    const pos=new Float32Array(N*3), vel=new Float32Array(N), sz=new Float32Array(N), wob=new Float32Array(N);
    for (let i=0;i<N;i++) {
        pos[i*3]=(Math.random()-.5)*3.5*scale; pos[i*3+1]=-1*scale+Math.random()*2*scale; pos[i*3+2]=(Math.random()-.5)*2*scale;
        vel[i]=.005+Math.random()*.015; sz[i]=.03+Math.random()*.06; wob[i]=Math.random()*Math.PI*2;
    }
    geo.setAttribute('position',new THREE.BufferAttribute(pos,3));
    geo.setAttribute('aSize',new THREE.BufferAttribute(sz,1));
    const mat = new THREE.ShaderMaterial({
        uniforms:{uTime:{value:0}},
        vertexShader:`attribute float aSize;void main(){vec4 mv=modelViewMatrix*vec4(position,1.0);gl_PointSize=aSize*400.0/-mv.z;gl_Position=projectionMatrix*mv;}`,
        fragmentShader:`void main(){vec2 uv=gl_PointCoord-.5;if(length(uv)>.5)discard;float e=smoothstep(.5,.35,length(uv));float h=smoothstep(.3,.0,length(uv-vec2(-.15,.15)));gl_FragColor=vec4(.8,.95,1.0,e*.6+h*.8);}`,
        transparent:true, depthWrite:false, blending:THREE.AdditiveBlending,
    });
    bubbleParticles = new THREE.Points(geo, mat);
    bubbleParticles.userData.velocities = vel;
    bubbleParticles.userData.wobbles    = wob;
    bubbleParticles.userData.scale      = scale;
    habitatGroup.add(bubbleParticles);
}

function updateBubbles() {
    if (!bubbleParticles) return;
    const pos=bubbleParticles.geometry.attributes.position.array;
    const vel=bubbleParticles.userData.velocities;
    const wob=bubbleParticles.userData.wobbles;
    const sc =bubbleParticles.userData.scale || 1;
    for (let i=0;i<vel.length;i++) {
        pos[i*3+1]+=vel[i];
        pos[i*3  ]+=Math.sin(animationTime*2+wob[i])*.003;
        pos[i*3+2]+=Math.cos(animationTime*1.5+wob[i])*.002;
        if(pos[i*3+1]>0.9*sc){pos[i*3]=(Math.random()-.5)*3.5*sc;pos[i*3+1]=-sc;pos[i*3+2]=(Math.random()-.5)*2*sc;}
    }
    bubbleParticles.geometry.attributes.position.needsUpdate=true;
    bubbleParticles.material.uniforms.uTime.value=animationTime;
}

function buildBirdCage(scale=1) {
    const gold    = new THREE.MeshStandardMaterial({ color:0xd4af37, roughness:0.3, metalness:0.9 });
    const darkMet = new THREE.MeshStandardMaterial({ color:0x8b6914, roughness:0.4, metalness:0.85 });
    const wood    = new THREE.MeshStandardMaterial({ color:0x3d2817, roughness:0.7 });
    const R=1.3*scale, H=2.2*scale;
    const tray = new THREE.Mesh(new THREE.CylinderGeometry(1.4*scale,1.45*scale,.15*scale,32), wood);
    tray.position.y=-1.3*scale; tray.castShadow=tray.receiveShadow=true; habitatGroup.add(tray);
    const baseRing = new THREE.Mesh(new THREE.TorusGeometry(1.42*scale,.06,8,32), gold);
    baseRing.position.y=-1.22*scale; baseRing.rotation.x=Math.PI/2; habitatGroup.add(baseRing);
    const barCount = Math.round(20*scale);
    for (let i=0;i<barCount;i++) {
        const a=(i/barCount)*Math.PI*2;
        const bar=new THREE.Mesh(new THREE.CylinderGeometry(.02,.02,H,6), gold);
        bar.position.set(Math.cos(a)*R,-1.3*scale+H/2,Math.sin(a)*R); bar.castShadow=true; habitatGroup.add(bar);
    }
    [0,.55,1].forEach(yo => {
        const ring=new THREE.Mesh(new THREE.TorusGeometry(R,.03,8,32), darkMet);
        ring.position.y=-1.3*scale+yo*scale+.3*scale; ring.rotation.x=Math.PI/2; habitatGroup.add(ring);
    });
    const apex=new THREE.Vector3(0,1.5*scale,0);
    for (let i=0;i<barCount;i++) {
        const a=(i/barCount)*Math.PI*2;
        const curve=new THREE.QuadraticBezierCurve3(
            new THREE.Vector3(Math.cos(a)*R,.9*scale,Math.sin(a)*R),
            new THREE.Vector3(Math.cos(a)*R*.5,1.3*scale,Math.sin(a)*R*.5), apex);
        habitatGroup.add(new THREE.Mesh(new THREE.TubeGeometry(curve,12,.02,6,false), gold));
    }
    const top=new THREE.Mesh(new THREE.SphereGeometry(.1*scale,16,12), gold);
    top.position.y=1.6*scale; habitatGroup.add(top);
    habitatGroup.position.y=0.3*scale;
}

function buildHamsterCage(scale=1) {
    const plastic = new THREE.MeshPhysicalMaterial({ color:0x8ecae6, transparent:true, opacity:.35, roughness:.1, transmission:.7, thickness:.1, clearcoat:.8, side:THREE.DoubleSide });
    const baseMat = new THREE.MeshStandardMaterial({ color:0xf4a261, roughness:.6 });
    const wire    = new THREE.MeshStandardMaterial({ color:0x888888, roughness:.4, metalness:.8 });
    const W=3.2*scale, H=1.8*scale, D=2.2*scale;
    const tray=new THREE.Mesh(new THREE.BoxGeometry(W,.3*scale,D), baseMat);
    tray.position.y=-.95*scale; tray.castShadow=tray.receiveShadow=true; habitatGroup.add(tray);
    const shell=new THREE.Mesh(new THREE.BoxGeometry(W,H-.3*scale,D), plastic);
    shell.position.y=.05*scale; habitatGroup.add(shell);
    for (let i=0;i<4;i++) {
        const vbar=new THREE.Mesh(new THREE.CylinderGeometry(.01,.01,H-.4*scale,4), wire);
        vbar.position.set(W/2-.01,0,i*.25*scale-.375*scale); habitatGroup.add(vbar);
    }
    habitatGroup.position.y=0;
}

// ═══════════════════════════════════════════════════════════════════════════
// THREE.JS INIT
// ═══════════════════════════════════════════════════════════════════════════
function init3D() {
    if (is3DInitialized) { onResize(); return; }
    if (typeof THREE === 'undefined') return;

    scene = new THREE.Scene();
    const bgCanvas=document.createElement('canvas'); bgCanvas.width=2; bgCanvas.height=512;
    const bgCtx=bgCanvas.getContext('2d'); const bgGrad=bgCtx.createLinearGradient(0,0,0,512);
    bgGrad.addColorStop(0,'#1a4a5c'); bgGrad.addColorStop(0.5,'#0f2d3a'); bgGrad.addColorStop(1,'#081820');
    bgCtx.fillStyle=bgGrad; bgCtx.fillRect(0,0,2,512);
    scene.background=new THREE.CanvasTexture(bgCanvas);
    scene.fog=new THREE.FogExp2(0x0a2030,0.05);

    camera=new THREE.PerspectiveCamera(45,container.clientWidth/container.clientHeight,0.1,1000);
    camera.position.set(5,3,6);

    renderer=new THREE.WebGLRenderer({ antialias:true, powerPreference:'high-performance' });
    renderer.setSize(container.clientWidth,container.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio,2));
    renderer.shadowMap.enabled=true; renderer.shadowMap.type=THREE.PCFSoftShadowMap;
    renderer.physicallyCorrectLights=true;
    renderer.toneMapping=THREE.ACESFilmicToneMapping; renderer.toneMappingExposure=1.1;
    renderer.outputEncoding=THREE.sRGBEncoding;
    container.appendChild(renderer.domElement);

    scene.add(new THREE.AmbientLight(0x4a6b7c,0.4));
    const sun=new THREE.DirectionalLight(0xfff4e0,1.4);
    sun.position.set(2,8,3); sun.castShadow=true;
    sun.shadow.mapSize.set(2048,2048);
    sun.shadow.camera.left=-5; sun.shadow.camera.right=5;
    sun.shadow.camera.top=5; sun.shadow.camera.bottom=-5;
    sun.shadow.bias=-0.0005; sun.shadow.radius=4; scene.add(sun);

    const fillLight=new THREE.DirectionalLight(0x6ab7d9,0.5);
    fillLight.position.set(-5,2,-3); scene.add(fillLight);

    const cA=new THREE.PointLight(0x7fd4e8,0.6,6); cA.position.set(-1,1.2,0); scene.add(cA);
    const cB=new THREE.PointLight(0x5fb8d1,0.5,5); cB.position.set(1,1.0,0.5); scene.add(cB);
    causticLight={a:cA,b:cB};
    scene.add(new THREE.HemisphereLight(0x87ceeb,0x2d4a5c,0.3));

    const floor=new THREE.Mesh(new THREE.PlaneGeometry(25,25), new THREE.MeshStandardMaterial({ color:0x1a1410, roughness:0.85 }));
    floor.rotation.x=-Math.PI/2; floor.position.y=-2.2; floor.receiveShadow=true; scene.add(floor);

    orbitControls=new THREE.OrbitControls(camera,renderer.domElement);
    orbitControls.enableDamping=true; orbitControls.dampingFactor=0.08;
    orbitControls.target.set(0,0,0); orbitControls.maxPolarAngle=Math.PI/1.9;
    orbitControls.minDistance=3; orbitControls.maxDistance=14;
    orbitControls.rotateSpeed=0.5; orbitControls.zoomSpeed=0.8; orbitControls.update();

    raycaster=new THREE.Raycaster(); mouse=new THREE.Vector2();
    habitatGroup=new THREE.Group(); scene.add(habitatGroup);
    rebuildCage();

    renderer.domElement.addEventListener('pointerdown',  onPointerDown);
    renderer.domElement.addEventListener('pointermove',  onPointerMove);
    renderer.domElement.addEventListener('pointerup',    onPointerUp);
    renderer.domElement.addEventListener('pointerleave', onPointerUp);
    window.addEventListener('resize', onResize);

    animate3D(); is3DInitialized=true;
    setTimeout(()=>{ document.getElementById('dragHint')?.classList.add('hidden'); },6000);
}

// ═══════════════════════════════════════════════════════════════════════════
// POINTER / DRAG
// ═══════════════════════════════════════════════════════════════════════════
function getNDC(e) {
    const r=renderer.domElement.getBoundingClientRect();
    return new THREE.Vector2(((e.clientX-r.left)/r.width)*2-1,-((e.clientY-r.top)/r.height)*2+1);
}
function findDraggable(obj) { let c=obj; while(c){if(c.userData?.draggable)return c;c=c.parent;} return null; }

function onPointerDown(e) {
    mouse=getNDC(e); raycaster.setFromCamera(mouse,camera);
    const meshes=[]; Object.values(placedMeshes).forEach(g=>g.traverse(c=>{if(c.isMesh)meshes.push(c);}));
    const hits=raycaster.intersectObjects(meshes,false);
    if (hits.length) {
        const g=findDraggable(hits[0].object);
        if (g) {
            selectObject(g); isDragging=true; orbitControls.enabled=false; container.classList.add('dragging');
            const plane=new THREE.Plane(new THREE.Vector3(0,1,0),-g.position.y);
            const inter=new THREE.Vector3(); raycaster.ray.intersectPlane(plane,inter);
            dragOffset.copy(g.position).sub(inter);
        }
    } else { deselectObject(); }
}

function onPointerMove(e) {
    if (!isDragging||!selectedObject) return;
    mouse=getNDC(e); raycaster.setFromCamera(mouse,camera);
    const plane=new THREE.Plane(new THREE.Vector3(0,1,0),-selectedObject.position.y);
    const inter=new THREE.Vector3();
    if (raycaster.ray.intersectPlane(plane,inter)) {
        const sizeConf = CAGE_TYPES[currentCageType].sizes.find(s=>s.id===currentSizeId);
        const b = sizeConf ? sizeConf.bounds : { minX:-2,maxX:2,minY:-2,maxY:2,minZ:-2,maxZ:2 };
        const np=inter.add(dragOffset);
        np.x=Math.max(b.minX,Math.min(b.maxX,np.x));
        np.y=Math.max(b.minY,Math.min(b.maxY,np.y));
        np.z=Math.max(b.minZ,Math.min(b.maxZ,np.z));
        selectedObject.position.copy(np);
    }
}

function onPointerUp() { if(isDragging){isDragging=false;orbitControls.enabled=true;container.classList.remove('dragging');} }

function selectObject(group) {
    if (selectedObject===group) return;
    deselectObject(); selectedObject=group;
    group.traverse(child => {
        if (child.isMesh&&child.geometry&&!child.userData.isOutline) {
            const out=new THREE.Mesh(child.geometry.clone(), new THREE.MeshBasicMaterial({ color:0xffaa44, side:THREE.BackSide, transparent:true, opacity:0.5 }));
            out.scale.multiplyScalar(1.08); out.position.copy(child.position); out.rotation.copy(child.rotation);
            out.userData.isOutline=true; group.add(out); highlightOutlines.push(out);
        }
    });
    document.getElementById('selItemName').textContent=group.userData.itemName||'Item';
    document.getElementById('selectionPanel')?.classList.add('show');
}

function deselectObject() {
    highlightOutlines.forEach(o=>{if(o.parent)o.parent.remove(o);if(o.geometry)o.geometry.dispose();if(o.material)o.material.dispose();});
    highlightOutlines=[]; selectedObject=null;
    document.getElementById('selectionPanel')?.classList.remove('show');
}

// ═══════════════════════════════════════════════════════════════════════════
// ANIMATION
// ═══════════════════════════════════════════════════════════════════════════
function animate3D() {
    requestAnimationFrame(animate3D);
    animationTime+=0.016;
    if (waterSurfaceMesh?.material?.uniforms) waterSurfaceMesh.material.uniforms.uTime.value=animationTime;
    updateBubbles();
    if (causticLight) {
        causticLight.a.position.x=Math.sin(animationTime*0.7)*1.5;
        causticLight.a.position.z=Math.cos(animationTime*0.5)*0.8;
        causticLight.b.position.x=Math.cos(animationTime*0.6)*1.2;
        causticLight.b.position.z=Math.sin(animationTime*0.8)*1.0;
    }
    Object.values(placedMeshes).forEach(g=>{
        if (g.userData.idlePhase===undefined) g.userData.idlePhase=Math.random()*Math.PI*2;
        g.position.y+=Math.sin(animationTime*0.8+g.userData.idlePhase)*0.0002;
    });
    if (orbitControls) orbitControls.update();
    if (renderer&&scene&&camera) renderer.render(scene,camera);
}

function onResize() {
    if (!camera||!renderer) return;
    camera.aspect=container.clientWidth/container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth,container.clientHeight);
}

// ═══════════════════════════════════════════════════════════════════════════
// CONTROLS & EVENTS
// ═══════════════════════════════════════════════════════════════════════════
document.getElementById('selRotateBtn')?.addEventListener('click', ()=>{ if(selectedObject) selectedObject.rotation.y+=Math.PI/4; });
document.getElementById('selDeleteBtn')?.addEventListener('click', ()=>{
    if (!selectedObject) return;
    const slotId = selectedObject.userData.slotId;
    clearSlot(slotId);
});

document.getElementById('tankResetView')?.addEventListener('click', ()=>{
    if (!camera||!orbitControls) return;
    camera.position.set(5,3,6); orbitControls.target.set(0,0,0); orbitControls.update();
});

// Cage type tabs
document.querySelectorAll('.cage-type-tab').forEach(tab => {
    tab.addEventListener('click', function () {
        if (this.dataset.cage === currentCageType) return;
        document.querySelectorAll('.cage-type-tab').forEach(t=>t.classList.remove('active'));
        this.classList.add('active');
        currentCageType  = this.dataset.cage;
        currentSizeId    = 'md';
        slotSelections   = {};
        rebuildCage();
        renderSidebar();
    });
});

// Picker search
document.getElementById('pickerSearch')?.addEventListener('input', function () {
    if (!activePickerSlot) return;
    const slot = CAGE_TYPES[currentCageType].slots.find(s=>s.id===activePickerSlot);
    if (slot) renderPickerGrid(slot, this.value);
});

document.getElementById('pickerClose')?.addEventListener('click', closePicker);
document.getElementById('pickerPanel')?.addEventListener('click', e => { if(e.target===e.currentTarget) closePicker(); });

// Add to cart
document.getElementById('addToCartBtn')?.addEventListener('click', function () {
    const cfg  = CAGE_TYPES[currentCageType];
    const size = cfg.sizes.find(s=>s.id===currentSizeId);
    const cartItems = [{
        id:        'habitat-base-'+currentCageType+'-'+currentSizeId,
        name:      `${cfg.label} (${size.label})`,
        emoji:     cfg.emoji,
        price:     size.price,
        qty:       1,
        item_type: 'supply',
        source_id: null,
        scheduled_at: null,
    }];

    Object.entries(slotSelections).forEach(([slotId, item]) => {
        cartItems.push({
            id:        item.key,
            name:      item.name,
            emoji:     item.emoji,
            price:     getItemPrice(item),
            qty:       1,
            item_type: item._type,
            source_id: item.id,
            scheduled_at: null,
        });
    });

    let cart = JSON.parse(sessionStorage.getItem('ph_cart')||'[]');
    cartItems.forEach(ci => {
        const ex=cart.find(c=>String(c.id)===String(ci.id));
        if (ex) ex.qty++; else cart.push(ci);
    });
    sessionStorage.setItem('ph_cart', JSON.stringify(cart));

    const total = cartItems.reduce((s,c)=>s+c.price,0);
    alert(`✅ Habitat added to cart!\n${cartItems.map(c=>c.name).join(', ')}\nTotal: ₱${total.toLocaleString()}`);
});

// ═══════════════════════════════════════════════════════════════════════════
// BOOT
// ═══════════════════════════════════════════════════════════════════════════
init3D();
fetchAll();
});
</script>
@endsection