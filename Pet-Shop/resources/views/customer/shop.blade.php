@extends('layouts.app')

@section('title', 'PawHaven Shop — Pets & Supplies')

@section('content')

@php
$catalog = [
    // ── PETS ──
    ['id'=>1,  'name'=>'Golden Retriever Puppy', 'emoji'=>'🐕', 'category'=>'Dogs',       'type'=>'pet',     'price'=>18000, 'badge'=>'popular',    'badgeLabel'=>'Popular',    'desc'=>'Friendly, intelligent and devoted. The perfect family companion for any home.',    'available'=>true],
    ['id'=>2,  'name'=>'Siamese Kitten',          'emoji.,'=>'🐱', 'category'=>'Cats',       'type'=>'pet',     'price'=>12000, 'badge'=>'new',         'badgeLabel'=>'New',         'desc'=>'Elegant, vocal and affectionate with captivating deep-blue eyes.',                 'available'=>true],
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
.nav-brand-shop { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; flex-shrink: 0; }
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
.nav-right-shop { display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0; }
.nav-welcome-shop { font-size: 0.82rem; font-weight: 600; color: var(--brown-sub); }
.cart-trigger {
    position: relative; display: flex; align-items: center; gap: 0.5rem;
    background: var(--orange); color: white; border: none; border-radius: 50px;
    padding: 0.55rem 1.25rem; font-size: 0.85rem; font-weight: 800; cursor: pointer;
    box-shadow: 0 4px 14px var(--orange-glow);
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}
.cart-trigger:hover { background: var(--orange-dark); transform: translateY(-1px); box-shadow: 0 6px 20px var(--orange-glow); }
.cart-pill {
    background: white; color: var(--orange); border-radius: 50px; padding: 0 0.45rem;
    height: 20px; min-width: 20px; display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; font-weight: 900; line-height: 1; transition: transform 0.2s;
}
.cart-pill.bump { animation: pill-bump 0.25s ease; }
@keyframes pill-bump { 0%,100%{transform:scale(1)} 50%{transform:scale(1.5)} }
.nav-hamburger-shop { display: none; background: none; border: none; cursor: pointer; padding: 0.4rem; flex-direction: column; gap: 4px; }
.nav-hamburger-shop span { display: block; width: 22px; height: 2px; background: var(--brown); border-radius: 2px; transition: all 0.3s; }
.mobile-menu-shop { display: none; background: var(--white); border-top: 1px solid var(--border); padding: 1rem 1.5rem; }
.mobile-menu-shop a { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; text-decoration: none; color: var(--brown-sub); font-size: 0.9rem; font-weight: 600; border-bottom: 1px solid var(--border); }
.mobile-menu-shop a:last-child { border-bottom: none; }
.mobile-menu-shop a:hover { color: var(--orange); }

/* ── SHOP HERO ── */
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
.shop-hero h1 { font-family: var(--serif); font-size: clamp(2rem,5vw,3rem); color: white; margin-bottom: 0.75rem; line-height: 1.15; }
.shop-hero h1 em { color: var(--orange); font-style: normal; }
.shop-hero p { color: rgba(255,255,255,0.65); font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.5rem; }

/* ── QUIZ TRIGGER BUTTON (in hero) ── */
.quiz-hero-cta {
    display: inline-flex; align-items: center; gap: 0.6rem;
    background: rgba(255,255,255,0.12); color: white;
    border: 1.5px solid rgba(255,255,255,0.3);
    border-radius: 50px; padding: 0.65rem 1.5rem;
    font-size: 0.88rem; font-weight: 700; cursor: pointer;
    transition: background 0.2s, border-color 0.2s, transform 0.15s;
    margin-top: 0.25rem;
}
.quiz-hero-cta:hover { background: rgba(230,138,57,0.25); border-color: var(--orange); transform: translateY(-2px); }
.quiz-hero-cta .qhc-icon { font-size: 1.1rem; }
.quiz-hero-cta .qhc-arrow { opacity: 0.7; }

/* ── CONTROLS BAR ── */
.controls-bar {
    position: sticky; top: 70px; z-index: 90;
    background: var(--white); border-bottom: 1px solid var(--border); padding: 0.9rem 1.5rem;
}
.controls-inner { max-width: 1400px; margin: 0 auto; display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
.search-field { position: relative; flex: 1; min-width: 180px; max-width: 380px; }
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
    background: var(--cream); color: var(--brown-sub); font-size: 0.82rem; font-weight: 700;
    outline: none; cursor: pointer; transition: border-color 0.2s;
}
.sort-pick:focus { border-color: var(--orange); }
.result-count { margin-left: auto; font-size: 0.78rem; font-weight: 700; color: var(--brown-muted); white-space: nowrap; }

/* ── QUIZ ACTIVE BANNER ── */
.quiz-active-banner {
    display: none;
    background: linear-gradient(135deg, #FFF4E6, #FDF8F1);
    border: 2px solid var(--border-mid);
    border-radius: var(--radius-md);
    padding: 0.9rem 1.25rem;
    margin-bottom: 1.25rem;
    align-items: center; gap: 0.85rem; flex-wrap: wrap;
}
.quiz-active-banner.visible { display: flex; }
.qab-emoji { font-size: 1.5rem; flex-shrink: 0; }
.qab-text { flex: 1; }
.qab-text strong { font-size: 0.88rem; font-weight: 800; color: var(--brown); display: block; }
.qab-text span { font-size: 0.77rem; color: var(--brown-muted); }
.qab-clear {
    background: none; border: 1.5px solid var(--border-mid); border-radius: 50px;
    padding: 0.38rem 0.9rem; font-size: 0.76rem; font-weight: 700;
    color: var(--brown-muted); cursor: pointer; transition: all 0.15s; white-space: nowrap;
}
.qab-clear:hover { border-color: var(--red); color: var(--red); }
.qab-redo {
    background: var(--orange); border: none; border-radius: 50px;
    padding: 0.4rem 0.9rem; font-size: 0.76rem; font-weight: 800;
    color: white; cursor: pointer; transition: background 0.15s; white-space: nowrap;
}
.qab-redo:hover { background: var(--orange-dark); }

.p-card.quiz-match { border-color: var(--orange); box-shadow: 0 0 0 3px rgba(230,138,57,0.18); }
.p-card.quiz-match .p-card-img::after {
    content: '⭐ Best Match';
    position: absolute; bottom: 0.6rem; left: 0.6rem;
    background: var(--orange); color: white;
    font-size: 0.6rem; font-weight: 900; text-transform: uppercase;
    padding: 0.2rem 0.6rem; border-radius: 50px; letter-spacing: 0.06em;
}

/* ── CATEGORY PILLS ── */
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
    cursor: pointer; white-space: nowrap; transition: all 0.18s; user-select: none;
}
.cat-pill:hover { border-color: var(--orange); color: var(--orange); background: var(--cream-mid); }
.cat-pill.active { background: var(--orange); border-color: var(--orange); color: white; box-shadow: 0 3px 10px var(--orange-glow); }

/* ── SHOP LAYOUT ── */
.shop-layout { max-width: 1400px; margin: 0 auto; padding: 2rem 1.5rem; display: grid; grid-template-columns: 220px 1fr; gap: 2rem; }

/* ── SIDEBAR ── */
.shop-sidebar { position: sticky; top: calc(70px + 57px + 48px + 2rem); height: fit-content; }
.sidebar-box { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.25rem; margin-bottom: 0.9rem; box-shadow: var(--shadow-sm); }
.sidebar-label { font-size: 0.68rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.14em; color: var(--brown-muted); margin-bottom: 0.85rem; }

.sidebar-quiz-btn {
    width: 100%; display: flex; align-items: center; gap: 0.6rem;
    background: linear-gradient(135deg, #FFF4E6, #FDF2E9);
    border: 2px solid var(--border-mid); border-radius: var(--radius-md);
    padding: 0.75rem 0.9rem; cursor: pointer; transition: all 0.18s;
    text-align: left;
}
.sidebar-quiz-btn:hover { border-color: var(--orange); box-shadow: 0 4px 14px var(--orange-glow); transform: translateY(-1px); }
.sqb-icon { font-size: 1.4rem; }
.sqb-text strong { display: block; font-size: 0.82rem; font-weight: 800; color: var(--brown); }
.sqb-text span { font-size: 0.71rem; color: var(--brown-muted); }

.type-opt {
    display: flex; align-items: center; gap: 0.65rem; padding: 0.5rem 0.65rem;
    border-radius: var(--radius-sm); cursor: pointer; transition: background 0.15s;
    font-size: 0.85rem; font-weight: 600; color: var(--brown-sub);
    border: none; background: transparent; width: 100%; text-align: left; margin-bottom: 0.2rem;
}
.type-opt:hover { background: var(--cream); }
.type-opt.active { background: var(--cream-mid); color: var(--orange); }
.type-opt .opt-icon { font-size: 1rem; }
.type-opt .opt-count { margin-left: auto; font-size: 0.7rem; color: var(--brown-muted); background: var(--cream); padding: 0.1rem 0.45rem; border-radius: 50px; font-weight: 700; }
.price-display { display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 700; color: var(--brown-sub); margin-bottom: 0.6rem; }
input[type=range] { width: 100%; accent-color: var(--orange); cursor: pointer; }
.clear-all-btn { width: 100%; padding: 0.6rem; border-radius: 50px; border: 2px solid var(--border-mid); background: transparent; color: var(--brown-sub); font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: all 0.2s; }
.clear-all-btn:hover { border-color: var(--orange); color: var(--orange); background: var(--cream-mid); }

/* ── PRODUCTS GRID ── */
.shop-main { min-width: 0; }
.products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 1.1rem; }

/* ── PRODUCT CARD ── */
.p-card { background: var(--white); border: 2px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s; }
.p-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--border-mid); }
.p-card.unavail { opacity: 0.6; }
.p-card-img { aspect-ratio: 1; background: var(--cream); display: flex; align-items: center; justify-content: center; font-size: 3.8rem; position: relative; border-bottom: 1px solid var(--border); }
.type-chip { position: absolute; top: 0.7rem; left: 0.7rem; font-size: 0.6rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; padding: 0.18rem 0.55rem; border-radius: 50px; background: rgba(45,36,30,0.07); color: var(--brown-sub); }
.p-badge { position: absolute; top: 0.7rem; right: 0.7rem; font-size: 0.62rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.06em; padding: 0.2rem 0.55rem; border-radius: 50px; }
.b-popular    { background:#FDF2E9; color:#E68A39; }
.b-new        { background:#E9F7F2; color:#34A853; }
.b-cute       { background:#FCE7F3; color:#9D174D; }
.b-rare       { background:#EDE9FE; color:#7C3AED; }
.b-premium    { background:#FEF9C3; color:#B45309; }
.b-bestseller { background:#FEE2E2; color:#DC2626; }
.b-fun        { background:#E9F0FE; color:#2563EB; }
.b-sale       { background:#FEE2E2; color:#DC2626; }
.b-essential  { background:#CFFAFE; color:#0E7490; }
.unavail-chip { position: absolute; bottom: 0.7rem; left: 0.7rem; font-size: 0.62rem; font-weight: 900; text-transform: uppercase; padding: 0.18rem 0.6rem; border-radius: 50px; background: rgba(45,36,30,0.7); color: white; }
.p-card-body { padding: 0.9rem; flex: 1; display: flex; flex-direction: column; gap: 0.25rem; }
.p-category { font-size: 0.67rem; font-weight: 900; color: var(--orange); text-transform: uppercase; letter-spacing: 0.1em; }
.p-name { font-size: 0.92rem; font-weight: 800; color: var(--brown); line-height: 1.3; }
.p-desc { font-size: 0.75rem; color: var(--brown-muted); line-height: 1.55; flex: 1; margin-top: 0.15rem; }
.p-footer { display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; margin-top: 0.6rem; }
.p-price { font-family: var(--serif); font-size: 1.05rem; color: var(--brown); }
.add-to-cart { display: flex; align-items: center; gap: 0.3rem; background: var(--orange); color: white; border: none; padding: 0.42rem 0.85rem; border-radius: 50px; font-size: 0.75rem; font-weight: 800; cursor: pointer; white-space: nowrap; transition: all 0.18s; }
.add-to-cart:hover { background: var(--orange-dark); transform: scale(1.04); }
.add-to-cart:disabled { background: #C9BCB2; cursor: not-allowed; transform: none; }
.add-to-cart.in-cart { background: var(--brown); }
.add-to-cart.in-cart:hover { background: #1a1410; }

/* ── EMPTY STATE ── */
.empty-shop { text-align: center; padding: 4rem 2rem; }
.empty-shop .big-emoji { font-size: 4rem; display: block; margin-bottom: 1rem; opacity: 0.4; }
.empty-shop h3 { font-size: 1.1rem; font-weight: 800; color: var(--brown); margin-bottom: 0.4rem; }
.empty-shop p { font-size: 0.85rem; color: var(--brown-muted); }

/* ── CART OVERLAY + DRAWER ── */
.c-overlay { position: fixed; inset: 0; z-index: 200; background: rgba(45,36,30,0.45); backdrop-filter: blur(4px); opacity: 0; pointer-events: none; transition: opacity 0.3s; }
.c-overlay.open { opacity: 1; pointer-events: all; }
.c-drawer { position: fixed; top: 0; right: 0; bottom: 0; z-index: 201; width: 100%; max-width: 400px; background: var(--white); display: flex; flex-direction: column; transform: translateX(100%); transition: transform 0.35s cubic-bezier(0.22,1,0.36,1); box-shadow: -8px 0 40px rgba(45,36,30,0.12); }
.c-drawer.open { transform: translateX(0); }
.c-head { padding: 1.35rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.c-head h2 { font-family: var(--serif); font-size: 1.4rem; color: var(--brown); display: flex; align-items: center; gap: 0.5rem; }
.c-close { width: 36px; height: 36px; border-radius: 50%; border: none; background: var(--cream); color: var(--brown); font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.15s; }
.c-close:hover { background: var(--border); }
.c-list { flex: 1; overflow-y: auto; padding: 1rem; scrollbar-width: thin; scrollbar-color: var(--border) transparent; }
.c-list::-webkit-scrollbar { width: 4px; }
.c-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
.c-empty { text-align: center; padding: 3rem 1rem; }
.c-empty .ce { font-size: 3.5rem; display: block; margin-bottom: 1rem; opacity: 0.45; }
.c-empty p { font-size: 0.85rem; color: var(--brown-muted); font-weight: 600; line-height: 1.6; }
.c-item { display: flex; align-items: center; gap: 0.85rem; padding: 0.9rem; border-radius: var(--radius-md); border: 1px solid var(--border); background: var(--cream); margin-bottom: 0.6rem; transition: background 0.15s; }
.c-item:hover { background: var(--cream-mid); }
.c-emoji { width: 46px; height: 46px; flex-shrink: 0; background: var(--white); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.7rem; border: 1px solid var(--border); }
.c-info { flex: 1; min-width: 0; }
.c-iname { font-size: 0.82rem; font-weight: 800; color: var(--brown); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.c-icat  { font-size: 0.67rem; font-weight: 800; color: var(--orange); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 0.1rem; }
.c-iprice { font-size: 0.82rem; font-weight: 800; color: var(--brown); margin-top: 0.2rem; }
.qty-wrap { display: flex; align-items: center; gap: 0.35rem; }
.q-btn { width: 26px; height: 26px; border-radius: 0.5rem; border: 1.5px solid var(--border-mid); background: var(--white); font-size: 1rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--brown); transition: all 0.15s; line-height: 1; }
.q-btn:hover { background: var(--orange); color: white; border-color: var(--orange); }
.q-num { font-size: 0.85rem; font-weight: 900; width: 22px; text-align: center; }
.c-del { background: none; border: none; cursor: pointer; color: var(--brown-muted); font-size: 0.95rem; padding: 0.3rem; border-radius: 0.5rem; transition: all 0.15s; flex-shrink: 0; }
.c-del:hover { color: var(--red); background: #FEE2E2; }
.c-foot { padding: 1.15rem; border-top: 1px solid var(--border); }
.c-summary { background: var(--cream); border-radius: var(--radius-md); padding: 0.9rem; margin-bottom: 0.9rem; }
.c-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.82rem; font-weight: 600; margin-bottom: 0.45rem; }
.c-row:last-child { margin-bottom: 0; }
.c-row .lbl { color: var(--brown-muted); }
.c-row.total { font-size: 1rem; font-weight: 900; color: var(--brown); border-top: 1px solid var(--border-mid); padding-top: 0.5rem; margin-top: 0.25rem; }
.c-row .delivery-note { font-size: 0.72rem; color: var(--green); font-weight: 700; }
.checkout-btn { width: 100%; padding: 0.9rem; background: var(--orange); color: white; border: none; border-radius: 50px; font-size: 0.92rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 6px 20px var(--orange-glow); transition: background 0.2s, transform 0.15s, box-shadow 0.2s; }
.checkout-btn:hover { background: var(--orange-dark); transform: translateY(-1px); box-shadow: 0 8px 26px var(--orange-glow); }
.checkout-btn:disabled { background: #C9BCB2; cursor: not-allowed; transform: none; box-shadow: none; }

/* ── TOAST ── */
.shop-toast { position: fixed; bottom: 1.75rem; left: 50%; transform: translateX(-50%) translateY(90px); background: var(--brown); color: white; padding: 0.7rem 1.4rem; border-radius: 50px; font-size: 0.85rem; font-weight: 700; z-index: 400; display: flex; align-items: center; gap: 0.5rem; box-shadow: var(--shadow-lg); white-space: nowrap; transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), opacity 0.3s; pointer-events: none; opacity: 0; }
.shop-toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }

/* ════════════════════════════════════════════════════
   ORDER CONFIRMATION MODAL — Styles
════════════════════════════════════════════════════ */
.order-confirm-overlay {
    position: fixed; inset: 0; z-index: 500;
    background: rgba(45,36,30,0.6); backdrop-filter: blur(6px);
    display: none; align-items: center; justify-content: center; padding: 1.25rem;
}
.order-confirm-overlay.open { display: flex; }

.order-confirm-modal {
    background: var(--white);
    border-radius: 2rem;
    width: 100%; max-width: 520px; max-height: 92vh;
    overflow-y: auto; overflow-x: hidden;
    box-shadow: 0 28px 80px rgba(45,36,30,0.22);
    animation: ocmIn 0.38s cubic-bezier(0.22,1,0.36,1);
    scrollbar-width: thin; scrollbar-color: var(--border) transparent;
}
.order-confirm-modal::-webkit-scrollbar { width: 4px; }
.order-confirm-modal::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
@keyframes ocmIn {
    from { opacity: 0; transform: translateY(28px) scale(0.96); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* Success banner at top */
.ocm-banner {
    background: linear-gradient(135deg, #2D241E 0%, #4A3020 100%);
    padding: 2rem 1.75rem 1.5rem;
    text-align: center; position: relative;
}
.ocm-confetti-emoji {
    font-size: 3rem; display: block; margin-bottom: 0.65rem;
    animation: ocmBounce 0.6s cubic-bezier(0.22,1,0.36,1) 0.2s both;
}
@keyframes ocmBounce {
    from { transform: scale(0.4) rotate(-15deg); opacity: 0; }
    to   { transform: scale(1) rotate(0deg); opacity: 1; }
}
.ocm-banner h2 {
    font-family: var(--serif); font-size: 1.75rem; color: white;
    margin-bottom: 0.35rem;
}
.ocm-banner h2 em { color: var(--orange); font-style: normal; }
.ocm-banner p { color: rgba(255,255,255,0.65); font-size: 0.875rem; }

/* Order ID pill */
.ocm-order-id-wrap {
    display: flex; align-items: center; justify-content: center; gap: 0.6rem;
    background: rgba(230,138,57,0.18); border: 1.5px solid rgba(230,138,57,0.4);
    border-radius: 50px; padding: 0.55rem 1.25rem;
    margin: 1rem auto 0; width: fit-content;
}
.ocm-order-id-label { font-size: 0.7rem; font-weight: 900; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.12em; }
.ocm-order-id-value { font-family: var(--serif); font-size: 1.25rem; color: var(--orange); font-weight: 700; letter-spacing: 0.04em; }
.ocm-copy-btn {
    background: none; border: none; cursor: pointer;
    color: rgba(255,255,255,0.5); font-size: 0.9rem; padding: 0.1rem;
    transition: color 0.15s;
}
.ocm-copy-btn:hover { color: var(--orange); }

/* Body section */
.ocm-body { padding: 1.5rem 1.75rem 1.75rem; }

/* Section header */
.ocm-section-lbl {
    font-size: 0.67rem; font-weight: 900; text-transform: uppercase;
    letter-spacing: 0.14em; color: var(--brown-muted);
    margin-bottom: 0.75rem; margin-top: 1.25rem;
    display: flex; align-items: center; gap: 0.4rem;
}
.ocm-section-lbl:first-child { margin-top: 0; }

/* Items list */
.ocm-items { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 0.25rem; }
.ocm-item {
    display: flex; align-items: center; gap: 0.75rem;
    background: var(--cream); border: 1px solid var(--border);
    border-radius: var(--radius-md); padding: 0.7rem 0.9rem;
}
.ocm-item-em { font-size: 1.6rem; flex-shrink: 0; }
.ocm-item-info { flex: 1; min-width: 0; }
.ocm-item-name { font-size: 0.84rem; font-weight: 800; color: var(--brown); }
.ocm-item-cat  { font-size: 0.67rem; font-weight: 800; color: var(--orange); text-transform: uppercase; letter-spacing: 0.08em; }
.ocm-item-booking { font-size: 0.68rem; color: var(--brown-muted); margin-top: 0.1rem; }
.ocm-item-right { text-align: right; flex-shrink: 0; }
.ocm-item-qty   { font-size: 0.7rem; color: var(--brown-muted); font-weight: 600; }
.ocm-item-price { font-family: var(--serif); font-size: 0.95rem; color: var(--brown); }

/* Summary box */
.ocm-summary {
    background: var(--cream); border: 1px solid var(--border);
    border-radius: var(--radius-md); padding: 0.9rem 1rem;
}
.ocm-sum-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.82rem; font-weight: 600; padding: 0.25rem 0; }
.ocm-sum-row .lbl { color: var(--brown-muted); }
.ocm-sum-row.total {
    font-size: 1rem; font-weight: 900; color: var(--brown);
    border-top: 1px dashed var(--border-mid); margin-top: 0.35rem; padding-top: 0.55rem;
}
.ocm-sum-row.total .val { color: var(--orange); }

/* Info grid (delivery + payment) */
.ocm-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.65rem; }
.ocm-info-cell {
    background: var(--cream); border: 1px solid var(--border);
    border-radius: var(--radius-md); padding: 0.8rem 0.9rem;
}
.ocm-info-cell .ic-lbl { font-size: 0.65rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.12em; color: var(--brown-muted); margin-bottom: 0.3rem; }
.ocm-info-cell .ic-val { font-size: 0.84rem; font-weight: 700; color: var(--brown); line-height: 1.4; }

/* Notice strip */
.ocm-notice {
    background: #FFF4E6; border: 1.5px solid #F4C98A;
    border-radius: var(--radius-md); padding: 0.85rem 1rem;
    font-size: 0.78rem; color: var(--brown-sub); line-height: 1.6;
    display: flex; gap: 0.6rem; align-items: flex-start;
}
.ocm-notice .notice-icon { font-size: 1.1rem; flex-shrink: 0; margin-top: 0.05rem; }

/* Action buttons */
.ocm-actions { display: flex; flex-direction: column; gap: 0.6rem; margin-top: 1.25rem; }
.ocm-btn-primary {
    width: 100%; padding: 0.9rem; background: var(--orange); color: white;
    border: none; border-radius: 50px; font-family: inherit; font-size: 0.92rem;
    font-weight: 800; cursor: pointer; display: flex; align-items: center;
    justify-content: center; gap: 0.5rem;
    box-shadow: 0 6px 20px var(--orange-glow);
    transition: background 0.2s, transform 0.15s;
}
.ocm-btn-primary:hover { background: var(--orange-dark); transform: translateY(-1px); }
.ocm-btn-secondary {
    width: 100%; padding: 0.75rem; background: transparent; color: var(--brown-muted);
    border: 2px solid var(--border-mid); border-radius: 50px; font-family: inherit;
    font-size: 0.84rem; font-weight: 700; cursor: pointer;
    transition: border-color 0.15s, color 0.15s;
}
.ocm-btn-secondary:hover { border-color: var(--brown-muted); color: var(--brown); }

/* Date/time stamp in banner */
.ocm-timestamp {
    font-size: 0.7rem; color: rgba(255,255,255,0.4);
    margin-top: 0.5rem; letter-spacing: 0.04em;
}

/* ═══════════════════════════════════════════════════════════
   PET MATCHER QUIZ MODAL
═══════════════════════════════════════════════════════════ */
.quiz-overlay {
    position: fixed; inset: 0; z-index: 300;
    background: rgba(45,36,30,0.55); backdrop-filter: blur(6px);
    opacity: 0; pointer-events: none;
    transition: opacity 0.3s;
    display: flex; align-items: center; justify-content: center; padding: 1.25rem;
}
.quiz-overlay.open { opacity: 1; pointer-events: all; }

.quiz-modal {
    background: var(--white);
    border-radius: 2rem;
    width: 100%; max-width: 660px; max-height: 90vh;
    overflow-y: auto; overflow-x: hidden;
    box-shadow: 0 24px 70px rgba(45,36,30,0.22);
    transform: translateY(24px) scale(0.97);
    transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
    position: relative;
    scrollbar-width: thin; scrollbar-color: var(--border) transparent;
}
.quiz-modal::-webkit-scrollbar { width: 4px; }
.quiz-modal::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
.quiz-overlay.open .quiz-modal { transform: translateY(0) scale(1); }

.qm-head {
    background: linear-gradient(135deg, #2D241E 0%, #4A3020 100%);
    padding: 1.5rem 1.75rem 1.25rem;
    display: flex; align-items: flex-start; justify-content: space-between;
    position: sticky; top: 0; z-index: 10;
}
.qm-head-text .qm-label {
    font-size: 0.68rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.12em;
    color: var(--orange); margin-bottom: 0.3rem;
}
.qm-head-text h3 { font-family: var(--serif); font-size: 1.4rem; color: white; line-height: 1.2; }
.qm-head-text h3 em { color: var(--orange); font-style: normal; }
.qm-x {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,0.12); border: none; color: rgba(255,255,255,0.7);
    font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background 0.15s, color 0.15s; flex-shrink: 0; margin-left: 1rem;
}
.qm-x:hover { background: rgba(255,255,255,0.22); color: white; }

.qm-body { padding: 1.5rem 1.75rem 1.75rem; }

.qm-progress-wrap { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.75rem; }
.qm-progress-track { flex: 1; height: 5px; background: var(--border); border-radius: 99px; overflow: hidden; }
.qm-progress-fill { height: 100%; background: linear-gradient(90deg, var(--orange), #F4A35A); border-radius: 99px; transition: width 0.5s cubic-bezier(0.4,0,0.2,1); }
.qm-step-lbl { font-size: 0.72rem; font-weight: 700; color: var(--brown-muted); white-space: nowrap; flex-shrink: 0; }

.qm-step { display: none; animation: qmStepIn 0.32s ease; }
.qm-step.active { display: block; }
@keyframes qmStepIn { from { opacity:0; transform:translateX(14px); } to { opacity:1; transform:none; } }

.qm-question { font-family: var(--serif); font-size: 1.25rem; color: var(--brown); margin-bottom: 0.3rem; line-height: 1.3; }
.qm-sub { font-size: 0.82rem; color: var(--brown-muted); margin-bottom: 1.4rem; }

.qm-options { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.7rem; margin-bottom: 1.5rem; }
.qm-opt {
    border: 2px solid var(--border); border-radius: 1.1rem;
    padding: 1rem 0.75rem; cursor: pointer;
    display: flex; flex-direction: column; align-items: center; gap: 0.45rem;
    text-align: center; background: var(--cream);
    transition: border-color 0.18s, background 0.18s, transform 0.16s, box-shadow 0.16s;
    user-select: none; -webkit-user-select: none;
}
.qm-opt:hover { border-color: #F4A35A; background: #FFFBF6; transform: translateY(-2px); box-shadow: 0 6px 18px rgba(230,138,57,0.10); }
.qm-opt.selected { border-color: var(--orange); background: #FFF4E6; box-shadow: 0 0 0 3px rgba(230,138,57,0.14); transform: translateY(-2px); }
.qm-opt .oo-em { font-size: 1.8rem; line-height: 1; }
.qm-opt .oo-lbl { font-size: 0.82rem; font-weight: 700; color: var(--brown); line-height: 1.25; }
.qm-opt .oo-sub { font-size: 0.68rem; color: var(--brown-muted); line-height: 1.4; }
.qm-opt .oo-chk { width: 18px; height: 18px; border-radius: 50%; background: var(--orange); color: white; font-size: 0.65rem; font-weight: 900; display: none; align-items: center; justify-content: center; }
.qm-opt.selected .oo-chk { display: flex; }

.qm-nav { display: flex; align-items: center; gap: 0.75rem; }
.qm-back { background: none; border: 2px solid var(--border-mid); border-radius: 50px; padding: 0.6rem 1.25rem; font-family: inherit; font-size: 0.84rem; font-weight: 700; color: var(--brown-muted); cursor: pointer; transition: border-color 0.15s, color 0.15s; }
.qm-back:hover { border-color: var(--brown-muted); color: var(--brown); }
.qm-next { margin-left: auto; background: var(--orange); color: white; border: none; border-radius: 50px; padding: 0.65rem 1.75rem; font-family: inherit; font-size: 0.9rem; font-weight: 800; cursor: pointer; transition: background 0.18s, transform 0.14s; }
.qm-next:hover:not(:disabled) { background: var(--orange-dark); transform: scale(1.03); }
.qm-next:disabled { opacity: 0.35; cursor: not-allowed; transform: none; }

#qmResult { display: none; animation: qmStepIn 0.35s ease; }
#qmResult.active { display: block; }

.qmr-header { text-align: center; margin-bottom: 1.5rem; }
.qmr-emoji { font-size: 3rem; line-height: 1; margin-bottom: 0.5rem; display: block; }
.qmr-title { font-family: var(--serif); font-size: 1.5rem; color: var(--brown); margin-bottom: 0.35rem; }
.qmr-desc { font-size: 0.85rem; color: var(--brown-muted); max-width: 400px; margin: 0 auto 0.9rem; }
.qmr-reason {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: #E9F7F2; color: var(--green); border-radius: 99px;
    padding: 0.3rem 0.85rem; font-size: 0.72rem; font-weight: 700;
}

.qmr-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.85rem; margin: 1.25rem 0; }
.qmr-card {
    background: var(--cream); border: 2px solid var(--border);
    border-radius: var(--radius-lg); padding: 1.1rem 0.9rem;
    display: flex; flex-direction: column; align-items: center;
    gap: 0.4rem; text-align: center; position: relative; overflow: hidden;
    transition: transform 0.18s, box-shadow 0.18s, border-color 0.18s;
}
.qmr-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--border-mid); }
.qmr-card.best { border-color: var(--orange); }
.qmr-card .qrc-fit {
    position: absolute; top: 0.6rem; right: 0.6rem;
    font-size: 0.58rem; font-weight: 900; text-transform: uppercase;
    padding: 0.15rem 0.5rem; border-radius: 50px;
    background: #FEE2E2; color: #DC2626;
}
.qmr-card.best .qrc-fit { background: #FEF9C3; color: #B45309; }
.qmr-card .qrc-em { font-size: 2.5rem; line-height: 1; }
.qmr-card .qrc-cat { font-size: 0.67rem; font-weight: 900; color: var(--orange); text-transform: uppercase; letter-spacing: 0.08em; }
.qmr-card .qrc-name { font-size: 0.88rem; font-weight: 800; color: var(--brown); line-height: 1.25; }
.qmr-card .qrc-price { font-family: var(--serif); font-size: 0.92rem; color: var(--brown); }
.qmr-card .qrc-why { font-size: 0.7rem; color: var(--brown-muted); line-height: 1.45; }

.qrc-btns { display: flex; gap: 0.4rem; margin-top: 0.35rem; width: 100%; }
.qrc-add {
    flex: 1; background: var(--orange); color: white; border: none; border-radius: 50px;
    padding: 0.4rem 0.5rem; font-family: inherit; font-size: 0.72rem; font-weight: 800;
    cursor: pointer; transition: background 0.15s; white-space: nowrap;
}
.qrc-add:hover { background: var(--orange-dark); }
.qrc-add.in-cart { background: var(--brown); }
.qrc-view {
    background: var(--cream-mid); color: var(--brown-sub); border: 1.5px solid var(--border-mid);
    border-radius: 50px; padding: 0.4rem 0.6rem; font-family: inherit; font-size: 0.72rem;
    font-weight: 700; cursor: pointer; transition: all 0.15s; white-space: nowrap;
}
.qrc-view:hover { border-color: var(--orange); color: var(--orange); }

.qmr-actions { display: flex; gap: 0.75rem; margin-top: 0.5rem; }
.qmr-retake {
    flex: 1; background: none; border: 2px solid var(--border-mid); border-radius: 50px;
    padding: 0.65rem; font-family: inherit; font-size: 0.84rem; font-weight: 700;
    color: var(--brown-muted); cursor: pointer; transition: all 0.15s;
}
.qmr-retake:hover { border-color: var(--orange); color: var(--orange); }
.qmr-show-shop {
    flex: 1; background: var(--brown); color: white; border: none; border-radius: 50px;
    padding: 0.65rem; font-family: inherit; font-size: 0.84rem; font-weight: 800;
    cursor: pointer; transition: background 0.15s;
}
.qmr-show-shop:hover { background: #1a1410; }

#qmConfetti { position: absolute; inset: 0; pointer-events: none; z-index: 5; border-radius: 2rem; }

/* ── SERVICE BOOKING MODAL ── */
/* ── SERVICE BOOKING MODAL ── */
.booking-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.65);
    z-index: 9999;
    display: flex; /* Changed to flex for centering visibility testing */
    align-items: center;
    justify-content: center;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.booking-modal {
    width: 100%;
    max-width: 440px;
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
    animation: bookingFade .25s ease;
}

@keyframes bookingFade {
    from {
        opacity: 0;
        transform: translateY(20px) scale(.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.booking-head {
    padding: 24px;
    background: linear-gradient(135deg, #E68A39, #CF7529);
    color: white;
}

.booking-head h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.booking-head p {
    margin: 6px 0 0 0;
    opacity: .9;
    font-size: .9rem;
}

/* ── FORM BODY & FIELDS STYLING ── */
.booking-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    background-color: #fff;
}

.booking-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.booking-field label {
    font-weight: 600;
    color: #4A3E3D;
    font-size: 0.95rem;
}

/* Styled both Date and Time Inputs uniformally */
.booking-field input[type="date"],
.booking-field input[type="time"] {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #EAE5E2;
    border-radius: 12px;
    font-size: 1rem;
    color: #333;
    background-color: #FAFAFA;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    font-family: inherit;
}

.booking-field input[type="date"]:focus,
.booking-field input[type="time"]:focus {
    border-color: #E68A39;
    box-shadow: 0 0 0 4px rgba(230, 138, 57, 0.15);
    background-color: #FFF;
}

/* ── BUTTONS & ACTIONS ── */
.booking-actions {
    display: flex;
    gap: 12px;
    margin-top: 8px;
}

.booking-cancel,
.booking-confirm {
    flex: 1;
    padding: 14px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.booking-cancel {
    background-color: #F3EFEF;
    color: #665E5C;
}

.booking-cancel:hover {
    background-color: #EAE5E2;
    color: #4A3E3D;
}

.booking-confirm {
    background: linear-gradient(135deg, #E68A39, #CF7529);
    color: white;
    box-shadow: 0 4px 12px rgba(230, 138, 57, 0.25);
}

.booking-confirm:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(230, 138, 57, 0.35);
}

.booking-confirm:active {
    transform: translateY(1px);
    box-shadow: 0 2px 6px rgba(230, 138, 57, 0.2);
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) { .shop-layout { grid-template-columns: 1fr; } .shop-sidebar { display: none; } }
@media (max-width: 768px) {
    .nav-links-shop { display: none; } .nav-hamburger-shop { display: flex; }
    .search-field { max-width: none; flex: 1 1 100%; }
    .sort-pick, .result-count { flex: 1; }
    .result-count { margin-left: 0; flex: 0 0 auto; }
    .shop-layout { padding: 1.2rem 1rem; }
    .products-grid { grid-template-columns: repeat(auto-fill, minmax(155px, 1fr)); gap: 0.75rem; }
    .p-card-img { font-size: 3rem; }
    .c-drawer { max-width: 100%; }
    .qm-options { grid-template-columns: repeat(3, 1fr); }
    .qmr-grid { grid-template-columns: repeat(2, 1fr); }
    .ocm-info-grid { grid-template-columns: 1fr; }
}
@media (max-width: 520px) {
    .qm-options { grid-template-columns: 1fr 1fr; }
    .qmr-grid { grid-template-columns: 1fr 1fr; }
    .qm-body { padding: 1.25rem 1.1rem 1.5rem; }
    .qmr-actions { flex-direction: column; }
    .ocm-body { padding: 1.25rem 1.1rem 1.5rem; }
}
@media (max-width: 380px) {
    .qm-options { grid-template-columns: 1fr; }
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
        <button class="quiz-hero-cta" onclick="openQuiz()">
            <span class="qhc-icon">🐾</span>
            Not sure which pet? Take the quiz!
            <span class="qhc-arrow">→</span>
        </button>
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
    <div class="pills-inner" id="pillsContainer"></div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     SHOP LAYOUT
═══════════════════════════════════════════════════════════ --}}
<div class="shop-layout">

    <aside class="shop-sidebar">
        <div class="sidebar-box" style="padding: 0.85rem;">
            <button class="sidebar-quiz-btn" onclick="openQuiz()">
                <span class="sqb-icon">🐾</span>
                <div class="sqb-text">
                    <strong>Pet Matcher Quiz</strong>
                    <span>Find your perfect match in 3 steps</span>
                </div>
            </button>
        </div>

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
            <input type="range" id="priceSlider" min="0" max="50000" step="500" value="50000" oninput="onPriceChange()">
        </div>

        <button class="clear-all-btn" onclick="clearFilters()">✕ Clear All Filters</button>
    </aside>

    <div class="shop-main">
        <div class="quiz-active-banner" id="quizActiveBanner">
            <span class="qab-emoji" id="qabEmoji">🐾</span>
            <div class="qab-text">
                <strong id="qabTitle">Quiz Results Active</strong>
                <span id="qabSub">Matching pets are highlighted below</span>
            </div>
            <button class="qab-clear" onclick="clearQuizFilter()">✕ Clear</button>
            <button class="qab-redo"  onclick="openQuiz()">Redo Quiz</button>
        </div>

        <div class="products-grid" id="productsGrid"></div>
        <div class="empty-shop" id="emptyShop" style="display:none;">
            <span class="big-emoji">🔍</span>
            <h3>No results found</h3>
            <p>Try a different category, keyword, or adjust the price range.</p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     ORDER CONFIRMATION MODAL
     Shown after processFinalOrder() — z-index: 500
═══════════════════════════════════════════════════════════ --}}
<div class="order-confirm-overlay" id="orderConfirmOverlay">
    <div class="order-confirm-modal" id="orderConfirmModal">

        {{-- ── Top success banner ── --}}
        <div class="ocm-banner">
            <span class="ocm-confetti-emoji">🎉</span>
            <h2>Order <em>Confirmed!</em></h2>
            <p>Thank you for shopping with PawHaven. Your order is being processed.</p>

            <div class="ocm-order-id-wrap">
                <span class="ocm-order-id-label">Order ID</span>
                <span class="ocm-order-id-value" id="ocmOrderId">—</span>
                <button class="ocm-copy-btn" onclick="copyOrderId()" title="Copy Order ID">📋</button>
            </div>
            <div class="ocm-timestamp" id="ocmTimestamp"></div>
        </div>

        {{-- ── Body ── --}}
        <div class="ocm-body">

            {{-- Items ordered --}}
            <div class="ocm-section-lbl">🛍️ Items Ordered</div>
            <div class="ocm-items" id="ocmItemsList"></div>

            {{-- Order summary --}}
            <div class="ocm-section-lbl">💰 Order Summary</div>
            <div class="ocm-summary">
                <div class="ocm-sum-row">
                    <span class="lbl">Subtotal</span>
                    <span class="val" id="ocmSubtotal">₱0</span>
                </div>
                <div class="ocm-sum-row">
                    <span class="lbl">Amount Due Now</span>
                    <span class="val" id="ocmAmountDue" style="color:var(--green);font-weight:800;">₱0</span>
                </div>
                <div class="ocm-sum-row">
                    <span class="lbl">Payment Method</span>
                    <span class="val" id="ocmPayMethod">—</span>
                </div>
                <div class="ocm-sum-row total">
                    <span>Order Total</span>
                    <span class="val" id="ocmTotal">₱0</span>
                </div>
            </div>

            {{-- Delivery + Contact --}}
            <div class="ocm-section-lbl">📍 Delivery & Contact</div>
            <div class="ocm-info-grid">
                <div class="ocm-info-cell">
                    <div class="ic-lbl">Delivery Address</div>
                    <div class="ic-val" id="ocmAddress">—</div>
                </div>
                <div class="ocm-info-cell">
                    <div class="ic-lbl">Contact Number</div>
                    <div class="ic-val" id="ocmPhone">—</div>
                </div>
            </div>

            {{-- Note --}}
            <div class="ocm-notice" style="margin-top:1rem;">
                <span class="notice-icon">📌</span>
                <span>Please save your Order ID: <strong id="ocmOrderIdInline">—</strong>. You can use it together with your phone number to track your order status anytime. Our team will reach out to you shortly to confirm your delivery details.</span>
            </div>

            {{-- Actions --}}
            <div class="ocm-actions">
                <button class="ocm-btn-primary" onclick="closeOrderConfirm()">
                    🐾 Continue Shopping
                </button>
                <button class="ocm-btn-secondary" onclick="closeOrderConfirm()">
                    Close
                </button>
            </div>

        </div>{{-- /.ocm-body --}}
    </div>{{-- /.order-confirm-modal --}}
</div>{{-- /.order-confirm-overlay --}}

{{-- ═══════════════════════════════════════════════════════════
     PET MATCHER QUIZ MODAL
═══════════════════════════════════════════════════════════ --}}
<div class="quiz-overlay" id="quizOverlay" onclick="handleQuizOverlayClick(event)">
    <div class="quiz-modal" id="quizModal">
        <canvas id="qmConfetti"></canvas>

        <div class="qm-head">
            <div class="qm-head-text">
                <div class="qm-label">🐾 Pet Matcher</div>
                <h3>Find Your <em>Perfect</em> Pet</h3>
            </div>
            <button class="qm-x" onclick="closeQuiz()">✕</button>
        </div>

        <div class="qm-body">

            <div class="qm-progress-wrap" id="qmProgressWrap">
                <div class="qm-progress-track">
                    <div class="qm-progress-fill" id="qmProgressFill" style="width:33%"></div>
                </div>
                <span class="qm-step-lbl" id="qmStepLbl">Step 1 of 3</span>
            </div>

            {{-- STEP 1 --}}
            <div class="qm-step active" id="qmStep1">
                <p class="qm-question">🏠 How much living space do you have?</p>
                <p class="qm-sub">Your home environment matters a lot for a pet's wellbeing.</p>
                <div class="qm-options">
                    <div class="qm-opt" data-step="1" data-val="small" onclick="qmPick(this)">
                        <span class="oo-em">🏢</span>
                        <span class="oo-lbl">Small Apartment</span>
                        <span class="oo-sub">Studio/1BR, limited outdoor access</span>
                        <span class="oo-chk">✓</span>
                    </div>
                    <div class="qm-opt" data-step="1" data-val="medium" onclick="qmPick(this)">
                        <span class="oo-em">🏠</span>
                        <span class="oo-lbl">Medium House</span>
                        <span class="oo-sub">2–3BR, small yard or patio</span>
                        <span class="oo-chk">✓</span>
                    </div>
                    <div class="qm-opt" data-step="1" data-val="large" onclick="qmPick(this)">
                        <span class="oo-em">🏡</span>
                        <span class="oo-lbl">Large House</span>
                        <span class="oo-sub">Spacious yard, room to roam</span>
                        <span class="oo-chk">✓</span>
                    </div>
                </div>
                <div class="qm-nav">
                    <button class="qm-next" id="qmNext1" disabled onclick="qmGoStep(2)">Next →</button>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div class="qm-step" id="qmStep2">
                <p class="qm-question">🏃 How active is your lifestyle?</p>
                <p class="qm-sub">This helps us match your energy with the right companion.</p>
                <div class="qm-options">
                    <div class="qm-opt" data-step="2" data-val="low" onclick="qmPick(this)">
                        <span class="oo-em">🛋️</span>
                        <span class="oo-lbl">Couch Lover</span>
                        <span class="oo-sub">I prefer relaxing at home</span>
                        <span class="oo-chk">✓</span>
                    </div>
                    <div class="qm-opt" data-step="2" data-val="medium" onclick="qmPick(this)">
                        <span class="oo-em">🚶</span>
                        <span class="oo-lbl">Moderately Active</span>
                        <span class="oo-sub">Regular walks, casual outdoors</span>
                        <span class="oo-chk">✓</span>
                    </div>
                    <div class="qm-opt" data-step="2" data-val="high" onclick="qmPick(this)">
                        <span class="oo-em">🏋️</span>
                        <span class="oo-lbl">Very Active</span>
                        <span class="oo-sub">Daily runs, hikes, adventures</span>
                        <span class="oo-chk">✓</span>
                    </div>
                </div>
                <div class="qm-nav">
                    <button class="qm-back" onclick="qmGoStep(1)">← Back</button>
                    <button class="qm-next" id="qmNext2" disabled onclick="qmGoStep(3)">Next →</button>
                </div>
            </div>

            {{-- STEP 3 --}}
            <div class="qm-step" id="qmStep3">
                <p class="qm-question">👨‍👩‍👧 What's your family situation?</p>
                <p class="qm-sub">Some pets are better suited to homes with young children.</p>
                <div class="qm-options">
                    <div class="qm-opt" data-step="3" data-val="no-kids" onclick="qmPick(this)">
                        <span class="oo-em">🧑</span>
                        <span class="oo-lbl">No Kids</span>
                        <span class="oo-sub">Adults-only household</span>
                        <span class="oo-chk">✓</span>
                    </div>
                    <div class="qm-opt" data-step="3" data-val="older-kids" onclick="qmPick(this)">
                        <span class="oo-em">👦</span>
                        <span class="oo-lbl">Older Kids</span>
                        <span class="oo-sub">Kids 8+ who interact responsibly</span>
                        <span class="oo-chk">✓</span>
                    </div>
                    <div class="qm-opt" data-step="3" data-val="young-kids" onclick="qmPick(this)">
                        <span class="oo-em">👶</span>
                        <span class="oo-lbl">Young Kids</span>
                        <span class="oo-sub">Toddlers or under 8 at home</span>
                        <span class="oo-chk">✓</span>
                    </div>
                </div>
                <div class="qm-nav">
                    <button class="qm-back" onclick="qmGoStep(2)">← Back</button>
                    <button class="qm-next" id="qmNext3" disabled onclick="qmShowResult()">See My Match 🐾</button>
                </div>
            </div>

            {{-- RESULT --}}
            <div id="qmResult">
                <div class="qmr-header">
                    <span class="qmr-emoji" id="qmrEmoji"></span>
                    <div class="qmr-title" id="qmrTitle"></div>
                    <p class="qmr-desc" id="qmrDesc"></p>
                    <span class="qmr-reason" id="qmrReason"></span>
                </div>
                <div class="qmr-grid" id="qmrGrid"></div>
                <div class="qmr-actions">
                    <button class="qmr-retake"    onclick="qmRetake()">↩ Retake Quiz</button>
                    <button class="qmr-show-shop" onclick="qmShowInShop()">Show in Shop 🐾</button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     CART OVERLAY + DRAWER
═══════════════════════════════════════════════════════════ --}}
<div class="c-overlay" id="cOverlay" onclick="toggleCart()"></div>

<aside class="c-drawer" id="cDrawer">
    <div class="c-head">
        <h2>🛒 Your Cart</h2>
        <button class="c-close" onclick="toggleCart()">✕</button>
    </div>
    <div class="c-scrollable" style="flex:1;overflow-y:auto;padding:1rem;">
        <div id="cList">
            <div class="c-empty">
                <span class="ce">🛒</span>
                <p>Your cart is empty.<br>Add some pets or supplies to get started!</p>
            </div>
        </div>
        <div class="c-verification" id="verificationSection" style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--border);display:none;">
            <h3 style="font-size:0.9rem;margin-bottom:1rem;font-family:var(--serif);">📍 Delivery Details</h3>
            <div style="margin-bottom:1rem;">
                <label style="font-size:0.75rem;font-weight:800;color:var(--brown-muted);display:block;margin-bottom:0.4rem;">SELECT CITY (CAVITE)</label>
                <select id="citySelect" class="sort-pick" style="width:100%;border-radius:10px;" onchange="updateBarangays()">
                    <option value="">-- Choose City --</option>
                    <option value="GMA">Gen. Mariano Alvarez</option>
                    <option value="Dasmarinas">Dasmariñas</option>
                    <option value="Silang">Silang</option>
                </select>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="font-size:0.75rem;font-weight:800;color:var(--brown-muted);display:block;margin-bottom:0.4rem;">SELECT BARANGAY</label>
                <select id="brgySelect" class="sort-pick" style="width:100%;border-radius:10px;" disabled>
                    <option value="">-- Select City First --</option>
                </select>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="font-size:0.75rem;font-weight:800;color:var(--brown-muted);display:block;margin-bottom:0.4rem;">PH PHONE NUMBER</label>
                <div style="display:flex;gap:5px;">
                    <input type="text" id="phoneInput" placeholder="09123456789" maxlength="11"
                           oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                           style="flex:1;padding:0.6rem;border:2px solid var(--border);border-radius:10px;font-size:0.85rem;">
                    <button onclick="sendMockOTP()" id="otpBtn" class="add-to-cart" style="font-size:0.65rem;padding:0 10px;">Send OTP</button>
                </div>
            </div>
            <div id="otpInputWrap" style="display:none;margin-bottom:1rem;">
                <label style="font-size:0.75rem;font-weight:800;color:var(--brown-muted);display:block;margin-bottom:0.4rem;">ENTER 4-DIGIT CODE</label>
                <input type="text" id="otpCode" maxlength="4" placeholder="0000"
                       style="width:100%;padding:0.6rem;border:2px solid var(--border);border-radius:10px;text-align:center;letter-spacing:5px;font-weight:bold;">
            </div>
        </div>
    </div>
    <div class="c-foot" id="cFoot" style="display:none;border-top:1px solid var(--border);padding:1.15rem;">
        <div class="c-summary">
            <div class="payment-method" style="margin:15px 0;padding:10px;border-top:1px dashed #ddd;">
                <p style="font-weight:600;margin-bottom:8px;font-size:0.9rem;">Payment Method:</p>
                <div style="display:flex;gap:15px;">
                    <label style="cursor:pointer;font-size:0.85rem;"><input type="radio" name="payment" value="cash" checked> Cash</label>
                    <label style="cursor:pointer;font-size:0.85rem;"><input type="radio" name="payment" value="gcash"> GCash</label>
                </div>
            </div>
            <div class="c-row"><span class="lbl">Subtotal</span><span id="cSubtotal">₱0</span></div>
            <div class="c-row"><span class="lbl">Delivery</span><span class="delivery-note">To be arranged</span></div>
            <div class="c-row total"><span>Total</span><span id="cTotal" style="color:var(--orange);">₱0</span></div>
        </div>
        <button class="checkout-btn" onclick="handleCheckout()">Proceed to Checkout 🐾</button>
    </div>
</aside>

{{-- GCash Modal --}}
<div id="gcashModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:9999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;padding:25px;border-radius:15px;max-width:400px;width:100%;text-align:center;position:relative;">
        <button onclick="closeModal('gcashModal')" style="position:absolute;right:15px;top:10px;border:none;background:none;font-size:20px;cursor:pointer;">✕</button>
        <h3 style="color:#007dfe;margin-bottom:5px;">Pay via GCash</h3>
        <p style="font-size:0.85rem;color:#666;">Scan the QR or send to the number below:</p>
        <div style="margin:15px 0;border:1px solid #eee;padding:10px;border-radius:10px;">
            <img src="{{ asset('images/gcash-qr.png') }}" alt="GCash QR" style="width:100%;max-width:200px;">
        </div>
        <div style="background:#f3f7ff;padding:12px;border-radius:8px;margin-bottom:15px;">
            <p style="margin:0;font-size:0.8rem;color:#555;">GCash Number:</p>
            <p style="margin:0;font-weight:bold;font-size:1.2rem;color:#007dfe;">0912 345 6789</p>
            <p style="margin:0;font-size:0.8rem;color:#555;">Name: PAWHAVEN ADMIN</p>
        </div>
        <button onclick="showProofModal()" class="checkout-btn" style="width:100%;background:#007dfe;">I have sent the payment 🐾</button>
    </div>
</div>

{{-- Proof Modal --}}
<div id="proofModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:10000;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;padding:25px;border-radius:15px;max-width:400px;width:100%;position:relative;">
        <button onclick="closeModal('proofModal')" style="position:absolute;right:15px;top:10px;border:none;background:none;font-size:20px;cursor:pointer;">✕</button>
        <h3 style="text-align:center;margin-bottom:10px;">Verification</h3>
        <p style="text-align:center;font-size:0.85rem;color:#666;margin-bottom:20px;">Please provide payment details to confirm your order.</p>
        <div style="margin-bottom:15px;">
            <label style="display:block;font-size:0.85rem;font-weight:600;margin-bottom:5px;">Reference Number</label>
            <input type="text" id="refNum" placeholder="13-digit reference number" maxlength="13"
                   oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                   style="width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;">
        </div>
        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:0.85rem;font-weight:600;margin-bottom:5px;">Screenshot of Receipt</label>
            <input type="file" id="screenshot" accept="image/*" style="width:100%;font-size:0.85rem;">
        </div>
        <button onclick="submitFinalCheckout()" class="checkout-btn" style="width:100%;">Submit & Place Order 🚀</button>
    </div>
</div>

{{-- Warning Modal --}}
<div id="warningModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:20000;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;padding:30px;border-radius:20px;max-width:350px;width:100%;text-align:center;box-shadow:var(--shadow-lg);">
        <div style="font-size:50px;margin-bottom:15px;">⚠️</div>
        <h3 style="color:var(--brown);margin-bottom:10px;">Wait a paw-second!</h3>
        <p id="warningMessage" style="font-size:0.9rem;color:#666;margin-bottom:25px;">Please provide both the reference number and the screenshot of your payment.</p>
        <button onclick="closeModal('warningModal')" class="checkout-btn" style="width:100%;background:var(--orange);">Got it! 🐾</button>
    </div>
</div>

<div class="shop-toast" id="shopToast"></div>

{{-- Service Booking Modal --}}
<div class="shop-toast" id="shopToast"></div>

<div class="booking-overlay" id="bookingOverlay">
    <div class="booking-modal">

        <div class="booking-head">
            <h3 id="bookingServiceTitle">Full Pet Grooming</h3>
            <p>Select your preferred appointment date & time.</p>
        </div>

        <div class="booking-body">

            <div class="booking-field">
                <label for="bookingDate">Select Date</label>
                <input type="date" id="bookingDate">
            </div>

            <div class="booking-field">
                <label for="bookingTime">Preferred Time Slot</label>
                <input type="time" id="bookingTime" class="booking-time-input">
            </div>

            <div class="booking-actions">
                <button class="booking-cancel" onclick="closeBookingModal()">
                    Cancel
                </button>

                <button class="booking-confirm" onclick="confirmServiceBooking()">
                    Confirm Booking 🐾
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════════════════ --}}
<script>
/* ════════════════════════════════════════
   SHOP DATA
════════════════════════════════════════ */
const CATALOG = @json($catalog);

const CAT_GROUPS = {
    'All':     ['All','Dogs','Cats','Birds','Small Pets','Fish','Reptiles','Food','Toys','Accessories','Grooming','Health','Salon','Clinic','Boarding','Training'],
    'pet':     ['All','Dogs','Cats','Birds','Small Pets','Fish','Reptiles'],
    'product': ['All','Food','Toys','Accessories','Grooming','Health'],
    'service': ['All','Salon','Clinic','Boarding','Training']
};
const CAT_EMOJI = {All:'🐾',Dogs:'🐕',Cats:'🐱',Birds:'🦜','Small Pets':'🐹',Fish:'🐠',Reptiles:'🦎',Food:'🍖',Toys:'🎾',Accessories:'🏷️',Grooming:'🪮',Health:'💊',Salon:'✂️',Clinic:'🩺',Boarding:'🏨',Training:'🦮'};

const ADRESS_DATA = {
    'GMA':       ['Poblacion 1','Poblacion 2','San Gabriel','San Jose','Kessel Ville'],
    'Dasmarinas':['Sampaloc 1','Burol','Salitran','Langkaan'],
    'Silang':    ['Bulihan','Iba','Munting Ilog','Tibig']
};

/* ── Shop State ── */
let cart       = [];
let activeCat  = 'All';
let activeType = 'All';
let generatedOTP = null;
let pendingService = null;
let selectedTimeSlot = null;

/* ── Quiz State ── */
const qmAnswers = { 1:null, 2:null, 3:null };
let quizMatchIds = [];

/* ── Last captured checkout snapshot (for the confirm modal) ── */
let lastCheckoutSnapshot = null;

/* ════════════════════════════════════════
   SHOP INIT
════════════════════════════════════════ */
function init() {
    const params   = new URLSearchParams(window.location.search);
    const paramType = params.get('type');
    if (paramType && ['pet','product','service'].includes(paramType)) activeType = paramType;
    syncSidebarUI();
    renderPills();
    updateTypeCounts();
    applyFilters();
}

/* ── Address dropdown ── */
function updateBarangays() {
    const city = document.getElementById('citySelect').value;
    const brgy = document.getElementById('brgySelect');
    brgy.innerHTML = '<option value="">-- Select Barangay --</option>';
    if (city && ADRESS_DATA[city]) {
        brgy.disabled = false;
        ADRESS_DATA[city].forEach(b => brgy.innerHTML += `<option value="${b}">${b}</option>`);
    } else { brgy.disabled = true; }
}

/* ── OTP ── */
function sendMockOTP() {
    const phone = document.getElementById('phoneInput').value;
    if (phone.length !== 11 || !phone.startsWith('09')) { showToast('❌ Enter a valid 11-digit PH number.'); return; }
    generatedOTP = Math.floor(1000 + Math.random() * 9000);
    document.getElementById('otpInputWrap').style.display = 'block';
    alert(`[PawHaven] Your verification code is: ${generatedOTP}`);
    showToast('📟 OTP sent to ' + phone);
}

/* ── Pills ── */
function renderPills() {
    const cats = CAT_GROUPS[activeType] || CAT_GROUPS['All'];
    document.getElementById('pillsContainer').innerHTML = cats.map(c =>
        `<button class="cat-pill ${c===activeCat?'active':''}" onclick="setCategory('${c}')">${CAT_EMOJI[c]||'✨'} ${c}</button>`
    ).join('');
}
function setCategory(cat) { activeCat = cat; renderPills(); applyFilters(); }

/* ── Type filter ── */
function setType(type) {
    activeType = type; activeCat = 'All';
    const url = type==='All' ? window.location.pathname : `${window.location.pathname}?type=${type}`;
    window.history.pushState({}, '', url);
    syncSidebarUI(); renderPills(); applyFilters();
}
function syncSidebarUI() {
    ['All','pet','product','service'].forEach(t => {
        const el = document.getElementById('type-'+t);
        if (el) el.classList.toggle('active', t===activeType);
    });
}
function updateTypeCounts() {
    document.getElementById('cnt-All').textContent     = CATALOG.length;
    document.getElementById('cnt-pet').textContent     = CATALOG.filter(i=>i.type==='pet').length;
    document.getElementById('cnt-product').textContent = CATALOG.filter(i=>i.type==='product').length;
    document.getElementById('cnt-service').textContent = CATALOG.filter(i=>i.type==='service').length;
}

/* ── Price slider ── */
function onPriceChange() {
    const v = parseInt(document.getElementById('priceSlider').value);
    document.getElementById('priceLabel').textContent = v>=50000 ? 'Any' : '₱'+v.toLocaleString('en-PH');
    applyFilters();
}

/* ── Apply filters ── */
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

    if      (sort==='price-asc')  list.sort((a,b)=>a.price-b.price);
    else if (sort==='price-desc') list.sort((a,b)=>b.price-a.price);
    else if (sort==='name-asc')   list.sort((a,b)=>a.name.localeCompare(b.name));

    if (quizMatchIds.length) {
        const matched = list.filter(i => quizMatchIds.includes(i.id));
        const others  = list.filter(i => !quizMatchIds.includes(i.id));
        list = [...matched, ...others];
    }

    renderGrid(list);
    document.getElementById('resultCount').textContent = list.length + ' item' + (list.length!==1?'s':'');
}

/* ── Render grid ── */
function renderGrid(items) {
    const grid  = document.getElementById('productsGrid');
    const empty = document.getElementById('emptyShop');
    if (!items.length) { grid.style.display='none'; empty.style.display='block'; return; }
    grid.style.display='grid'; empty.style.display='none';

    grid.innerHTML = items.map(item => {
        const inCart     = cart.some(c=>c.id===item.id);
        const isMatch    = quizMatchIds.includes(item.id);
        const typeText   = item.type==='product'?'📦 Supply':item.type==='service'?'✂️ Service':'🐾 Pet';
        return `
        <div class="p-card ${!item.available?'unavail':''} ${isMatch?'quiz-match':''}">
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
                    <button class="add-to-cart ${inCart?'in-cart':''}"
                            onclick="addToCart(${item.id})"
                            ${!item.available?'disabled':''}>
                        ${inCart?'✓ Added':'+ Add'}
                    </button>
                </div>
            </div>
        </div>`;
    }).join('');
}

/* ── Cart: Add ── */
function addToCart(id) {
    const item = CATALOG.find(i => i.id === id);
    if (!item || !item.available) return;

    if (item.type === 'service') {
        openBookingModal(item);
        return;
    }

    const ex = cart.find(c => c.id === id);
    if (ex) { ex.qty++; }
    else { cart.push({ ...item, qty: 1 }); }

    renderCart();
    applyFilters();
    showToast(item.emoji + ' ' + item.name + ' added!');
    bumpBadge();
    updateQmrCardButtons();
}

function openBookingModal(service) {
    pendingService = service;
    document.getElementById('bookingServiceTitle').textContent = service.name;
    const overlay = document.getElementById('bookingOverlay');
    overlay.style.display = 'flex';
    selectedTimeSlot = null;
    document.querySelectorAll('.slot-btn').forEach(btn => btn.classList.remove('active'));
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('bookingDate').min = today;
    document.getElementById('bookingDate').value = today;
}

function closeBookingModal() {
    document.getElementById('bookingOverlay').style.display = 'none';
    pendingService = null;
}

function selectTimeSlot(button, time) {
    selectedTimeSlot = time;
    document.querySelectorAll('.slot-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
}

function confirmServiceBooking() {
    // 1. Grab the input elements
    const dateInput = document.getElementById('bookingDate');
    const timeInput = document.getElementById('bookingTime');
    const toast = document.getElementById('shopToast');
    const serviceTitle = document.getElementById('bookingServiceTitle').innerText;

    // 2. Validation: Make sure the user actually picked a date and time
    if (!dateInput.value || !timeInput.value) {
        alert("Please select both a date and a preferred time slot! 🐾");
        return;
    }

    // 3. Format the data (Optional: convert military time to 12-hour format if you want)
    const selectedDate = dateInput.value; 
    const selectedTime = format12Hour(timeInput.value);

    // 4. Do your booking logic here (e.g., add to cart, send to server, etc.)
    console.log(`Booking Confirmed for ${serviceTitle} on ${selectedDate} at ${selectedTime}`);

    // 5. Show a success message using your existing shop-toast element
    if (toast) {
        toast.innerText = `Successfully booked ${serviceTitle} for ${selectedDate} at ${selectedTime}! 🎉`;
        toast.classList.add('show'); // Make sure you have a .show class in your CSS for the toast
        
        // Hide toast after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    // 6. Close the modal after a successful booking
    closeBookingModal();
}

// Helper function to turn standard 24hr input (e.g., "14:30") into user-friendly 12hr time ("2:30 PM")
function format12Hour(timeString) {
    const [hours, minutes] = timeString.split(':');
    const hour = parseInt(hours, 10);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const formattedHour = hour % 12 || 12; // Converts 0 to 12 for midnight
    return `${formattedHour}:${minutes} ${ampm}`;
}

/* ── Cart: Remove / qty ── */
function removeFromCart(id) { cart=cart.filter(c=>c.id!==id); renderCart(); applyFilters(); }
function updateQty(id, delta) {
    const item=cart.find(c=>c.id===id);
    if (!item) return;
    item.qty=Math.max(1,item.qty+delta);
    renderCart();
}

/* ── Cart: Render ── */
function renderCart() {
    const list  = document.getElementById('cList');
    const foot  = document.getElementById('cFoot');
    const veri  = document.getElementById('verificationSection');
    const badge = document.getElementById('cartBadge');
    const totalQty = cart.reduce((s,i)=>s+i.qty,0);
    badge.textContent = totalQty;

    if (!cart.length) {
        list.innerHTML=`<div class="c-empty"><span class="ce">🛒</span><p>Your cart is empty.<br>Add some pets or supplies!</p></div>`;
        foot.style.display='none'; if(veri) veri.style.display='none'; return;
    }

    const subtotal = cart.reduce((s,i)=>s+i.price*i.qty,0);
    const hasPet   = cart.some(i=>i.type==='pet');

    list.innerHTML = cart.map(item=>`
        <div class="c-item">
            <div class="c-emoji">${item.emoji}</div>
            <div class="c-info">
                <div class="c-iname" title="${item.name}">${item.name}</div>
                <div class="c-icat">${item.category}</div>
                <div class="c-iprice">₱${(item.price*item.qty).toLocaleString('en-PH')}</div>
                ${item.bookingLabel ? `<div class="booking-tag">📅 ${item.bookingLabel}</div>` : ''}
            </div>
            <div class="qty-wrap">
                <button class="q-btn" onclick="updateQty(${item.id},-1)">−</button>
                <span class="q-num">${item.qty}</span>
                <button class="q-btn" onclick="updateQty(${item.id},+1)">+</button>
            </div>
            <button class="c-del" onclick="removeFromCart(${item.id})" title="Remove">🗑️</button>
        </div>`).join('');

    const paymentWrap = document.querySelector('.payment-method');
    if (paymentWrap) {
        let html=`<p style="font-weight:600;margin-bottom:8px;font-size:0.9rem;">Payment Method:</p>`;
        if (hasPet||subtotal>2000) {
            const dp=subtotal*0.20;
            html+=`<div style="background:#fff4e5;padding:10px;border-radius:8px;border-left:4px solid #f39c12;margin-bottom:8px;">
                <label style="cursor:pointer;font-size:0.85rem;display:block;color:#d35400;font-weight:700;">
                    <input type="radio" name="payment" value="gcash" checked> GCash (20% Downpayment)
                </label>
                <p style="font-size:0.7rem;margin-top:5px;color:#666;">Reservation fee: ₱${dp.toLocaleString()}</p>
            </div>
            <label style="font-size:0.85rem;color:#ccc;cursor:not-allowed;display:block;opacity:0.6;">
                <input type="radio" name="payment" disabled> Cash on Delivery (Disabled)
            </label>`;
        } else {
            html+=`<div style="display:flex;gap:15px;">
                <label style="cursor:pointer;font-size:0.85rem;"><input type="radio" name="payment" value="cash" checked> Cash</label>
                <label style="cursor:pointer;font-size:0.85rem;"><input type="radio" name="payment" value="gcash"> GCash</label>
            </div>`;
        }
        paymentWrap.innerHTML=html;
    }

    document.getElementById('cSubtotal').textContent='₱'+subtotal.toLocaleString('en-PH');
    document.getElementById('cTotal').textContent   ='₱'+subtotal.toLocaleString('en-PH');
    foot.style.display='block'; if(veri) veri.style.display='block';
}

/* ── Cart: Toggle ── */
function toggleCart() {
    const d=document.getElementById('cDrawer'), o=document.getElementById('cOverlay');
    const open=d.classList.toggle('open');
    o.classList.toggle('open',open);
    document.body.style.overflow=open?'hidden':'';
}

/* ── Checkout ── */
function handleCheckout() {
    const city=document.getElementById('citySelect').value;
    const brgy=document.getElementById('brgySelect').value;
    const phone=document.getElementById('phoneInput').value;
    const otp=document.getElementById('otpCode').value;
    const method=document.querySelector('input[name="payment"]:checked').value;
    if(!city||!brgy) { showToast('📍 Please select your delivery address.'); return; }
    if(phone.length!==11) { showToast('📱 Please enter a valid 11-digit number.'); return; }
    if(!generatedOTP||otp!==String(generatedOTP)) { showToast('🔑 Incorrect or missing OTP code.'); return; }

    /* ── Capture a checkout snapshot BEFORE the GCash / COD branch ── */
    const subtotal = cart.reduce((s,i)=>s+i.price*i.qty,0);
    const hasPet   = cart.some(i=>i.type==='pet');
    const requiresGcash = hasPet || subtotal > 2000;
    const amountDue = (method==='gcash' && requiresGcash) ? subtotal * 0.20 : subtotal;

    lastCheckoutSnapshot = {
        items:      JSON.parse(JSON.stringify(cart)),   /* deep copy */
        subtotal,
        amountDue,
        method:     method === 'gcash'
                        ? (requiresGcash ? 'GCash (20% Downpayment)' : 'GCash')
                        : 'Cash on Delivery',
        city,
        brgy,
        phone,
    };

    if(method==='gcash') {
        const t=document.querySelector('#gcashModal h3');
        if(t) t.innerText=`Pay ₱${amountDue.toLocaleString()} via GCash`;
        document.getElementById('gcashModal').style.display='flex';
    } else {
        if(confirm(`Confirm COD order for ${phone}?`)) processFinalOrder();
    }
}

function showProofModal() {
    document.getElementById('gcashModal').style.display='none';
    document.getElementById('proofModal').style.display='flex';
}

function submitFinalCheckout() {
    const ref=document.getElementById('refNum').value;
    const file=document.getElementById('screenshot').files[0];
    const wm=document.getElementById('warningModal');
    const wt=document.getElementById('warningMessage');
    if(ref.length!==13) { wt.innerText='The GCash Reference Number must be exactly 13 digits.'; wm.style.display='flex'; return; }
    if(!file) { wt.innerText='Please upload a screenshot of your receipt.'; wm.style.display='flex'; return; }
    document.getElementById('proofModal').style.display='none';
    processFinalOrder();
}

function closeModal(id) { document.getElementById(id).style.display='none'; }

/* ════════════════════════════════════════
   processFinalOrder  — now opens the
   Order Confirmation Modal instead of
   just showing a toast.
════════════════════════════════════════ */
function processFinalOrder() {
    /* Generate a unique Order ID: PH + timestamp + random 4-digit suffix */
    const ts     = Date.now().toString(36).toUpperCase();
    const rand   = Math.floor(1000 + Math.random() * 9000);
    const orderId = `PH-${ts}-${rand}`;

    /* Close the cart drawer silently */
    const d=document.getElementById('cDrawer'), o=document.getElementById('cOverlay');
    d.classList.remove('open'); o.classList.remove('open');
    document.body.style.overflow='';

    /* Clear cart data */
    const snapshot = lastCheckoutSnapshot;
    cart=[];
    generatedOTP=null;
    lastCheckoutSnapshot=null;
    renderCart();
    applyFilters();

    /* ── Populate the Order Confirmation Modal ── */
    if (!snapshot) { showToast('🚀 Order placed!'); return; }

    /* Order ID */
    document.getElementById('ocmOrderId').textContent = orderId;
    document.getElementById('ocmOrderIdInline').textContent = orderId;

    /* Timestamp */
    const now = new Date();
    document.getElementById('ocmTimestamp').textContent =
        now.toLocaleDateString('en-PH', { year:'numeric', month:'long', day:'numeric' })
        + ' at '
        + now.toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit' });

    /* Items list */
    document.getElementById('ocmItemsList').innerHTML = snapshot.items.map(item => `
        <div class="ocm-item">
            <div class="ocm-item-em">${item.emoji}</div>
            <div class="ocm-item-info">
                <div class="ocm-item-name">${item.name}</div>
                <div class="ocm-item-cat">${item.category}</div>
                ${item.bookingLabel
                    ? `<div class="ocm-item-booking">📅 ${item.bookingLabel}</div>`
                    : ''}
            </div>
            <div class="ocm-item-right">
                <div class="ocm-item-qty">× ${item.qty}</div>
                <div class="ocm-item-price">₱${(item.price * item.qty).toLocaleString('en-PH')}</div>
            </div>
        </div>`).join('');

    /* Summary */
    document.getElementById('ocmSubtotal').textContent   = '₱' + snapshot.subtotal.toLocaleString('en-PH');
    document.getElementById('ocmAmountDue').textContent  = '₱' + snapshot.amountDue.toLocaleString('en-PH');
    document.getElementById('ocmPayMethod').textContent  = snapshot.method;
    document.getElementById('ocmTotal').textContent      = '₱' + snapshot.subtotal.toLocaleString('en-PH');

    /* Address & contact */
    document.getElementById('ocmAddress').textContent =
        `${snapshot.brgy}, ${snapshot.city}, Cavite`;
    document.getElementById('ocmPhone').textContent = snapshot.phone;

    /* Show the modal */
    document.getElementById('orderConfirmOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';

    /* Scroll modal to top */
    document.getElementById('orderConfirmModal').scrollTop = 0;
}

/* ── Close Order Confirmation Modal ── */
function closeOrderConfirm() {
    document.getElementById('orderConfirmOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ── Copy Order ID to clipboard ── */
function copyOrderId() {
    const id = document.getElementById('ocmOrderId').textContent;
    navigator.clipboard.writeText(id).then(() => showToast('📋 Order ID copied!'));
}

/* ── Misc ── */
function clearFilters() {
    activeCat='All'; activeType='All';
    document.getElementById('searchInput').value='';
    document.getElementById('sortPick').value='featured';
    document.getElementById('priceSlider').value='50000';
    document.getElementById('priceLabel').textContent='Any';
    clearQuizFilter(); renderPills(); setType('All'); applyFilters();
}
function toggleMobileMenu() {
    const m=document.getElementById('shopMobileMenu');
    m.style.display=m.style.display==='block'?'none':'block';
}
let toastTimer=null;
function showToast(msg) {
    const el=document.getElementById('shopToast');
    el.textContent=msg; el.classList.add('show');
    clearTimeout(toastTimer); toastTimer=setTimeout(()=>el.classList.remove('show'),2600);
}
function bumpBadge() {
    const b=document.getElementById('cartBadge');
    b.classList.add('bump'); setTimeout(()=>b.classList.remove('bump'),300);
}

/* ════════════════════════════════════════
   PET MATCHER QUIZ
════════════════════════════════════════ */
const QM_PETS = [
    { id:1,  tags:{ space:['medium','large'],        activity:['medium','high'],  kids:['no-kids','older-kids','young-kids'] } },
    { id:2,  tags:{ space:['small','medium'],        activity:['low','medium'],   kids:['no-kids','older-kids'] } },
    { id:3,  tags:{ space:['small','medium'],        activity:['low','medium'],   kids:['no-kids','older-kids','young-kids'] } },
    { id:5,  tags:{ space:['small','medium'],        activity:['low','medium'],   kids:['no-kids'] } },
    { id:6,  tags:{ space:['small','medium','large'],activity:['low'],            kids:['no-kids','older-kids','young-kids'] } },
    { id:7,  tags:{ space:['small','medium','large'],activity:['low'],            kids:['no-kids','older-kids'] } },
    { id:8,  tags:{ space:['small','medium'],        activity:['low'],            kids:['no-kids','older-kids','young-kids'] } },
    { id:9,  tags:{ space:['small','medium','large'],activity:['low','medium'],   kids:['no-kids','older-kids'] } },
    { id:10, tags:{ space:['small','medium','large'],activity:['low','medium'],   kids:['no-kids','older-kids','young-kids'] } },
];

const QM_COPY = {
    'small-low-no-kids':       {emoji:'😺',title:'The Peaceful Solo Companion',   reason:'🏢 Cozy space + calm vibes = purr-fect.'},
    'small-low-older-kids':    {emoji:'🐹',title:'The Gentle Family Starter',      reason:'👦 Easy-care small pets fit busy families.'},
    'small-low-young-kids':    {emoji:'🐹',title:'The Safe Starter Pet',           reason:'👶 Small and gentle for little hands.'},
    'small-medium-no-kids':    {emoji:'🦜',title:'The Chatty Apartment Buddy',     reason:'🏢 Smart birds thrive in cozy homes.'},
    'small-medium-older-kids': {emoji:'🐩',title:'The Compact Family Dog',         reason:'👦 Small but packed with love and energy.'},
    'small-medium-young-kids': {emoji:'🐰',title:'The Apartment-Friendly Friend',  reason:'👶 Gentle pets are safest for toddlers.'},
    'small-high-no-kids':      {emoji:'🐩',title:'The Energetic Compact Buddy',    reason:'🏋️ Even small dogs love active owners.'},
    'small-high-older-kids':   {emoji:'🐩',title:'The Fun Family Pet',             reason:'👦 Active family, lively little dog.'},
    'small-high-young-kids':   {emoji:'🐰',title:'The Safe Active Companion',      reason:'👶 Gentle but fun for active families.'},
    'medium-low-no-kids':      {emoji:'🐈',title:'The Elegant Indoor Companion',   reason:'🛋️ Calm cats love a chill household.'},
    'medium-low-older-kids':   {emoji:'🐱',title:'The Friendly Home Cat',          reason:'👦 Older kids get along great with cats.'},
    'medium-low-young-kids':   {emoji:'🐠',title:'The Low-Maintenance Starter',    reason:'👶 Fish are safe and endlessly calming.'},
    'medium-medium-no-kids':   {emoji:'🐕',title:'The Balanced Lifestyle Match',   reason:'🚶 A happy medium for home and walks.'},
    'medium-medium-older-kids':{emoji:'🐕',title:'The Classic Family Dog',         reason:'👨‍👩‍👧 The all-around family favourite.'},
    'medium-medium-young-kids':{emoji:'🐩',title:'The Gentle Family Dog',          reason:'👶 Patient small dogs love gentle kids.'},
    'medium-high-no-kids':     {emoji:'🐕',title:'The Active Companion',           reason:'🏋️ You both love burning energy!'},
    'medium-high-older-kids':  {emoji:'🐕',title:'The Family Adventure Dog',       reason:'👦 Big energy + active family = bliss.'},
    'medium-high-young-kids':  {emoji:'🐶',title:'The Loyal Family Guard',         reason:'👶 Retrievers are famous for loving babies.'},
    'large-low-no-kids':       {emoji:'🐈',title:'The Regal Homebody',             reason:'🛋️ Big space, calm lifestyle — cat paradise.'},
    'large-low-older-kids':    {emoji:'🐕',title:'The Laid-Back Family Dog',       reason:'👦 Easygoing dogs love a big yard.'},
    'large-low-young-kids':    {emoji:'🐶',title:'The Gentle Giant Buddy',         reason:'👶 Calm large dogs are great with tots.'},
    'large-medium-no-kids':    {emoji:'🐕',title:'The All-Round Companion',        reason:'🏠 Space + balance = dog heaven.'},
    'large-medium-older-kids': {emoji:'🐕',title:'The Backyard Best Friend',       reason:'👦 Room to play and kids to love.'},
    'large-medium-young-kids': {emoji:'🐕',title:'The Safe Family Dog',            reason:'👶 Family dogs shine in big homes.'},
    'large-high-no-kids':      {emoji:'🐕',title:'The Athletic Powerhouse',        reason:'🏋️ Big yard + high energy = perfect match.'},
    'large-high-older-kids':   {emoji:'🐕',title:'The Adventure Family Dog',       reason:'👦 Active family loves an energetic dog.'},
    'large-high-young-kids':   {emoji:'🐶',title:'The Loyal Family Protector',     reason:'👶 Retrievers are legendary family dogs.'},
};

function openQuiz() {
    document.getElementById('quizOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeQuiz() {
    document.getElementById('quizOverlay').classList.remove('open');
    if (!document.getElementById('cDrawer').classList.contains('open')) {
        document.body.style.overflow = '';
    }
}
function handleQuizOverlayClick(e) {
    if (e.target === document.getElementById('quizOverlay')) closeQuiz();
}

function qmPick(el) {
    const step = parseInt(el.dataset.step);
    el.closest('.qm-options').querySelectorAll('.qm-opt').forEach(o=>o.classList.remove('selected'));
    el.classList.add('selected');
    qmAnswers[step] = el.dataset.val;
    document.getElementById('qmNext'+step).disabled = false;
}

function qmGoStep(n) {
    document.querySelectorAll('.qm-step').forEach(s=>s.classList.remove('active'));
    document.getElementById('qmStep'+n).classList.add('active');
    const pct=(n/3)*100;
    document.getElementById('qmProgressFill').style.width=pct+'%';
    document.getElementById('qmStepLbl').textContent=`Step ${n} of 3`;
    document.getElementById('qmProgressWrap').style.display='flex';
    document.getElementById('qmResult').style.display='none';
}

function qmShowResult() {
    const key  = `${qmAnswers[1]}-${qmAnswers[2]}-${qmAnswers[3]}`;
    const copy = QM_COPY[key] || {emoji:'🐾',title:'A Wonderful Match!',reason:'🐾 Any pet would love your home.'};

    const matched = QM_PETS.filter(p =>
        p.tags.space.includes(qmAnswers[1]) &&
        p.tags.activity.includes(qmAnswers[2]) &&
        p.tags.kids.includes(qmAnswers[3])
    );
    quizMatchIds = matched.map(p=>p.id);

    const shown = matched
        .map(p => CATALOG.find(c=>c.id===p.id))
        .filter(Boolean)
        .slice(0,4);
    const display = shown.length ? shown : CATALOG.filter(c=>c.type==='pet').slice(0,3);

    document.getElementById('qmrEmoji').textContent = copy.emoji;
    document.getElementById('qmrTitle').textContent = copy.title;
    document.getElementById('qmrDesc').textContent  =
        `Based on your answers, here ${display.length===1?'is our top pick':'are your top matches'} from our catalog.`;
    document.getElementById('qmrReason').textContent = copy.reason;

    document.getElementById('qmrGrid').innerHTML = display.map((item,i) => {
        const inCart = cart.some(c=>c.id===item.id);
        return `
        <div class="qmr-card ${i===0?'best':''}">
            <span class="qrc-fit">${i===0?'⭐ Best':'Great Fit'}</span>
            <div class="qrc-em">${item.emoji}</div>
            <div class="qrc-cat">${item.category}</div>
            <div class="qrc-name">${item.name}</div>
            <div class="qrc-price">₱${item.price.toLocaleString('en-PH')}</div>
            <div class="qrc-why">${item.desc.substring(0,70)}…</div>
            <div class="qrc-btns">
                <button class="qrc-add ${inCart?'in-cart':''}"
                        id="qrcAdd-${item.id}"
                        onclick="qmrAddToCart(${item.id})"
                        ${!item.available?'disabled':''}>
                    ${inCart?'✓ Added':'🛒 Add'}
                </button>
                <button class="qrc-view" onclick="qmViewInShop(${item.id})">View</button>
            </div>
        </div>`;
    }).join('');

    document.querySelectorAll('.qm-step').forEach(s=>s.classList.remove('active'));
    document.getElementById('qmProgressWrap').style.display='none';
    document.getElementById('qmResult').style.display='block';

    qmFireConfetti();
}

function qmrAddToCart(id) { addToCart(id); }

function updateQmrCardButtons() {
    document.querySelectorAll('[id^="qrcAdd-"]').forEach(btn => {
        const id = parseInt(btn.id.replace('qrcAdd-',''));
        const inCart = cart.some(c=>c.id===id);
        btn.textContent = inCart ? '✓ Added' : '🛒 Add';
        btn.classList.toggle('in-cart', inCart);
    });
}

function qmViewInShop(id) {
    closeQuiz();
    setType('pet');
    setTimeout(() => {
        applyFilters();
        const grid = document.getElementById('productsGrid');
        if (grid) grid.scrollIntoView({ behavior:'smooth', block:'start' });
        showQuizBanner();
    }, 150);
}

function qmShowInShop() {
    closeQuiz();
    setType('pet');
    setTimeout(() => {
        applyFilters();
        const grid = document.getElementById('productsGrid');
        if (grid) grid.scrollIntoView({ behavior:'smooth', block:'start' });
        showQuizBanner();
    }, 150);
}

function showQuizBanner() {
    if (!quizMatchIds.length) return;
    const key  = `${qmAnswers[1]}-${qmAnswers[2]}-${qmAnswers[3]}`;
    const copy = QM_COPY[key] || {emoji:'🐾',title:'Quiz Results Active'};
    document.getElementById('qabEmoji').textContent = copy.emoji;
    document.getElementById('qabTitle').textContent = copy.title;
    document.getElementById('qabSub').textContent   =
        `${quizMatchIds.length} matching pet${quizMatchIds.length!==1?'s':''} highlighted below`;
    document.getElementById('quizActiveBanner').classList.add('visible');
}
function clearQuizFilter() {
    quizMatchIds = [];
    document.getElementById('quizActiveBanner').classList.remove('visible');
    applyFilters();
}

function qmRetake() {
    qmAnswers[1]=qmAnswers[2]=qmAnswers[3]=null;
    document.querySelectorAll('.qm-opt').forEach(o=>o.classList.remove('selected'));
    ['qmNext1','qmNext2','qmNext3'].forEach(id=>document.getElementById(id).disabled=true);
    document.getElementById('qmResult').style.display='none';
    qmGoStep(1);
}

function qmFireConfetti() {
    const canvas = document.getElementById('qmConfetti');
    const ctx    = canvas.getContext('2d');
    const modal  = canvas.parentElement;
    canvas.width = modal.offsetWidth; canvas.height = modal.offsetHeight;
    const COLORS = ['#E68A39','#F4A35A','#34A853','#FEF9C3','#FEE2E2','#2D241E'];
    const parts  = Array.from({length:70},()=>({
        x:Math.random()*canvas.width, y:-10,
        r:Math.random()*5+2, color:COLORS[Math.floor(Math.random()*COLORS.length)],
        speed:Math.random()*3+1.5, spin:Math.random()*.2-.1,
        angle:Math.random()*Math.PI*2, drift:Math.random()*2-1
    }));
    let frame=0;
    function draw(){
        ctx.clearRect(0,0,canvas.width,canvas.height);
        parts.forEach(p=>{
            ctx.save(); ctx.translate(p.x,p.y); ctx.rotate(p.angle);
            ctx.fillStyle=p.color; ctx.globalAlpha=Math.max(0,1-frame/85);
            ctx.fillRect(-p.r/2,-p.r,p.r,p.r*2); ctx.restore();
            p.y+=p.speed; p.x+=p.drift; p.angle+=p.spin;
        });
        frame++;
        if(frame<95) requestAnimationFrame(draw);
        else ctx.clearRect(0,0,canvas.width,canvas.height);
    }
    draw();
}

/* ════════════════════════════════════════
   AUTO-ADD FROM URL PARAM + INIT
════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    init();
    const params = new URLSearchParams(window.location.search);
    const addId  = params.get('addToCart');
    if (addId) {
        const id = parseInt(addId);
        if (CATALOG.some(p=>p.id===id)) {
            addToCart(id);
            window.history.replaceState({},document.title,window.location.pathname);
        }
    }
});
</script>

@endsection