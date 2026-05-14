@extends('layouts.app')

@section('title', 'PawHaven Shop — Pets & Supplies')

@section('content')

@php
$catalog = [
    // ── PETS ──
    ['id'=>1,  'name'=>'Golden Retriever Puppy', 'emoji'=>'🐕', 'category'=>'Dogs',       'type'=>'pet',     'price'=>18000, 'badge'=>'popular',    'badgeLabel'=>'Popular',    'desc'=>'Friendly, intelligent and devoted. The perfect family companion for any home.',    'available'=>true],
    ['id'=>2,  'name'=>'Siamese Kitten',          'emoji'=>'🐱', 'category'=>'Cats',       'type'=>'pet',     'price'=>12000, 'badge'=>'new',         'badgeLabel'=>'New',         'desc'=>'Elegant, vocal and affectionate with captivating deep-blue eyes.',                 'available'=>true],
    ['id'=>3,  'name'=>'Holland Lop Rabbit',      'emoji'=>'🐰', 'category'=>'Small Pets', 'type'=>'pet',     'price'=>3500,  'badge'=>'cute',        'badgeLabel'=>'Cute',        'desc'=>'Gentle and sociable with adorable floppy ears and a calm temperament.',           'available'=>true],
    ['id'=>4,  'name'=>'Bearded Dragon',           'emoji'=>'🦎', 'category'=>'Reptiles',  'type'=>'pet',     'price'=>6500,  'badge'=>'rare',        'badgeLabel'=>'Rare',        'desc'=>'Calm and curious reptile — great for first-time reptile owners.',                 'available'=>false],
    ['id'=>5,  'name'=>'African Grey Parrot',      'emoji'=>'🦜', 'category'=>'Birds',     'type'=>'pet',     'price'=>45000, 'badge'=>'premium',     'badgeLabel'=>'Premium',     'desc'=>'Highly intelligent and known for impressive mimicry and vocabulary.',             'available'=>true],
    ['id'=>6,  'name'=>'Betta Fish',               'emoji'=>'🐠', 'category'=>'Fish',      'type'=>'pet',     'price'=>350,   'badge'=>'bestseller',  'badgeLabel'=>'Bestseller',  'desc'=>'Vibrant colors and hardy — a stunning, low-maintenance aquarium fish.',           'available'=>true],
    ['id'=>7,  'name'=>'Persian Cat',              'emoji'=>'😸', 'category'=>'Cats',      'type'=>'pet',     'price'=>15000, 'badge'=>'premium',     'badgeLabel'=>'Premium',     'desc'=>'Gentle and calm with a stunning, plush long coat and sweet personality.',         'available'=>true],
    ['id'=>8,  'name'=>'Syrian Hamster',           'emoji'=>'🐹', 'category'=>'Small Pets','type'=>'pet',     'price'=>450,   'badge'=>'cute',        'badgeLabel'=>'Cute',        'desc'=>'Playful and easy to care for — a wonderful, gentle starter pet.',                'available'=>true],
    ['id'=>9,  'name'=>'Cockatiel',                'emoji'=>'🐦', 'category'=>'Birds',     'type'=>'pet',     'price'=>3500,  'badge'=>'new',         'badgeLabel'=>'New',         'desc'=>'Friendly and musical. One of the most popular pet birds worldwide.',             'available'=>true],
    ['id'=>10, 'name'=>'Shih Tzu Puppy',           'emoji'=>'🐶', 'category'=>'Dogs',      'type'=>'pet',     'price'=>22000, 'badge'=>'popular',     'badgeLabel'=>'Popular',     'desc'=>'Affectionate lap dog with a silky coat and playful spirit.',                     'available'=>true],
    // ── SUPPLIES ──
    ['id'=>11, 'name'=>'Premium Puppy Kibble',     'emoji'=>'🍖', 'category'=>'Food',       'type'=>'product', 'price'=>850,  'badge'=>'bestseller',  'badgeLabel'=>'Bestseller',  'desc'=>'High-protein kibble specially formulated for healthy growing puppies.',           'available'=>true],
    ['id'=>12, 'name'=>'Interactive Cat Wand',     'emoji'=>'🧶', 'category'=>'Toys',       'type'=>'product', 'price'=>350,  'badge'=>'fun',         'badgeLabel'=>'Fun',         'desc'=>'Feather wand toy to keep your feline entertained for hours on end.',             'available'=>true],
    ['id'=>13, 'name'=>'Self-Cleaning Litter Box', 'emoji'=>'📦', 'category'=>'Accessories','type'=>'product', 'price'=>4500, 'badge'=>'new',         'badgeLabel'=>'New',         'desc'=>'Automatic self-cleaning mechanism for completely hands-free maintenance.',        'available'=>true],
    ['id'=>14, 'name'=>'Grooming Brush Set',       'emoji'=>'🪮', 'category'=>'Grooming',   'type'=>'product', 'price'=>1200, 'badge'=>'popular',     'badgeLabel'=>'Popular',     'desc'=>'3-piece set for all coat types — slicker brush, comb, and deshedder.',          'available'=>true],
    ['id'=>15, 'name'=>'Natural Dog Shampoo',      'emoji'=>'🧴', 'category'=>'Grooming',   'type'=>'product', 'price'=>450,  'badge'=>'sale',        'badgeLabel'=>'Sale',        'desc'=>'Oatmeal formula, gentle for sensitive skin. pH balanced and vet-approved.',      'available'=>true],
    ['id'=>16, 'name'=>'Hamster Exercise Wheel',   'emoji'=>'🎡', 'category'=>'Toys',       'type'=>'product', 'price'=>650,  'badge'=>'fun',         'badgeLabel'=>'Fun',         'desc'=>'Silent spinner wheel, 8-inch diameter. Perfect for hamsters and small pets.',    'available'=>true],
    ['id'=>17, 'name'=>'Large Aquarium Filter',    'emoji'=>'🐠', 'category'=>'Accessories','type'=>'product', 'price'=>3200, 'badge'=>'popular',     'badgeLabel'=>'Popular',     'desc'=>'Powerful canister filter for tanks up to 200 liters with 3-stage filtration.',   'available'=>true],
    ['id'=>18, 'name'=>'Large Bird Cage',          'emoji'=>'🦜', 'category'=>'Accessories','type'=>'product', 'price'=>4500, 'badge'=>'premium',     'badgeLabel'=>'Premium',     'desc'=>'Spacious wrought-iron cage with multiple perches and feeding stations.',         'available'=>true],
    ['id'=>19, 'name'=>'Salmon Cat Food',          'emoji'=>'🐟', 'category'=>'Food',       'type'=>'product', 'price'=>320,  'badge'=>'bestseller',  'badgeLabel'=>'Bestseller',  'desc'=>'Premium wet food with real salmon — rich in omega-3 fatty acids.',              'available'=>true],
    ['id'=>20, 'name'=>'Pet Vitamin Drops',        'emoji'=>'💊', 'category'=>'Health',     'type'=>'product', 'price'=>480,  'badge'=>'essential',   'badgeLabel'=>'Essential',   'desc'=>'Daily multivitamin liquid drops for dogs and cats. Easy to administer.',         'available'=>true],
    ['id'=>21, 'name'=>'Orthopedic Dog Bed',       'emoji'=>'🛏️', 'category'=>'Accessories','type'=>'product', 'price'=>2200, 'badge'=>'popular',     'badgeLabel'=>'Popular',     'desc'=>'Memory foam bed that supports joints. Removable and machine-washable cover.',    'available'=>true],
    ['id'=>22, 'name'=>'Squeaky Ball Set',         'emoji'=>'⚽', 'category'=>'Toys',       'type'=>'product', 'price'=>280,  'badge'=>'fun',         'badgeLabel'=>'Fun',         'desc'=>'Set of 3 durable rubber squeaky balls in small, medium, and large sizes.',       'available'=>true],
    ['id'=>23, 'name'=>'Flea & Tick Treatment',   'emoji'=>'🩺', 'category'=>'Health',     'type'=>'product', 'price'=>750,  'badge'=>'essential',   'badgeLabel'=>'Essential',   'desc'=>'Monthly topical treatment for dogs and cats. Waterproof and fast-acting.',       'available'=>true],
    ['id'=>24, 'name'=>'Automatic Pet Feeder',    'emoji'=>'🤖', 'category'=>'Accessories','type'=>'product', 'price'=>3800, 'badge'=>'new',         'badgeLabel'=>'New',         'desc'=>'Programmable feeder with 4L hopper. Wi-Fi enabled app control.',                'available'=>true],
    ['id'=>25, 'name'=>'Full Pet Grooming',       'emoji'=>'✂️', 'category'=>'Salon',     'type'=>'service', 'price'=>1500, 'badge'=>'popular',   'badgeLabel'=>'Popular',     'desc'=>'Complete bath, haircut, nail trim, and ear cleaning.',                          'available'=>true],
    ['id'=>26, 'name'=>'Basic Vet Checkup',       'emoji'=>'🩺', 'category'=>'Clinic',    'type'=>'service', 'price'=>800,  'badge'=>'essential', 'badgeLabel'=>'Essential',   'desc'=>'General health assessment by our licensed veterinarians.',                      'available'=>true],
    ['id'=>27, 'name'=>'Overnight Boarding',      'emoji'=>'🏨', 'category'=>'Boarding',  'type'=>'service', 'price'=>1200, 'badge'=>'new',       'badgeLabel'=>'New',         'desc'=>'Safe, comfortable overnight stay with daily playtime included.',                'available'=>true],
    ['id'=>28, 'name'=>'Obedience Training',      'emoji'=>'🦮', 'category'=>'Training',  'type'=>'service', 'price'=>4500, 'badge'=>'premium',   'badgeLabel'=>'Premium',     'desc'=>'5-session behavioral training course for dogs of all ages.',                    'available'=>true],
];
@endphp

{{-- ═══════════════════════════════════════════════════════════
     STYLES
═══════════════════════════════════════════════════════════ --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --cream:        #FDF8F1;
    --cream-mid:    #FDF2E9;
    --orange:       #E68A39;
    --orange-dark:  #CF7529;
    --orange-glow:  rgba(230,138,57,0.25);
    --brown:        #2D241E;
    --brown-sub:    #5C4D3C;
    --brown-muted:  #A68B6D;
    --border:       #F3E9DC;
    --border-mid:   #EBD7BC;
    --white:        #ffffff;
    --green:        #34A853;
    --red:          #EF4444;
    --shadow-sm:    0 2px 12px rgba(45,36,30,0.06);
    --shadow-md:    0 6px 24px rgba(45,36,30,0.10);
    --shadow-lg:    0 12px 40px rgba(45,36,30,0.14);
    --radius-sm:    0.75rem;
    --radius-md:    1.25rem;
    --radius-lg:    1.75rem;
    --radius-xl:    2.5rem;
    --serif:        'DM Serif Display', serif;
}

html { scroll-behavior: smooth; }
body { background: var(--cream); color: var(--brown); font-family: 'Segoe UI', system-ui, sans-serif; overflow-x: hidden; }

/* ── NAVBAR ── */
.shop-navbar {
    position: sticky; top: 0; z-index: 100;
    background: rgba(253,248,241,0.92); backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
}
.nav-inner-shop {
    max-width: 1400px; margin: 0 auto; padding: 0 1.5rem;
    display: flex; align-items: center; justify-content: space-between;
    height: 70px; gap: 1.5rem;
}
.nav-brand-shop {
    display: flex; align-items: center; gap: 0.5rem;
    text-decoration: none; flex-shrink: 0;
}
.nav-brand-shop .brand-icon { font-size: 1.5rem; }
.nav-brand-shop .brand-text { font-family: var(--serif); font-size: 1.6rem; color: var(--brown); }

.nav-links-shop { display: flex; list-style: none; gap: 2rem; align-items: center; }
.nav-links-shop a {
    text-decoration: none; color: var(--brown-sub); font-size: 0.88rem; font-weight: 600;
    transition: color 0.2s; position: relative;
}
.nav-links-shop a::after {
    content: ''; position: absolute; bottom: -3px; left: 0; right: 0;
    height: 2px; background: var(--orange); border-radius: 2px;
    transform: scaleX(0); transition: transform 0.2s;
}
.nav-links-shop a:hover { color: var(--orange); }
.nav-links-shop a:hover::after { transform: scaleX(1); }
.nav-links-shop a.active-link { color: var(--orange); }
.nav-links-shop a.active-link::after { transform: scaleX(1); }

.nav-right-shop { display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0; }
.nav-welcome-shop { font-size: 0.82rem; font-weight: 600; color: var(--brown-sub); }

.cart-trigger {
    position: relative;
    display: flex; align-items: center; gap: 0.5rem;
    background: var(--orange); color: white;
    border: none; border-radius: 50px; padding: 0.55rem 1.25rem;
    font-size: 0.85rem; font-weight: 800; cursor: pointer;
    box-shadow: 0 4px 14px var(--orange-glow);
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}
.cart-trigger:hover { background: var(--orange-dark); transform: translateY(-1px); box-shadow: 0 6px 20px var(--orange-glow); }

.cart-pill {
    background: white; color: var(--orange);
    border-radius: 50px; padding: 0 0.45rem; height: 20px; min-width: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; font-weight: 900; line-height: 1;
    transition: transform 0.2s;
}
.cart-pill.bump { animation: pill-bump 0.25s ease; }
@keyframes pill-bump { 0%,100%{transform:scale(1)} 50%{transform:scale(1.5)} }

.nav-hamburger-shop {
    display: none; background: none; border: none; cursor: pointer;
    padding: 0.4rem; flex-direction: column; gap: 4px;
}
.nav-hamburger-shop span {
    display: block; width: 22px; height: 2px;
    background: var(--brown); border-radius: 2px; transition: all 0.3s;
}
.mobile-menu-shop {
    display: none; background: var(--white);
    border-top: 1px solid var(--border); padding: 1rem 1.5rem;
}
.mobile-menu-shop a {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.75rem 0; text-decoration: none;
    color: var(--brown-sub); font-size: 0.9rem; font-weight: 600;
    border-bottom: 1px solid var(--border);
}
.mobile-menu-shop a:last-child { border-bottom: none; }
.mobile-menu-shop a:hover { color: var(--orange); }

/* ── SHOP HERO BANNER ── */
.shop-hero {
    background: linear-gradient(135deg, #2D241E 0%, #4A3020 50%, #2D241E 100%);
    padding: 3.5rem 1.5rem; text-align: center; position: relative; overflow: hidden;
}
.shop-hero-bg {
    position: absolute; inset: 0; pointer-events: none;
    display: flex; align-items: center; justify-content: center;
    font-size: 8rem; opacity: 0.04; letter-spacing: 2rem;
    user-select: none; overflow: hidden;
}
.shop-hero-inner { position: relative; z-index: 1; max-width: 640px; margin: 0 auto; }
.shop-hero-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: rgba(230,138,57,0.2); border: 1px solid rgba(230,138,57,0.4);
    color: var(--orange); border-radius: 50px; padding: 0.3rem 1rem;
    font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;
    margin-bottom: 1rem;
}
.shop-hero h1 {
    font-family: var(--serif); font-size: clamp(2rem, 5vw, 3rem);
    color: white; margin-bottom: 0.75rem; line-height: 1.15;
}
.shop-hero h1 em { color: var(--orange); font-style: normal; }
.shop-hero p { color: rgba(255,255,255,0.65); font-size: 0.95rem; line-height: 1.7; }

/* ── STICKY CONTROLS BAR ── */
.controls-bar {
    position: sticky; top: 70px; z-index: 90;
    background: var(--white); border-bottom: 1px solid var(--border);
    padding: 0.9rem 1.5rem;
}
.controls-inner {
    max-width: 1400px; margin: 0 auto;
    display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
}
.search-field {
    position: relative; flex: 1; min-width: 180px; max-width: 380px;
}
.search-field input {
    width: 100%; padding: 0.6rem 0.9rem 0.6rem 2.4rem;
    border: 2px solid var(--border); border-radius: 50px;
    background: var(--cream); color: var(--brown);
    font-size: 0.875rem; font-weight: 500; outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.search-field input:focus { border-color: var(--orange); box-shadow: 0 0 0 3px var(--orange-glow); }
.search-field input::placeholder { color: var(--brown-muted); }
.search-icon-inp { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); font-size: 0.9rem; pointer-events: none; }
.sort-pick {
    padding: 0.6rem 1rem; border: 2px solid var(--border); border-radius: 50px;
    background: var(--cream); color: var(--brown-sub);
    font-size: 0.82rem; font-weight: 700; outline: none; cursor: pointer;
    transition: border-color 0.2s;
}
.sort-pick:focus { border-color: var(--orange); }
.result-count { margin-left: auto; font-size: 0.78rem; font-weight: 700; color: var(--brown-muted); white-space: nowrap; }

/* ── CATEGORY PILLS BAR ── */
.pills-bar {
    position: sticky; top: calc(70px + 57px); z-index: 80;
    background: var(--white); border-bottom: 1px solid var(--border);
    padding: 0.65rem 1.5rem; overflow-x: auto; scrollbar-width: none;
}
.pills-bar::-webkit-scrollbar { display: none; }
.pills-inner { display: flex; gap: 0.45rem; min-width: max-content; max-width: 1400px; margin: 0 auto; }
.cat-pill {
    display: flex; align-items: center; gap: 0.3rem;
    padding: 0.38rem 0.9rem; border-radius: 50px;
    border: 2px solid var(--border); background: var(--cream);
    color: var(--brown-sub); font-size: 0.78rem; font-weight: 700;
    cursor: pointer; white-space: nowrap; transition: all 0.18s;
    user-select: none;
}
.cat-pill:hover { border-color: var(--orange); color: var(--orange); background: var(--cream-mid); }
.cat-pill.active { background: var(--orange); border-color: var(--orange); color: white; box-shadow: 0 3px 10px var(--orange-glow); }

/* ── SHOP LAYOUT ── */
.shop-layout {
    max-width: 1400px; margin: 0 auto; padding: 2rem 1.5rem;
    display: grid; grid-template-columns: 220px 1fr; gap: 2rem;
}

/* ── SIDEBAR ── */
.shop-sidebar { position: sticky; top: calc(70px + 57px + 48px + 2rem); height: fit-content; }
.sidebar-box {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--radius-lg); padding: 1.25rem; margin-bottom: 0.9rem;
    box-shadow: var(--shadow-sm);
}
.sidebar-label {
    font-size: 0.68rem; font-weight: 900; text-transform: uppercase;
    letter-spacing: 0.14em; color: var(--brown-muted); margin-bottom: 0.85rem;
}
.type-opt {
    display: flex; align-items: center; gap: 0.65rem;
    padding: 0.5rem 0.65rem; border-radius: var(--radius-sm);
    cursor: pointer; transition: background 0.15s;
    font-size: 0.85rem; font-weight: 600; color: var(--brown-sub);
    border: none; background: transparent; width: 100%; text-align: left;
    margin-bottom: 0.2rem;
}
.type-opt:hover { background: var(--cream); }
.type-opt.active { background: var(--cream-mid); color: var(--orange); }
.type-opt .opt-icon { font-size: 1rem; }
.type-opt .opt-count {
    margin-left: auto; font-size: 0.7rem; color: var(--brown-muted);
    background: var(--cream); padding: 0.1rem 0.45rem; border-radius: 50px;
    font-weight: 700;
}
.price-display { display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 700; color: var(--brown-sub); margin-bottom: 0.6rem; }
input[type=range] { width: 100%; accent-color: var(--orange); cursor: pointer; }
.clear-all-btn {
    width: 100%; padding: 0.6rem; border-radius: 50px;
    border: 2px solid var(--border-mid); background: transparent;
    color: var(--brown-sub); font-size: 0.8rem; font-weight: 700;
    cursor: pointer; transition: all 0.2s;
}
.clear-all-btn:hover { border-color: var(--orange); color: var(--orange); background: var(--cream-mid); }

/* ── PRODUCTS GRID ── */
.shop-main { min-width: 0; }
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 1.1rem;
}

/* ── PRODUCT CARD ── */
.p-card {
    background: var(--white); border: 2px solid var(--border);
    border-radius: var(--radius-lg); overflow: hidden;
    display: flex; flex-direction: column;
    transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s;
}
.p-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--border-mid); }
.p-card.unavail { opacity: 0.6; }

.p-card-img {
    aspect-ratio: 1; background: var(--cream);
    display: flex; align-items: center; justify-content: center;
    font-size: 3.8rem; position: relative;
    border-bottom: 1px solid var(--border);
}
.type-chip {
    position: absolute; top: 0.7rem; left: 0.7rem;
    font-size: 0.6rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em;
    padding: 0.18rem 0.55rem; border-radius: 50px;
    background: rgba(45,36,30,0.07); color: var(--brown-sub);
}
.p-badge {
    position: absolute; top: 0.7rem; right: 0.7rem;
    font-size: 0.62rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.06em;
    padding: 0.2rem 0.55rem; border-radius: 50px;
}
.b-popular    { background:#FDF2E9; color:#E68A39; }
.b-new        { background:#E9F7F2; color:#34A853; }
.b-cute       { background:#FCE7F3; color:#9D174D; }
.b-rare       { background:#EDE9FE; color:#7C3AED; }
.b-premium    { background:#FEF9C3; color:#B45309; }
.b-bestseller { background:#FEE2E2; color:#DC2626; }
.b-fun        { background:#E9F0FE; color:#2563EB; }
.b-sale       { background:#FEE2E2; color:#DC2626; }
.b-essential  { background:#CFFAFE; color:#0E7490; }

.unavail-chip {
    position: absolute; bottom: 0.7rem; left: 0.7rem;
    font-size: 0.62rem; font-weight: 900; text-transform: uppercase;
    padding: 0.18rem 0.6rem; border-radius: 50px;
    background: rgba(45,36,30,0.7); color: white;
}

.p-card-body { padding: 0.9rem; flex: 1; display: flex; flex-direction: column; gap: 0.25rem; }
.p-category { font-size: 0.67rem; font-weight: 900; color: var(--orange); text-transform: uppercase; letter-spacing: 0.1em; }
.p-name { font-size: 0.92rem; font-weight: 800; color: var(--brown); line-height: 1.3; }
.p-desc { font-size: 0.75rem; color: var(--brown-muted); line-height: 1.55; flex: 1; margin-top: 0.15rem; }
.p-footer { display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; margin-top: 0.6rem; }
.p-price { font-family: var(--serif); font-size: 1.05rem; color: var(--brown); }

.add-to-cart {
    display: flex; align-items: center; gap: 0.3rem;
    background: var(--orange); color: white; border: none;
    padding: 0.42rem 0.85rem; border-radius: 50px;
    font-size: 0.75rem; font-weight: 800; cursor: pointer; white-space: nowrap;
    transition: all 0.18s;
}
.add-to-cart:hover { background: var(--orange-dark); transform: scale(1.04); }
.add-to-cart:disabled { background: #C9BCB2; cursor: not-allowed; transform: none; }
.add-to-cart.in-cart { background: var(--brown); }
.add-to-cart.in-cart:hover { background: #1a1410; }

/* ── EMPTY STATE ── */
.empty-shop { text-align: center; padding: 4rem 2rem; }
.empty-shop .big-emoji { font-size: 4rem; display: block; margin-bottom: 1rem; opacity: 0.4; }
.empty-shop h3 { font-size: 1.1rem; font-weight: 800; color: var(--brown); margin-bottom: 0.4rem; }
.empty-shop p { font-size: 0.85rem; color: var(--brown-muted); }

/* ── CART OVERLAY ── */
.c-overlay {
    position: fixed; inset: 0; z-index: 200;
    background: rgba(45,36,30,0.45); backdrop-filter: blur(4px);
    opacity: 0; pointer-events: none; transition: opacity 0.3s;
}
.c-overlay.open { opacity: 1; pointer-events: all; }

/* ── CART DRAWER ── */
.c-drawer {
    position: fixed; top: 0; right: 0; bottom: 0; z-index: 201;
    width: 100%; max-width: 400px;
    background: var(--white);
    display: flex; flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
    box-shadow: -8px 0 40px rgba(45,36,30,0.12);
}
.c-drawer.open { transform: translateX(0); }

.c-head {
    padding: 1.35rem 1.5rem; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.c-head h2 { font-family: var(--serif); font-size: 1.4rem; color: var(--brown); display: flex; align-items: center; gap: 0.5rem; }
.c-close {
    width: 36px; height: 36px; border-radius: 50%; border: none;
    background: var(--cream); color: var(--brown); font-size: 1rem;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background 0.15s;
}
.c-close:hover { background: var(--border); }

.c-list { flex: 1; overflow-y: auto; padding: 1rem; scrollbar-width: thin; scrollbar-color: var(--border) transparent; }
.c-list::-webkit-scrollbar { width: 4px; }
.c-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

.c-empty { text-align: center; padding: 3rem 1rem; }
.c-empty .ce { font-size: 3.5rem; display: block; margin-bottom: 1rem; opacity: 0.45; }
.c-empty p { font-size: 0.85rem; color: var(--brown-muted); font-weight: 600; line-height: 1.6; }

.c-item {
    display: flex; align-items: center; gap: 0.85rem;
    padding: 0.9rem; border-radius: var(--radius-md);
    border: 1px solid var(--border); background: var(--cream);
    margin-bottom: 0.6rem; transition: background 0.15s;
}
.c-item:hover { background: var(--cream-mid); }
.c-emoji {
    width: 46px; height: 46px; flex-shrink: 0;
    background: var(--white); border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center; font-size: 1.7rem;
    border: 1px solid var(--border);
}
.c-info { flex: 1; min-width: 0; }
.c-iname { font-size: 0.82rem; font-weight: 800; color: var(--brown); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.c-icat  { font-size: 0.67rem; font-weight: 800; color: var(--orange); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 0.1rem; }
.c-iprice { font-size: 0.82rem; font-weight: 800; color: var(--brown); margin-top: 0.2rem; }

.qty-wrap { display: flex; align-items: center; gap: 0.35rem; }
.q-btn {
    width: 26px; height: 26px; border-radius: 0.5rem;
    border: 1.5px solid var(--border-mid); background: var(--white);
    font-size: 1rem; font-weight: 800; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--brown); transition: all 0.15s; line-height: 1;
}
.q-btn:hover { background: var(--orange); color: white; border-color: var(--orange); }
.q-num { font-size: 0.85rem; font-weight: 900; width: 22px; text-align: center; }
.c-del { background: none; border: none; cursor: pointer; color: var(--brown-muted); font-size: 0.95rem; padding: 0.3rem; border-radius: 0.5rem; transition: all 0.15s; flex-shrink: 0; }
.c-del:hover { color: var(--red); background: #FEE2E2; }

.c-foot { padding: 1.15rem; border-top: 1px solid var(--border); }
.c-summary {
    background: var(--cream); border-radius: var(--radius-md);
    padding: 0.9rem; margin-bottom: 0.9rem;
}
.c-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.82rem; font-weight: 600; margin-bottom: 0.45rem; }
.c-row:last-child { margin-bottom: 0; }
.c-row .lbl { color: var(--brown-muted); }
.c-row.total {
    font-size: 1rem; font-weight: 900; color: var(--brown);
    border-top: 1px solid var(--border-mid); padding-top: 0.5rem; margin-top: 0.25rem;
}
.c-row .delivery-note { font-size: 0.72rem; color: var(--green); font-weight: 700; }

.checkout-btn {
    width: 100%; padding: 0.9rem; background: var(--orange); color: white;
    border: none; border-radius: 50px;
    font-size: 0.92rem; font-weight: 800; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    box-shadow: 0 6px 20px var(--orange-glow);
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}
.checkout-btn:hover { background: var(--orange-dark); transform: translateY(-1px); box-shadow: 0 8px 26px var(--orange-glow); }
.checkout-btn:disabled { background: #C9BCB2; cursor: not-allowed; transform: none; box-shadow: none; }

/* ── TOAST ── */
.shop-toast {
    position: fixed; bottom: 1.75rem; left: 50%;
    transform: translateX(-50%) translateY(90px);
    background: var(--brown); color: white;
    padding: 0.7rem 1.4rem; border-radius: 50px;
    font-size: 0.85rem; font-weight: 700; z-index: 400;
    display: flex; align-items: center; gap: 0.5rem;
    box-shadow: var(--shadow-lg); white-space: nowrap;
    transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), opacity 0.3s;
    pointer-events: none; opacity: 0;
}
.shop-toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
    .shop-layout { grid-template-columns: 1fr; }
    .shop-sidebar { display: none; }
}
@media (max-width: 768px) {
    .nav-links-shop { display: none; }
    .nav-hamburger-shop { display: flex; }
    .controls-inner { flex-wrap: wrap; }
    .search-field { max-width: none; flex: 1 1 100%; }
    .sort-pick { flex: 1; }
    .result-count { margin-left: 0; flex: 0 0 auto; }
    .shop-layout { padding: 1.2rem 1rem; }
    .products-grid { grid-template-columns: repeat(auto-fill, minmax(155px, 1fr)); gap: 0.75rem; }
    .p-card-img { font-size: 3rem; }
    .c-drawer { max-width: 100%; }
}
@media (max-width: 480px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); }
    .shop-hero h1 { font-size: 1.7rem; }
    .p-name { font-size: 0.82rem; }
    .p-price { font-size: 0.95rem; }
}
</style>

{{-- ═══════════════════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════════════════ --}}
<nav class="shop-navbar">
    <div class="nav-inner-shop">
        <a href="{{ route('home') }}" class="nav-brand-shop">
            <span class="brand-icon">🐾</span>
            <span class="brand-text">PawHaven</span>
        </a>

        <ul class="nav-links-shop">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('home') }}#pets">Our Pets</a></li>
            <li><a href="{{ route('home') }}#products">Our Products</a></li>
            <li><a href="{{ route('home') }}#services">Services</a></li>
            <li><a href="{{ route('home') }}#contact">Contact</a></li>
        </ul>

        <div class="nav-right-shop">
            @auth
                <span class="nav-welcome-shop">Hi, {{ Auth::user()->name }}! 🐾</span>
            @endauth
            <button class="cart-trigger" onclick="toggleCart()">
                🛒 Cart
                <span class="cart-pill" id="cartBadge">0</span>
            </button>
            <button class="nav-hamburger-shop" id="shopHamburger" onclick="toggleMobileMenu()">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <div class="mobile-menu-shop" id="shopMobileMenu">
        <a href="{{ route('home') }}">🏠 Home</a>
        <a href="{{ route('home') }}#pets">🐾 Our Pets</a>
        <a href="{{ route('home') }}#products">📦 Our Products</a>
        <a href="{{ route('home') }}#services">✂️ Services</a>
        <a href="{{ route('home') }}#contact">✉️ Contact</a>
    </div>
</nav>

{{-- ═══════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════ --}}
<section class="shop-hero">
    <div class="shop-hero-bg">🐕 🐱 🦜 🐹 🐠 🦎</div>
    <div class="shop-hero-inner">
        <div class="shop-hero-badge">🛍️ Full Catalog</div>
        <h1>Shop <em>PawHaven</em></h1>
        <p>Browse our complete collection of pets and premium supplies.<br>Everything your furry family needs, all in one place.</p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     CONTROLS BAR
═══════════════════════════════════════════════════════════ --}}
<div class="controls-bar">
    <div class="controls-inner">
        <div class="search-field">
            <span class="search-icon-inp">🔍</span>
            <input type="text" id="searchInput" placeholder="Search pets &amp; products…" oninput="applyFilters()" autocomplete="off">
        </div>
        <select class="sort-pick" id="sortPick" onchange="applyFilters()">
            <option value="featured">Featured</option>
            <option value="price-asc">Price: Low → High</option>
            <option value="price-desc">Price: High → Low</option>
            <option value="name-asc">Name: A → Z</option>
        </select>
        <span class="result-count" id="resultCount">— items</span>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     CATEGORY PILLS
═══════════════════════════════════════════════════════════ --}}
<div class="pills-bar">
    <div class="pills-inner" id="pillsContainer">
        {{-- Rendered by JS --}}
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     SHOP LAYOUT
═══════════════════════════════════════════════════════════ --}}
<div class="shop-layout">

    {{-- SIDEBAR --}}
    <aside class="shop-sidebar">
        <div class="sidebar-box">
            <div class="sidebar-label">Filter by Type</div>
            <button class="type-opt active" id="type-All" onclick="setType('All')">
                <span class="opt-icon">🐾</span> All Items
                <span class="opt-count" id="cnt-All"></span>
            </button>
            <button class="type-opt" id="type-pet" onclick="setType('pet')">
                <span class="opt-icon">🐕</span> Pets Only
                <span class="opt-count" id="cnt-pet"></span>
            </button>
            <button class="type-opt" id="type-product" onclick="setType('product')">
                <span class="opt-icon">📦</span> Supplies Only
                <span class="opt-count" id="cnt-product"></span>
            </button>
            <button class="type-opt" id="type-service" onclick="setType('service')">
                <span class="opt-icon">✂️</span> Services Only
                <span class="opt-count" id="cnt-service"></span>
            </button>
        </div>

        <div class="sidebar-box">
            <div class="sidebar-label">Max Price</div>
            <div class="price-display">
                <span>₱0</span>
                <span id="priceLabel">Any</span>
            </div>
            <input type="range" id="priceSlider" min="0" max="50000" step="500" value="50000"
                   oninput="onPriceChange()">
        </div>

        <button class="clear-all-btn" onclick="clearFilters()">✕ Clear All Filters</button>
    </aside>

    {{-- MAIN --}}
    <div class="shop-main">
        <div class="products-grid" id="productsGrid"></div>
        <div class="empty-shop" id="emptyShop" style="display:none;">
            <span class="big-emoji">🔍</span>
            <h3>No results found</h3>
            <p>Try a different category, keyword, or adjust the price range.</p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     CART OVERLAY
═══════════════════════════════════════════════════════════ --}}
<div class="c-overlay" id="cOverlay" onclick="toggleCart()"></div>

{{-- ═══════════════════════════════════════════════════════════
     CART DRAWER (SINGLE INSTANCE)
═══════════════════════════════════════════════════════════ --}}
{{-- ═══════════════════════════════════════════════════════════
     CART DRAWER (FIXED LAYOUT)
═══════════════════════════════════════════════════════════ --}}
<aside class="c-drawer" id="cDrawer">
    <div class="c-head">
        <h2>🛒 Your Cart</h2>
        <button class="c-close" onclick="toggleCart()">✕</button>
    </div>

    {{-- Scrollable Content Area --}}
    <div class="c-scrollable" style="flex: 1; overflow-y: auto; padding: 1rem;">
        {{-- Cart Items List --}}
        <div id="cList">
            <div class="c-empty">
                <span class="ce">🛒</span>
                <p>Your cart is empty.<br>Add some pets or supplies to get started!</p>
            </div>
        </div>

        {{-- Delivery Details Section --}}
        <div class="c-verification" id="verificationSection" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border); display:none;">
            <h3 style="font-size: 0.9rem; margin-bottom: 1rem; font-family: var(--serif);">📍 Delivery Details</h3>
            
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; font-weight: 800; color: var(--brown-muted); display: block; margin-bottom: 0.4rem;">SELECT CITY (CAVITE)</label>
                <select id="citySelect" class="sort-pick" style="width: 100%; border-radius: 10px;" onchange="updateBarangays()">
                    <option value="">-- Choose City --</option>
                    <option value="GMA">Gen. Mariano Alvarez</option>
                    <option value="Dasmarinas">Dasmariñas</option>
                    <option value="Silang">Silang</option>
                </select>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; font-weight: 800; color: var(--brown-muted); display: block; margin-bottom: 0.4rem;">SELECT BARANGAY</label>
                <select id="brgySelect" class="sort-pick" style="width: 100%; border-radius: 10px;" disabled>
                    <option value="">-- Select City First --</option>
                </select>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; font-weight: 800; color: var(--brown-muted); display: block; margin-bottom: 0.4rem;">PH PHONE NUMBER</label>
                <div style="display: flex; gap: 5px;">
                    <input type="text" id="phoneInput" placeholder="09123456789" maxlength="11" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                           style="flex: 1; padding: 0.6rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.85rem;">
                    <button onclick="sendMockOTP()" id="otpBtn" class="add-to-cart" style="font-size: 0.65rem; padding: 0 10px;">Send OTP</button>
                </div>
            </div>

            <div id="otpInputWrap" style="display: none; margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; font-weight: 800; color: var(--brown-muted); display: block; margin-bottom: 0.4rem;">ENTER 4-DIGIT CODE</label>
                <input type="text" id="otpCode" maxlength="4" placeholder="0000"
                       style="width: 100%; padding: 0.6rem; border: 2px solid var(--border); border-radius: 10px; text-align: center; letter-spacing: 5px; font-weight: bold;">
            </div>
        </div>
    </div>

    {{-- Fixed Footer with Payment & Checkout --}}
    <div class="c-foot" id="cFoot" style="display:none; border-top: 1px solid var(--border); padding: 1.15rem;">
        <div class="c-summary">
            <div class="payment-method" style="margin: 15px 0; padding: 10px; border-top: 1px dashed #ddd;">
                <p style="font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Payment Method:</p>
                <div style="display: flex; gap: 15px;">
                    <label style="cursor: pointer; font-size: 0.85rem;">
                        <input type="radio" name="payment" value="cash" checked> Cash
                    </label>
                    <label style="cursor: pointer; font-size: 0.85rem;">
                        <input type="radio" name="payment" value="gcash"> GCash
                    </label>
                </div>
            </div>
            <div class="c-row">
                <span class="lbl">Subtotal</span>
                <span id="cSubtotal">₱0</span>
            </div>
            <div class="c-row">
                <span class="lbl">Delivery</span>
                <span class="delivery-note">To be arranged</span>
            </div>
            <div class="c-row total">
                <span>Total</span>
                <span id="cTotal" style="color:var(--orange);">₱0</span>
            </div>
        </div>
        <button class="checkout-btn" onclick="handleCheckout()">
            Proceed to Checkout 🐾
        </button>
    </div>
</aside>

{{-- ═══════════════════════════════════════════════════════════
     GCASH & PROOF MODALS (SINGLE INSTANCE EACH)
═══════════════════════════════════════════════════════════ --}}
<div id="gcashModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:9999; align-items:center; justify-content:center; padding:20px;">
    <div style="background:white; padding:25px; border-radius:15px; max-width:400px; width:100%; text-align:center; position:relative;">
        <button onclick="closeModal('gcashModal')" style="position:absolute; right:15px; top:10px; border:none; background:none; font-size:20px; cursor:pointer;">✕</button>
        <h3 style="color:#007dfe; margin-bottom:5px;">Pay via GCash</h3>
        <p style="font-size:0.85rem; color:#666;">Scan the QR or send to the number below:</p>
        
        <div style="margin:15px 0; border:1px solid #eee; padding:10px; border-radius:10px;">
            <img src="{{ asset('images/gcash-qr.png') }}" alt="GCash QR" style="width:100%; max-width:200px;">
        </div>
        
        <div style="background:#f3f7ff; padding:12px; border-radius:8px; margin-bottom:15px;">
            <p style="margin:0; font-size:0.8rem; color:#555;">GCash Number:</p>
            <p style="margin:0; font-weight:bold; font-size:1.2rem; color:#007dfe;">0912 345 6789</p>
            <p style="margin:0; font-size:0.8rem; color:#555;">Name: PAWHAVEN ADMIN</p>
        </div>

        <button onclick="showProofModal()" class="checkout-btn" style="width:100%; background:#007dfe;">I have sent the payment 🐾</button>
    </div>
</div>

<div id="proofModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:10000; align-items:center; justify-content:center; padding:20px;">
    <div style="background:white; padding:25px; border-radius:15px; max-width:400px; width:100%; position:relative;">
        <button onclick="closeModal('proofModal')" style="position:absolute; right:15px; top:10px; border:none; background:none; font-size:20px; cursor:pointer;">✕</button>
        <h3 style="text-align:center; margin-bottom:10px;">Verification</h3>
        <p style="text-align:center; font-size:0.85rem; color:#666; margin-bottom:20px;">Please provide payment details to confirm your order.</p>
        
        <div style="margin-bottom:15px;">
            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:5px;">Reference Number</label>
            <input type="text" 
                id="refNum" 
                placeholder="13-digit reference number" 
                maxlength="13" 
                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:5px;">Screenshot of Receipt</label>
            <input type="file" id="screenshot" accept="image/*" style="width:100%; font-size:0.85rem;">
        </div>

        <button onclick="submitFinalCheckout()" class="checkout-btn" style="width:100%;">Submit & Place Order 🚀</button>
    </div>
</div>

{{-- TOAST --}}
<div class="shop-toast" id="shopToast"></div>

{{-- ═══════════════════════════════════════════════════════════
     JAVASCRIPT (ALL FUNCTIONS INSIDE SCRIPT TAG)
═══════════════════════════════════════════════════════════ --}}
<script>
/* ── DATA ── */
const CATALOG = @json($catalog);

// Map categories to specific types so pills update dynamically
const CAT_GROUPS = {
    'All':     ['All','Dogs','Cats','Birds','Small Pets','Fish','Reptiles','Food','Toys','Accessories','Grooming','Health','Salon','Clinic','Boarding','Training'],
    'pet':     ['All','Dogs','Cats','Birds','Small Pets','Fish','Reptiles'],
    'product': ['All','Food','Toys','Accessories','Grooming','Health'],
    'service': ['All','Salon','Clinic','Boarding','Training']
};
const CAT_EMOJI  = {All:'🐾',Dogs:'🐕',Cats:'🐱',Birds:'🦜','Small Pets':'🐹',Fish:'🐠',Reptiles:'🦎',Food:'🍖',Toys:'🎾',Accessories:'🏷️',Grooming:'🪮',Health:'💊',Salon:'✂️',Clinic:'🩺',Boarding:'🏨',Training:'🦮'};

/* ── NEW ANTI-SCAM DATA ── */
const ADRESS_DATA = {
    'GMA': ['Poblacion 1', 'Poblacion 2', 'San Gabriel', 'San Jose', 'Kessel Ville'],
    'Dasmarinas': ['Sampaloc 1', 'Burol', 'Salitran', 'Langkaan'],
    'Silang': ['Bulihan', 'Iba', 'Munting Ilog', 'Tibig']
};

/* ── STATE ── */
let cart       = [];
let activeCat  = 'All';
let activeType = 'All';
let generatedOTP = null; // Store the mock OTP

/* ── INIT ── */
function init() {
    const urlParams = new URLSearchParams(window.location.search);
    const paramType = urlParams.get('type');
    
    if (paramType && ['pet', 'product', 'service'].includes(paramType)) {
        activeType = paramType;
    }

    syncSidebarUI();
    renderPills();
    updateTypeCounts();
    applyFilters();
}

/* ── ADDRESS DROPDOWN LOGIC ── */
function updateBarangays() {
    const city = document.getElementById('citySelect').value;
    const brgyDropdown = document.getElementById('brgySelect');
    
    brgyDropdown.innerHTML = '<option value="">-- Select Barangay --</option>';
    
    if (city && ADRESS_DATA[city]) {
        brgyDropdown.disabled = false;
        ADRESS_DATA[city].forEach(brgy => {
            brgyDropdown.innerHTML += `<option value="${brgy}">${brgy}</option>`;
        });
    } else {
        brgyDropdown.disabled = true;
    }
}

/* ── OTP SIMULATION ── */
function sendMockOTP() {
    const phone = document.getElementById('phoneInput').value;
    
    // Validate PH Number (starts with 09 and is 11 digits)
    if (phone.length !== 11 || !phone.startsWith('09')) {
        showToast('❌ Enter a valid 11-digit PH phone number.');
        return;
    }

    generatedOTP = Math.floor(1000 + Math.random() * 9000);
    document.getElementById('otpInputWrap').style.display = 'block';
    
    // Simulation: In a real app, this would be an API call to an SMS provider
    alert(`[PawHaven] Your verification code is: ${generatedOTP}`);
    showToast('📟 OTP sent to ' + phone);
}

/* ── CATEGORY PILLS ── */
function renderPills() {
    const categoriesToShow = CAT_GROUPS[activeType] || CAT_GROUPS['All'];
    
    document.getElementById('pillsContainer').innerHTML = categoriesToShow.map(c => `
        <button class="cat-pill ${c === activeCat ? 'active' : ''}" onclick="setCategory('${c}')">
            ${CAT_EMOJI[c] || '✨'} ${c}
        </button>`).join('');
}

function setCategory(cat) {
    activeCat = cat;
    renderPills();
    applyFilters();
}

/* ── TYPE FILTER ── */
function setType(type) {
    activeType = type;
    activeCat = 'All'; 
    const newUrl = type === 'All' ? window.location.pathname : `${window.location.pathname}?type=${type}`;
    window.history.pushState({}, '', newUrl);
    syncSidebarUI();
    renderPills();
    applyFilters();
}

function syncSidebarUI() {
    ['All', 'pet', 'product', 'service'].forEach(t => {
        const el = document.getElementById('type-' + t);
        if (el) el.classList.toggle('active', t === activeType);
    });
}

function updateTypeCounts() {
    document.getElementById('cnt-All').textContent     = CATALOG.length;
    document.getElementById('cnt-pet').textContent     = CATALOG.filter(i => i.type === 'pet').length;
    document.getElementById('cnt-product').textContent = CATALOG.filter(i => i.type === 'product').length;
    document.getElementById('cnt-service').textContent = CATALOG.filter(i => i.type === 'service').length;
}

/* ── PRICE CHANGE ── */
function onPriceChange() {
    const v = parseInt(document.getElementById('priceSlider').value);
    document.getElementById('priceLabel').textContent = v >= 50000 ? 'Any' : '₱' + v.toLocaleString('en-PH');
    applyFilters();
}

/* ── APPLY FILTERS + SORT ── */
function applyFilters() {
    const q    = document.getElementById('searchInput').value.toLowerCase().trim();
    const sort = document.getElementById('sortPick').value;
    const maxP = parseInt(document.getElementById('priceSlider').value);

    let list = CATALOG.filter(item => {
        if (activeCat !== 'All' && item.category !== activeCat) return false;
        if (activeType !== 'All' && item.type !== activeType)   return false;
        if (item.price > maxP) return false;
        if (q && !item.name.toLowerCase().includes(q) && !item.category.toLowerCase().includes(q)) return false;
        return true;
    });

    if      (sort === 'price-asc')  list.sort((a,b) => a.price - b.price);
    else if (sort === 'price-desc') list.sort((a,b) => b.price - a.price);
    else if (sort === 'name-asc')   list.sort((a,b) => a.name.localeCompare(b.name));

    renderGrid(list);
    document.getElementById('resultCount').textContent = list.length + ' item' + (list.length !== 1 ? 's' : '');
}

/* ── RENDER GRID ── */
function renderGrid(items) {
    const grid  = document.getElementById('productsGrid');
    const empty = document.getElementById('emptyShop');
    if (!items.length) { grid.style.display = 'none'; empty.style.display = 'block'; return; }
    grid.style.display = 'grid'; empty.style.display = 'none';
    
    grid.innerHTML = items.map(item => {
        const inCart = cart.some(c => c.id === item.id);
        let typeText = '🐾 Pet';
        if(item.type === 'product') typeText = '📦 Supply';
        if(item.type === 'service') typeText = '✂️ Service';

        return `
        <div class="p-card ${!item.available ? 'unavail' : ''}">
            <div class="p-card-img">
                <span>${item.emoji}</span>
                <span class="type-chip">${typeText}</span>
                <span class="p-badge b-${item.badge}">${item.badgeLabel}</span>
                ${!item.available ? '<span class="unavail-chip">Unavailable</span>' : ''}
            </div>
            <div class="p-card-body">
                <div class="p-category">${item.category}</div>
                <div class="p-name">${item.name}</div>
                <div class="p-desc">${item.desc}</div>
                <div class="p-footer">
                    <div class="p-price">₱${item.price.toLocaleString('en-PH')}</div>
                    <button class="add-to-cart ${inCart ? 'in-cart' : ''}"
                            onclick="addToCart(${item.id})"
                            ${!item.available ? 'disabled' : ''}>
                        ${inCart ? '✓ Added' : '+ Add'}
                    </button>
                </div>
            </div>
        </div>`;
    }).join('');
}

/* ── CART: ADD ── */
function addToCart(id) {
    const item = CATALOG.find(i => i.id === id);
    if (!item || !item.available) return;
    const existing = cart.find(c => c.id === id);
    if (existing) { existing.qty++; }
    else           { cart.push({ ...item, qty: 1 }); }
    renderCart();
    applyFilters();
    showToast(item.emoji + ' ' + item.name + ' added!');
    bumpBadge();
}

/* ── CART: REMOVE ── */
function removeFromCart(id) {
    cart = cart.filter(c => c.id !== id);
    renderCart();
    applyFilters();
}

/* ── CART: QUANTITY ── */
function updateQty(id, delta) {
    const item = cart.find(c => c.id === id);
    if (!item) return;
    item.qty = Math.max(1, item.qty + delta);
    renderCart();
}

/* ── CART: RENDER (WITH COD LIMIT LOGIC) ── */
function renderCart() {
    const list   = document.getElementById('cList');
    const foot   = document.getElementById('cFoot');
    const verification = document.getElementById('verificationSection');
    const badge  = document.getElementById('cartBadge');
    const totalQty  = cart.reduce((s,i) => s + i.qty, 0);
    badge.textContent = totalQty;

    if (!cart.length) {
        list.innerHTML = `<div class="c-empty"><span class="ce">🛒</span><p>Your cart is empty.<br>Add some pets or supplies!</p></div>`;
        foot.style.display = 'none';
        if(verification) verification.style.display = 'none';
        return;
    }

    const subtotal = cart.reduce((s,i) => s + i.price * i.qty, 0);
    const hasPet = cart.some(i => i.type === 'pet');

    list.innerHTML = cart.map(item => `
        <div class="c-item">
            <div class="c-emoji">${item.emoji}</div>
            <div class="c-info">
                <div class="c-iname" title="${item.name}">${item.name}</div>
                <div class="c-icat">${item.category}</div>
                <div class="c-iprice">₱${(item.price * item.qty).toLocaleString('en-PH')}</div>
            </div>
            <div class="qty-wrap">
                <button class="q-btn" onclick="updateQty(${item.id},-1)">−</button>
                <span class="q-num">${item.qty}</span>
                <button class="q-btn" onclick="updateQty(${item.id},+1)">+</button>
            </div>
            <button class="c-del" onclick="removeFromCart(${item.id})" title="Remove">🗑️</button>
        </div>`).join('');

    // Update Payment Methods based on rules
    const paymentWrap = document.querySelector('.payment-method');
    if (paymentWrap) {
        let paymentHTML = `<p style="font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Payment Method:</p>`;
        
        // LIMIT COD RULE: Over 2k or contains a pet
        if (hasPet || subtotal > 2000) {
            const dp = subtotal * 0.20;
            paymentHTML += `
                <div style="background: #fff4e5; padding: 10px; border-radius: 8px; border-left: 4px solid #f39c12; margin-bottom: 8px;">
                    <label style="cursor: pointer; font-size: 0.85rem; display: block; color: #d35400; font-weight: 700;">
                        <input type="radio" name="payment" value="gcash" checked> GCash (20% Downpayment Required)
                    </label>
                    <p style="font-size: 0.7rem; margin-top: 5px; color: #666;">
                        High-value orders/Pets require a ₱${dp.toLocaleString()} reservation fee via GCash.
                    </p>
                </div>
                <label style="font-size: 0.85rem; color: #ccc; cursor: not-allowed; display: block; opacity: 0.6;">
                    <input type="radio" name="payment" disabled> Cash on Delivery (Disabled)
                </label>`;
        } else {
            paymentHTML += `
                <div style="display: flex; gap: 15px;">
                    <label style="cursor: pointer; font-size: 0.85rem;"><input type="radio" name="payment" value="cash" checked> Cash</label>
                    <label style="cursor: pointer; font-size: 0.85rem;"><input type="radio" name="payment" value="gcash"> GCash</label>
                </div>`;
        }
        paymentWrap.innerHTML = paymentHTML;
    }

    document.getElementById('cSubtotal').textContent = '₱' + subtotal.toLocaleString('en-PH');
    document.getElementById('cTotal').textContent    = '₱' + subtotal.toLocaleString('en-PH');
    foot.style.display = 'block';
    if(verification) verification.style.display = 'block';
}

/* ── CART: TOGGLE ── */
function toggleCart() {
    const drawer  = document.getElementById('cDrawer');
    const overlay = document.getElementById('cOverlay');
    const isOpen  = drawer.classList.toggle('open');
    overlay.classList.toggle('open', isOpen);
    document.body.style.overflow = isOpen ? 'hidden' : '';
}

/* ── CHECKOUT HANDLER (WITH ADDRESS & PHONE VALIDATION) ── */
function handleCheckout() {
    const city = document.getElementById('citySelect').value;
    const brgy = document.getElementById('brgySelect').value;
    const phone = document.getElementById('phoneInput').value;
    const otp = document.getElementById('otpCode').value;
    const paymentMethod = document.querySelector('input[name="payment"]:checked').value;

    // 1. Validate Address Selection
    if (!city || !brgy) {
        showToast('📍 Please select your valid delivery address.');
        return;
    }

    // 2. Validate Phone
    if (phone.length !== 11) {
        showToast('📱 Please enter a valid 11-digit phone number.');
        return;
    }

    // 3. Validate OTP
    if (!generatedOTP || otp !== String(generatedOTP)) {
        showToast('🔑 Incorrect or missing OTP code.');
        return;
    }

    // 4. Proceed based on Payment Method
    if (paymentMethod === 'gcash') {
        const subtotal = cart.reduce((s,i) => s + i.price * i.qty, 0);
        const hasPet = cart.some(i => i.type === 'pet');
        const finalPay = (hasPet || subtotal > 2000) ? subtotal * 0.20 : subtotal;
        
        // Update modal text to show the DP amount if applicable
        const gcashTitle = document.querySelector('#gcashModal h3');
        if(gcashTitle) gcashTitle.innerText = `Pay ₱${finalPay.toLocaleString()} via GCash`;
        
        document.getElementById('gcashModal').style.display = 'flex';
    } else {
        if(confirm(`Confirm COD order for ${phone}?`)) {
            processFinalOrder();
        }
    }
}

/* ── GCASH MODAL FUNCTIONS ── */
function showProofModal() {
    document.getElementById('gcashModal').style.display = 'none';
    document.getElementById('proofModal').style.display = 'flex';
}

function submitFinalCheckout() {
    const ref = document.getElementById('refNum').value;
    const file = document.getElementById('screenshot').files[0];
    const warningModal = document.getElementById('warningModal');
    const warningText = document.getElementById('warningMessage');

    if (ref.length !== 13) {
        warningText.innerText = "The GCash Reference Number must be exactly 13 digits.";
        warningModal.style.display = 'flex';
        return;
    }

    if (!file) {
        warningText.innerText = "Please upload a screenshot of your payment receipt.";
        warningModal.style.display = 'flex';
        return;
    }

    document.getElementById('proofModal').style.display = 'none';
    processFinalOrder();
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

/* ── FINAL ORDER PROCESSING ── */
function processFinalOrder() {
    showToast('🚀 Order placed! Our team will verify your details soon.');
    cart = [];
    generatedOTP = null; // Reset OTP for next order
    renderCart();
    applyFilters();
    setTimeout(toggleCart, 600);
}

/* ── CLEAR FILTERS ── */
function clearFilters() {
    activeCat  = 'All';
    activeType = 'All';
    document.getElementById('searchInput').value   = '';
    document.getElementById('sortPick').value       = 'featured';
    document.getElementById('priceSlider').value    = '50000';
    document.getElementById('priceLabel').textContent = 'Any';
    renderPills();
    setType('All');
    applyFilters();
}

/* ── MOBILE MENU ── */
function toggleMobileMenu() {
    const m = document.getElementById('shopMobileMenu');
    m.style.display = m.style.display === 'block' ? 'none' : 'block';
}

/* ── TOAST ── */
let toastTimer = null;
function showToast(msg) {
    const el = document.getElementById('shopToast');
    el.textContent = msg;
    el.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => el.classList.remove('show'), 2600);
}

/* ── BADGE BUMP ── */
function bumpBadge() {
    const b = document.getElementById('cartBadge');
    b.classList.add('bump');
    setTimeout(() => b.classList.remove('bump'), 300);
}

/* ── AUTO-ADD FROM URL PARAM ── */
document.addEventListener('DOMContentLoaded', () => {
    init();
    
    const urlParams = new URLSearchParams(window.location.search);
    const productIdToAdd = urlParams.get('addToCart');

    if (productIdToAdd) {
        const id = parseInt(productIdToAdd);
        const productExists = CATALOG.some(p => p.id === id);
        
        if (productExists) {
            addToCart(id);
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        }
    }
});
</script>

<div id="warningModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:20000; align-items:center; justify-content:center; padding:20px;">
    <div style="background:white; padding:30px; border-radius:20px; max-width:350px; width:100%; text-align:center; box-shadow: var(--shadow-lg);">
        <div style="font-size: 50px; margin-bottom: 15px;">⚠️</div>
        <h3 style="color: var(--brown); margin-bottom: 10px;">Wait a paw-second!</h3>
        <p id="warningMessage" style="font-size: 0.9rem; color: #666; margin-bottom: 25px;">
            Please provide both the reference number and the screenshot of your payment.
        </p>
        <button onclick="closeModal('warningModal')" class="checkout-btn" style="width:100%; background: var(--orange);">
            Got it! 🐾
        </button>
    </div>
</div>

@endsection