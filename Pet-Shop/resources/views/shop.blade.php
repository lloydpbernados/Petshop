@extends('layouts.app')
@section('title', 'PawHaven Shop — Pets & Supplies')
@section('content')
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
--modal-z:      9999;
}
html { scroll-behavior: smooth; }
body { background: var(--cream); color: var(--brown); font-family: 'Segoe UI', system-ui, sans-serif; overflow-x: hidden; }
/* ── Customer message bubbles ── */
.msg-bubble-out { align-self: flex-end; background: var(--orange); color: #fff; padding: 10px 14px; border-radius: 18px 18px 4px 18px; max-width: 80%; font-size: 0.88rem; line-height: 1.5; box-shadow: 0 2px 8px rgba(230,138,57,0.3); }
.msg-bubble-in { align-self: flex-start; background: var(--cream-mid); color: var(--brown); padding: 10px 14px; border-radius: 18px 18px 18px 4px; max-width: 80%; font-size: 0.88rem; line-height: 1.5; border: 1px solid var(--border); }
.msg-time { font-size: 0.7rem; color: var(--brown-muted); margin-top: 4px; }
.msg-row { display: flex; flex-direction: column; }
.msg-row.out { align-items: flex-end; }
.msg-row.in  { align-items: flex-start; }
.shop-navbar { position: sticky; top: 0; z-index: 100; background: var(--white); border-bottom: 1.5px solid var(--border); height: 68px; display: flex; align-items: center; padding: 0 2.5rem; box-shadow: var(--shadow-sm); }
.nav-inner { max-width: 1400px; margin: 0 auto; width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 2rem; }
.nav-brand { font-size: 1.4rem; font-weight: 800; color: var(--brown); text-decoration: none; letter-spacing: -0.02em; display: flex; align-items: center; gap: 0.4rem; white-space: nowrap; }
.nav-links { display: flex; gap: 1.75rem; align-items: center; }
.nav-link { font-size: 0.88rem; font-weight: 600; color: var(--brown-sub); text-decoration: none; transition: color 0.2s; white-space: nowrap; }
.nav-link:hover { color: var(--orange); }
.nav-actions { display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0; }
.btn-nav-login { background: transparent; color: var(--brown); padding: 8px 18px; border-radius: 99px; font-size: 0.85rem; font-weight: 600; text-decoration: none; border: 1.5px solid var(--border); cursor: pointer; transition: all 0.2s; font-family: inherit; white-space: nowrap; }
.btn-nav-login:hover { border-color: var(--orange); color: var(--orange); background: #FFF8F0; }
.cart-btn { background: var(--brown); color: var(--white); border: none; padding: 9px 18px; border-radius: 99px; font-size: 0.88rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.45rem; transition: background 0.2s; white-space: nowrap; flex-shrink: 0; }
.cart-btn:hover { background: var(--orange); }
.cart-count { background: var(--orange); padding: 2px 8px; border-radius: 99px; font-size: 0.73rem; font-weight: 800; min-width: 22px; text-align: center; }
.nav-user-greeting { font-size: 0.88rem; font-weight: 600; color: var(--brown); white-space: nowrap; }
.guest-dropdown { position: relative; }
.guest-dropdown-toggle { display: flex; align-items: center; gap: 6px; background: transparent; border: 1.5px solid var(--border); padding: 8px 16px; border-radius: 99px; font-size: 0.85rem; font-weight: 600; color: var(--brown); cursor: pointer; transition: all 0.2s; white-space: nowrap; font-family: inherit; }
.guest-dropdown-toggle:hover { border-color: var(--orange); color: var(--orange); background: #FFF8F0; }
.guest-dropdown-toggle .chevron { font-size: 0.65rem; transition: transform 0.2s; }
.guest-dropdown-toggle.active .chevron { transform: rotate(180deg); }
.guest-dropdown-menu { position: absolute; top: calc(100% + 10px); right: 0; background: var(--white); border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 8px; min-width: 220px; box-shadow: var(--shadow-md); display: none; flex-direction: column; gap: 2px; z-index: 1001; animation: dropdownFade 0.18s ease; }
.guest-dropdown-menu.show { display: flex; }
@keyframes dropdownFade { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }
.guest-dropdown-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: var(--radius-sm); font-size: 0.88rem; font-weight: 600; color: var(--brown-sub); text-decoration: none; background: none; border: none; cursor: pointer; width: 100%; text-align: left; transition: all 0.15s; font-family: inherit; }
.guest-dropdown-item:hover { background: var(--cream); color: var(--orange); }
.guest-dropdown-item .item-icon { font-size: 1rem; width: 22px; text-align: center; }
.guest-dropdown-divider { height: 1px; background: var(--border); margin: 4px 6px; }
/* ── USER DROPDOWN (AUTHENTICATED) ── */
.user-dropdown { position: relative; }
.user-dropdown-toggle { display: flex; align-items: center; gap: 6px; background: transparent; border: 1.5px solid var(--border); padding: 8px 16px; border-radius: 99px; font-size: 0.85rem; font-weight: 600; color: var(--brown); cursor: pointer; transition: all 0.2s; white-space: nowrap; font-family: inherit; }
.user-dropdown-toggle:hover { border-color: var(--orange); color: var(--orange); background: #FFF8F0; }
.user-dropdown-toggle .chevron { font-size: 0.65rem; transition: transform 0.2s; }
.user-dropdown-toggle.active .chevron { transform: rotate(180deg); }
.user-dropdown-menu { position: absolute; top: calc(100% + 10px); right: 0; background: var(--white); border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 8px; min-width: 220px; box-shadow: var(--shadow-md); display: none; flex-direction: column; gap: 2px; z-index: 1001; animation: dropdownFade 0.18s ease; }
.user-dropdown-menu.show { display: flex; }
.user-dropdown-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: var(--radius-sm); font-size: 0.88rem; font-weight: 600; color: var(--brown-sub); text-decoration: none; background: none; border: none; cursor: pointer; width: 100%; text-align: left; transition: all 0.15s; font-family: inherit; }
.user-dropdown-item:hover { background: var(--cream); color: var(--orange); }
.user-dropdown-item .item-icon { font-size: 1rem; width: 22px; text-align: center; }
.user-dropdown-divider { height: 1px; background: var(--border); margin: 4px 6px; }
.shop-hero { background: linear-gradient(160deg, #FDF2E9 0%, #FDF8F1 60%); border-bottom: 1.5px solid var(--border); padding: 3.5rem 2.5rem 3rem; }
.hero-inner { max-width: 680px; margin: 0 auto; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 0.85rem; }
.hero-eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(230,138,57,0.12); border: 1px solid rgba(230,138,57,0.25); color: var(--orange); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; padding: 5px 14px; border-radius: 99px; }
.hero-title { font-family: var(--serif); font-size: clamp(2.2rem, 5vw, 3.4rem); color: var(--brown); line-height: 1.15; letter-spacing: -0.01em; }
.hero-title em { font-style: italic; color: var(--orange); }
.hero-sub { font-size: 1rem; color: var(--brown-muted); line-height: 1.6; max-width: 500px; }
.hero-stats { display: flex; gap: 2rem; margin-top: 0.5rem; justify-content: center; }
.hero-stat { text-align: center; }
.hero-stat strong { display: block; font-size: 1.3rem; font-weight: 800; color: var(--brown); letter-spacing: -0.02em; }
.hero-stat span { font-size: 0.78rem; color: var(--brown-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
.hero-divider { width: 1px; background: var(--border-mid); height: 36px; align-self: center; }
.shop-layout { max-width: 1400px; margin: 0 auto; padding: 2.5rem 2.5rem 4rem; display: grid; grid-template-columns: 260px 1fr; gap: 2.5rem; align-items: start; }
.filter-panel { background: var(--white); padding: 1.75rem; border-radius: var(--radius-lg); border: 1.5px solid var(--border); position: sticky; top: 84px; }
.filter-panel-title { font-size: 1rem; font-weight: 800; color: var(--brown); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
.filter-section { margin-bottom: 1.75rem; padding-bottom: 1.75rem; border-bottom: 1px solid var(--border); }
.filter-section:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
.filter-heading { font-size: 0.72rem; font-weight: 800; color: var(--brown-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.85rem; }
.filter-pills { display: flex; flex-wrap: wrap; gap: 0.45rem; }
.pill { background: var(--cream); border: 1.5px solid var(--border); padding: 5px 13px; border-radius: 99px; font-size: 0.82rem; font-weight: 600; color: var(--brown-sub); cursor: pointer; transition: all 0.18s; }
.pill:hover { border-color: var(--orange); color: var(--orange); background: #FFF8F0; }
.pill.active { background: var(--orange); border-color: var(--orange); color: var(--white); box-shadow: 0 2px 8px var(--orange-glow); }
.price-range-wrap { margin-top: 0.75rem; }
.price-range-wrap input[type="range"] { width: 100%; accent-color: var(--orange); cursor: pointer; }
.price-labels { display: flex; justify-content: space-between; font-size: 0.82rem; color: var(--brown-muted); margin-top: 0.5rem; font-weight: 600; }
.price-current { text-align: center; font-size: 0.9rem; font-weight: 700; color: var(--orange); margin-top: 0.35rem; }
.toggle-label { display: flex; align-items: center; gap: 0.7rem; font-size: 0.88rem; color: var(--brown); cursor: pointer; font-weight: 500; }
.toggle-label input { accent-color: var(--orange); width: 15px; height: 15px; }
.product-grid-wrap { min-width: 0; }
.grid-toolbar { display: flex; gap: 0.85rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center; }
.search-wrap { flex: 1; min-width: 220px; position: relative; }
.search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); font-size: 1rem; pointer-events: none; }
.search-box { width: 100%; padding: 11px 16px 11px 42px; border: 1.5px solid var(--border); border-radius: var(--radius-md); font-size: 0.95rem; background: var(--white); color: var(--brown); transition: border-color 0.2s, box-shadow 0.2s; }
.search-box:focus { outline: none; border-color: var(--orange); box-shadow: 0 0 0 3px var(--orange-glow); }
.search-box::placeholder { color: var(--brown-muted); }
.sort-wrap select { padding: 11px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-md); font-size: 0.9rem; background: var(--white); cursor: pointer; color: var(--brown); font-weight: 600; transition: border-color 0.2s; }
.sort-wrap select:focus { outline: none; border-color: var(--orange); }
.results-bar { font-size: 0.87rem; color: var(--brown-muted); margin-bottom: 1.25rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; }
.results-bar::before { content: ''; display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: var(--orange); }
.product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem; }
.product-card { background: var(--white); border-radius: var(--radius-lg); border: 1.5px solid var(--border); overflow: hidden; transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s; display: flex; flex-direction: column; }
.product-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--border-mid); }
.product-card.unavailable { opacity: 0.55; pointer-events: none; }
.card-img { background: var(--cream-mid); height: 185px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.card-emoji { font-size: 3.75rem; line-height: 1; }
.badge { position: absolute; top: 10px; right: 10px; padding: 3px 11px; border-radius: 99px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; }
.badge-bestseller { background: #FEF3C7; color: #92400E; }
.badge-popular    { background: #EEF2FF; color: #3730A3; }
.badge-new        { background: #DCFCE7; color: #166534; }
.badge-essential  { background: #FEE2E2; color: #991B1B; }
.badge-fun        { background: #FCE7F3; color: #9D174D; }
.badge-sale       { background: #FEF08A; color: #713F12; }
.unavail-overlay { position: absolute; inset: 0; background: rgba(255,255,255,0.75); backdrop-filter: blur(2px); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--brown-sub); font-size: 0.9rem; letter-spacing: 0.05em; text-transform: uppercase; }
.card-body { padding: 1.25rem 1.35rem 1.35rem; flex: 1; display: flex; flex-direction: column; gap: 0.4rem; }
.card-category { font-size: 0.7rem; font-weight: 800; color: var(--brown-muted); text-transform: uppercase; letter-spacing: 0.1em; }
.card-name { font-size: 1.05rem; font-weight: 700; color: var(--brown); line-height: 1.3; }
.card-desc { font-size: 0.86rem; color: var(--brown-muted); line-height: 1.55; flex: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid var(--border); }
.card-price { font-size: 1.15rem; font-weight: 800; color: var(--orange); }
.add-to-cart { background: var(--brown); color: var(--white); border: none; padding: 7px 15px; border-radius: 99px; font-size: 0.82rem; font-weight: 700; cursor: pointer; transition: background 0.2s, transform 0.15s; white-space: nowrap; }
.add-to-cart:hover { background: var(--orange); transform: scale(1.04); }
.add-to-cart.in-cart { background: var(--green); }
.unavail-tag { font-size: 0.82rem; font-weight: 600; color: var(--brown-muted); }
.empty-state { text-align: center; padding: 5rem 2rem; color: var(--brown-muted); grid-column: 1 / -1; }
.empty-icon { font-size: 3rem; display: block; margin-bottom: 1rem; }
.empty-state h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.4rem; color: var(--brown); }
.hidden { display: none !important; }
.cart-drawer { position: fixed; top: 0; right: -460px; width: 420px; max-width: 92vw; height: 100vh; background: var(--white); z-index: 10000; box-shadow: var(--shadow-lg); display: flex; flex-direction: column; transition: right 0.3s cubic-bezier(0.4,0,0.2,1); }
.cart-drawer.open { right: 0; }
.cart-header { padding: 1.35rem 1.5rem; border-bottom: 1.5px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: var(--cream); }
.cart-title { font-size: 1.1rem; font-weight: 800; color: var(--brown); }
.cart-close { background: none; border: none; font-size: 1.3rem; cursor: pointer; color: var(--brown-muted); line-height: 1; padding: 4px; border-radius: 6px; transition: background 0.15s; }
.cart-close:hover { background: var(--border); }
.cart-items { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }
.cart-item { display: flex; gap: 1rem; padding: 0.9rem 0; border-bottom: 1px solid var(--border); align-items: center; }
.cart-item:last-child { border-bottom: none; }
.cart-item-emoji { font-size: 2.2rem; flex-shrink: 0; }
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-name { font-weight: 700; color: var(--brown); font-size: 0.92rem; margin-bottom: 0.2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cart-item-price { font-size: 0.9rem; color: var(--orange); font-weight: 700; }
.cart-qty-wrap { display: flex; align-items: center; gap: 0.45rem; flex-shrink: 0; }
.cart-qty-wrap button { width: 26px; height: 26px; border: 1.5px solid var(--border); background: var(--white); border-radius: 7px; cursor: pointer; font-weight: 800; font-size: 0.85rem; transition: all 0.15s; color: var(--brown); }
.cart-qty-wrap button:hover { background: var(--cream); border-color: var(--orange); }
.cart-qty-wrap span { font-size: 0.9rem; font-weight: 700; min-width: 18px; text-align: center; }
.cart-remove { background: none; border: none; color: var(--red); cursor: pointer; font-size: 1rem; flex-shrink: 0; padding: 4px; border-radius: 6px; transition: background 0.15s; }
.cart-remove:hover { background: #FEE2E2; }
.cart-empty { text-align: center; color: var(--brown-muted); padding: 3rem 1rem; font-size: 0.95rem; }
.cart-empty-icon { font-size: 2.5rem; display: block; margin-bottom: 0.75rem; }
.cart-footer { padding: 1.25rem 1.5rem; border-top: 1.5px solid var(--border); background: var(--cream); }
.cart-total-row { display: flex; justify-content: space-between; font-size: 1rem; font-weight: 700; margin-bottom: 1rem; align-items: center; }
.cart-total-amt { color: var(--orange); font-size: 1.25rem; font-weight: 800; }
.checkout-btn { width: 100%; background: var(--orange); color: var(--white); border: none; padding: 13px; border-radius: var(--radius-md); font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: background 0.2s, transform 0.15s; letter-spacing: 0.02em; }
.checkout-btn:hover { background: var(--orange-dark); transform: translateY(-1px); }
.cart-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 9999; opacity: 0; visibility: hidden; transition: opacity 0.3s; }
.cart-overlay.show { opacity: 1; visibility: visible; }
.checkout-modal { position: fixed; inset: 0; background: rgba(45,36,30,0.55); z-index: 10001; display: flex; align-items: center; justify-content: center; padding: 1.5rem; backdrop-filter: blur(3px); }
.checkout-box { background: var(--white); border-radius: var(--radius-lg); padding: 2.25rem 2.5rem; max-width: 580px; width: 100%; max-height: 92vh; overflow-y: auto; position: relative; box-shadow: var(--shadow-lg); }
.checkout-close { position: absolute; top: 1.1rem; right: 1.1rem; background: var(--cream); border: 1.5px solid var(--border); width: 32px; height: 32px; border-radius: 99px; font-size: 1rem; cursor: pointer; color: var(--brown-muted); display: flex; align-items: center; justify-content: center; transition: all 0.15s; }
.checkout-close:hover { background: var(--border); color: var(--brown); }
.checkout-title { font-family: var(--serif); font-size: 1.7rem; color: var(--brown); margin-bottom: 0.25rem; line-height: 1.2; }
.checkout-subtitle { color: var(--brown-muted); margin-bottom: 1.75rem; font-size: 0.9rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-weight: 700; color: var(--brown); margin-bottom: 0.45rem; font-size: 0.88rem; }
.form-group input, .form-group textarea { width: 100%; padding: 11px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-md); font-size: 0.95rem; color: var(--brown); transition: border-color 0.2s, box-shadow 0.2s; background: var(--white); }
.form-group input:focus, .form-group textarea:focus { outline: none; border-color: var(--orange); box-shadow: 0 0 0 3px var(--orange-glow); }
.form-group textarea { resize: vertical; }
.checkout-order-summary { background: var(--cream); padding: 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.25rem; border: 1px solid var(--border); }
.summary-row { display: flex; justify-content: space-between; padding: 0.45rem 0; font-size: 0.9rem; border-bottom: 1px dashed var(--border); gap: 1rem; }
.summary-row:last-child { border-bottom: none; }
.summary-row span:first-child { color: var(--brown); font-weight: 500; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.summary-row span:last-child { font-weight: 700; color: var(--brown); white-space: nowrap; }
.checkout-total-row { display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 800; margin-bottom: 1.5rem; padding: 1rem; border-radius: var(--radius-md); background: linear-gradient(135deg, #FFF8F0, var(--cream)); border: 1.5px solid var(--border-mid); align-items: center; }
.checkout-total-amt { color: var(--orange); font-size: 1.3rem; }
.payment-section-heading { font-size: 0.78rem; font-weight: 800; color: var(--brown-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; display: block; }
.payment-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem; margin-bottom: 1rem; }
.payment-option { border: 2px solid var(--border); border-radius: var(--radius-md); padding: 1rem 0.75rem; cursor: pointer; text-align: center; transition: all 0.2s; background: var(--white); display: flex; flex-direction: column; align-items: center; gap: 0.3rem; user-select: none; position: relative; }
.payment-option:hover:not(.locked) { border-color: var(--orange); background: #FFFAF5; }
.payment-option.selected { border-color: var(--orange); background: #FFF8F0; box-shadow: 0 0 0 3px var(--orange-glow); }
.payment-option.locked { cursor: not-allowed; opacity: 0.38; filter: grayscale(0.5); }
.pay-icon  { font-size: 1.6rem; line-height: 1; }
.pay-label { font-size: 0.87rem; font-weight: 700; color: var(--brown); }
.pay-sub   { font-size: 0.7rem; color: var(--brown-muted); }
.pay-check { width: 18px; height: 18px; border-radius: 50%; border: 2px solid var(--border); margin-top: 0.3rem; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; transition: all 0.2s; font-weight: 800; }
.payment-option.selected .pay-check { background: var(--orange); border-color: var(--orange); color: var(--white); }
.gcash-lock-notice { display: none; align-items: flex-start; gap: 0.55rem; background: #FEF3C7; border: 1px solid #FCD34D; border-radius: var(--radius-sm); padding: 0.75rem 1rem; font-size: 0.82rem; color: #78350F; margin-bottom: 1rem; line-height: 1.5; }
.gcash-lock-notice.show { display: flex; }
.lock-icon { font-size: 0.95rem; flex-shrink: 0; margin-top: 1px; }
.gcash-ref-group { display: none; }
.gcash-ref-group.show { display: block; }
.gcash-info-box { background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: var(--radius-sm); padding: 0.85rem 1rem; margin-bottom: 0.85rem; font-size: 0.82rem; color: #1E40AF; line-height: 1.65; }
.gcash-info-box strong { color: #1E3A8A; }
#otpSection { background: #FEF9EC; border: 1px solid #FDE68A; padding: 1.35rem; border-radius: var(--radius-md); margin-bottom: 1.25rem; }
#otpSection .form-group { margin-bottom: 0; }
#otpInput { flex: 1; padding: 11px; border: 1.5px solid var(--border); border-radius: var(--radius-md); font-size: 1.1rem; text-align: center; letter-spacing: 0.25em; font-weight: 700; }
#otpBtn { background: var(--brown); color: var(--white); border: none; padding: 11px 18px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer; white-space: nowrap; font-size: 0.88rem; transition: background 0.2s; }
#otpBtn:hover { background: var(--orange); }
#otpBtn:disabled { opacity: 0.5; cursor: not-allowed; }
#proceedToOtpBtn, #placeOrderBtn { width: 100%; background: var(--orange); color: var(--white); border: none; padding: 13px; border-radius: var(--radius-md); font-size: 0.95rem; font-weight: 700; cursor: pointer; margin-top: 1rem; transition: background 0.2s, transform 0.15s; letter-spacing: 0.02em; }
#proceedToOtpBtn:hover, #placeOrderBtn:hover { background: var(--orange-dark); transform: translateY(-1px); }
#proceedToOtpBtn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
#shopAuthModal { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(45, 36, 30, 0.6); display: flex; align-items: center; justify-content: center; z-index: var(--modal-z); visibility: visible; opacity: 1; }
#shopAuthModal.modal-hidden { display: none !important; }
#shopAuthModal .shop-auth-content { background: var(--white); padding: 32px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); max-width: 480px; width: 90%; position: relative; animation: shopModalSlide 0.3s ease; max-height: 90vh; overflow-y: auto; }
@keyframes shopModalSlide { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
#shopAuthModal .shop-modal-close-btn { position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 1.5rem; color: var(--brown-muted); cursor: pointer; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background .2s; }
#shopAuthModal .shop-modal-close-btn:hover { background: var(--border); color: var(--brown); }
.shop-auth-tab { display: block; }
.shop-auth-tab.tab-hidden { display: none; }
.auth-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--brown); text-align: center; margin-bottom: 8px; }
.auth-subtitle { text-align: center; color: var(--brown-muted); font-size: .9rem; margin-bottom: 24px; }
.auth-input-group { margin-bottom: 16px; }
.auth-input-group label { display: block; color: var(--brown); font-weight: 600; font-size: .85rem; margin-bottom: 6px; }
.auth-input-group input { width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 12px; background: var(--cream); color: var(--brown); font-size: 1rem; outline: none; transition: border-color .2s; font-family: inherit; }
.auth-input-group input:focus { border-color: var(--orange); box-shadow: 0 0 0 3px rgba(230,138,57,.15); }
.pw-wrapper { position: relative; display: flex; align-items: center; }
.pw-wrapper input { padding-right: 44px !important; width: 100%; }
.pw-toggle { position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: var(--brown-muted); padding: 4px; display: flex; align-items: center; justify-content: center; transition: color .2s; }
.pw-toggle:hover { color: var(--orange); }
.pw-toggle svg { width: 20px; height: 20px; pointer-events: none; }
.pw-hints { margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 6px 12px; }
.pw-hint { display: flex; align-items: center; gap: 6px; font-size: .75rem; color: #b09884; transition: color .25s; }
.pw-hint.met { color: #16a34a; }
.pw-hint-dot { width: 16px; height: 16px; border-radius: 50%; border: 1.5px solid #d6c6b8; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 9px; font-weight: 700; color: transparent; transition: background .25s, border-color .25s, color .25s; }
.pw-hint.met .pw-hint-dot { background: #16a34a; border-color: #16a34a; color: white; }
.auth-btn { width: 100%; background: var(--orange); color: white; border: none; padding: 14px; border-radius: 30px; font-size: 1rem; font-weight: 700; cursor: pointer; font-family: inherit; transition: background .2s, transform .2s; }
.auth-btn:hover { background: #cf7830; transform: translateY(-2px); }
.auth-btn:disabled { background: var(--border); cursor: not-allowed; transform: none; }
.auth-toggle { text-align: center; margin-top: 20px; font-size: .9rem; color: var(--brown-muted); }
.switch-auth-link { color: var(--orange) !important; font-weight: 600 !important; text-decoration: none !important; cursor: pointer !important; display: inline-block; padding: 4px 8px; margin-left: 2px; border-radius: 6px; transition: all 0.2s ease; background: transparent; border: none; font-family: inherit; font-size: inherit; }
.switch-auth-link:hover { text-decoration: underline !important; background: rgba(230,138,57,0.1); }
.auth-divider { text-align: center; margin: 20px 0; color: var(--brown-muted); font-size: .85rem; position: relative; }
.auth-divider::before, .auth-divider::after { content: ''; position: absolute; top: 50%; width: 40%; height: 1px; background: var(--border); }
.auth-divider::before { left: 0; }
.auth-divider::after  { right: 0; }
.auth-social { display: flex; gap: 12px; justify-content: center; }
.auth-social-btn { flex: 1; padding: 10px; border-radius: 12px; border: 1px solid var(--border); background: var(--white); color: var(--brown); font-size: .85rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; font-family: inherit; transition: background .2s, border-color .2s; }
.auth-social-btn:hover { background: var(--cream); border-color: var(--orange); }
.auth-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px; border-radius: 10px; font-size: .85rem; margin-bottom: 16px; display: none; }
.auth-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px; border-radius: 10px; font-size: .85rem; margin-bottom: 16px; display: none; }
@media (max-width: 1024px) { .shop-layout { grid-template-columns: 230px 1fr; gap: 2rem; } }
@media (max-width: 860px) {
.shop-layout { grid-template-columns: 1fr; padding: 2rem 1.5rem; }
.filter-panel { position: static; }
.cart-drawer { width: 100%; max-width: 100%; }
.checkout-box { padding: 1.75rem 1.5rem; }
}
@media (max-width: 600px) {
.shop-navbar { padding: 0 1.25rem; }
.shop-hero   { padding: 2.5rem 1.25rem 2.25rem; }
.hero-stats  { gap: 1.25rem; }
.shop-layout { padding: 1.5rem 1.25rem; }
.product-grid { grid-template-columns: 1fr; }
.payment-methods { grid-template-columns: 1fr 1fr; }
.checkout-modal { padding: 0.75rem; }
.checkout-box { padding: 1.5rem 1.25rem; border-radius: var(--radius-md); }
}
</style>
<script>
const CATALOG = @json($catalog);
</script>
<div id="shop-root">
<nav class="shop-navbar">
<div class="nav-inner">
<a href="{{ route('home') }}" class="nav-brand">🐾 PawHaven</a>
<div class="nav-links">
@auth
{{-- Links moved to user dropdown --}}
@endauth
</div>
<div class="nav-actions">
@auth
<button class="btn-nav-login" id="msgToggle" style="position:relative;">
💬 Messages
<span id="msgUnread" style="display:none; position:absolute; top:-4px; right:-4px; background:#E68A39; color:#fff; font-size:0.6rem; font-weight:800; padding:2px 5px; border-radius:99px; min-width:16px; text-align:center;">!</span>
</button>
<div class="user-dropdown">
<button type="button" class="user-dropdown-toggle" id="userDropdownToggle">
<span>Hello, {{ Auth::user()->name }}! 🐾</span>
<span class="chevron">▼</span>
</button>
<div class="user-dropdown-menu" id="userDropdownMenu">
<button type="button" class="user-dropdown-item" id="userCartToggle">
<span class="item-icon">🛒</span>
<span>Cart (<span id="cartCount">0</span>)</span>
</button>
<div class="user-dropdown-divider"></div>
<a href="{{ route('order.track.form') }}" class="user-dropdown-item">
<span class="item-icon">📦</span>
<span>Track Order</span>
</a>
<div class="user-dropdown-divider"></div>
<button type="button" class="user-dropdown-item" onclick="window.location.href='{{ route('shop.3d') }}'">
<span class="item-icon">🎨</span>
<span>3D Habitat Builder</span>
</button>
<div class="user-dropdown-divider"></div>
<button type="button" class="user-dropdown-item" onclick="window.location.href='{{ route('shop.orders') }}'">
<span class="item-icon">📜</span>
<span>Order History</span>
</button>
<div class="user-dropdown-divider"></div>
<form method="POST" action="{{ route('logout') }}" style="display:inline; width:100%; margin:0;">
@csrf
<button type="submit" class="user-dropdown-item" style="width:100%; text-align:left;">
<span class="item-icon">🚪</span>
<span>Logout</span>
</button>
</form>
</div>
</div>
@else
<button type="button" class="btn-nav-login" id="shopOpenLoginBtn">Log In</button>
<div class="guest-dropdown">
<button type="button" class="guest-dropdown-toggle" id="guestDropdownToggle">
<span>Welcome, Guest!</span>
<span class="chevron">▼</span>
</button>
<div class="guest-dropdown-menu" id="guestDropdownMenu">
<button type="button" class="guest-dropdown-item" id="dropdownCart">
<span class="item-icon">🛒</span>
<span>Cart (<span id="dropdownCartCount">0</span>)</span>
</button>
<div class="guest-dropdown-divider"></div>
<a href="{{ route('order.track.form') }}" class="guest-dropdown-item">
<span class="item-icon">📦</span>
<span>Track Order</span>
</a>
<div class="guest-dropdown-divider"></div>
{{-- ── FIXED: now navigates to the 3D builder for guests too ── --}}
<button type="button" class="guest-dropdown-item" id="open3DCustomizer">
<span class="item-icon">🎨</span>
<span>3D Habitat Builder</span>
</button>
</div>
</div>
@endauth
</div>
</div>
</nav>
<section class="shop-hero">
<div class="hero-inner">
<span class="hero-eyebrow">🐾 PawHaven Shop</span>
<h1 class="hero-title">Pets, Supplies<br><em>&amp; Services</em></h1>
<p class="hero-sub">Everything your companion needs, all in one place — from food and toys to grooming and adoption.</p>
<div class="hero-stats">
<div class="hero-stat"><strong id="statTotal">—</strong><span>Products</span></div>
<div class="hero-divider"></div>
<div class="hero-stat"><strong id="statPets">—</strong><span>Pets</span></div>
<div class="hero-divider"></div>
<div class="hero-stat"><strong id="statServices">—</strong><span>Services</span></div>
</div>
</div>
</section>
<div class="shop-layout">
<aside class="filter-panel">
<div class="filter-panel-title">🔧 Filters</div>
<div class="filter-section">
<p class="filter-heading">Type</p>
<div class="filter-pills" id="typePills">
<button class="pill active" data-type="">All</button>
<button class="pill" data-type="pet">Pets</button>
<button class="pill" data-type="product">Supplies</button>
<button class="pill" data-type="service">Services</button>
</div>
</div>
<div class="filter-section">
<p class="filter-heading">Category</p>
<div class="filter-pills" id="catPills"></div>
</div>
<div class="filter-section">
<p class="filter-heading">Max Price</p>
<div class="price-range-wrap">
<input type="range" id="priceSlider" min="0" max="50000" value="50000" step="100">
<div class="price-labels"><span>₱0</span><span>₱50,000</span></div>
<div class="price-current" id="priceLabel">Up to ₱50,000+</div>
</div>
</div>
<div class="filter-section">
<p class="filter-heading">Availability</p>
<label class="toggle-label"><input type="checkbox" id="availOnly">Show available only</label>
</div>
</aside>
<main class="product-grid-wrap">
<div class="grid-toolbar">
<div class="search-wrap">
<span class="search-icon">🔍</span>
<input type="text" id="searchInput" placeholder="Search pets, food, toys…" class="search-box">
</div>
<div class="sort-wrap">
<select id="sortSelect">
<option value="default">Featured</option>
<option value="price-asc">Price: Low → High</option>
<option value="price-desc">Price: High → Low</option>
<option value="name-asc">Name: A → Z</option>
</select>
</div>
</div>
<div id="resultsBar" class="results-bar"></div>
<div id="productGrid" class="product-grid"></div>
<div id="emptyState" class="empty-state hidden">
<span class="empty-icon">🔍</span>
<h3>No results found</h3>
<p>Try adjusting your filters or search term.</p>
</div>
</main>
</div>
<div id="cartDrawer" class="cart-drawer">
<div class="cart-header">
<h3 class="cart-title">Your Cart 🛒</h3>
<button id="cartClose" class="cart-close">✕</button>
</div>
<div id="cartItems" class="cart-items"></div>
<div class="cart-footer">
<div class="cart-total-row"><span>Total</span><span id="cartTotal" class="cart-total-amt">₱0</span></div>
<button id="checkoutBtn" class="checkout-btn">Proceed to Checkout →</button>
</div>
</div>
<div id="cartOverlay" class="cart-overlay"></div>
{{-- CUSTOMER MESSAGES DRAWER (auth users only) --}}
@auth
<div id="msgDrawer" class="cart-drawer" style="width:440px; max-width:92vw;">
<div class="cart-header">
<h3 class="cart-title">💬 Messages</h3>
<button id="msgClose" class="cart-close">✕</button>
</div>
{{-- Conversation window --}}
<div id="msgWindow" class="cart-items" style="display:flex; flex-direction:column; gap:12px; padding:1.25rem 1.5rem;">
<div style="text-align:center; color:var(--brown-muted); font-size:0.9rem; padding:2rem 0;">
<div style="font-size:2rem; margin-bottom:8px;">💬</div>
Loading messages…
</div>
</div>
{{-- Input --}}
<div class="cart-footer" style="padding:1rem 1.5rem;">
<div style="display:flex; gap:0.6rem; align-items:center;">
<input type="text" id="msgInput" placeholder="Type a message…"
style="flex:1; padding:10px 14px; border:1.5px solid var(--border); border-radius:var(--radius-md);
font-size:0.9rem; background:var(--cream); color:var(--brown); outline:none;"
onkeydown="if(event.key==='Enter'){ event.preventDefault(); sendMyMessage(); }">
<button onclick="sendMyMessage()"
style="background:var(--orange); color:#fff; border:none; padding:10px 16px;
border-radius:var(--radius-md); font-weight:700; cursor:pointer; font-size:0.9rem;
transition:background 0.2s; white-space:nowrap;"
onmouseover="this.style.background='#cf7529'" onmouseout="this.style.background='#E68A39'">
Send 🚀
</button>
</div>
<p style="font-size:0.75rem; color:var(--brown-muted); margin-top:8px; text-align:center;">
Our team typically replies within a few hours 🐾
</p>
</div>
</div>
<div id="msgOverlay" class="cart-overlay"></div>
@endauth
<div id="checkoutModal" class="checkout-modal hidden">
<div class="checkout-box">
<button class="checkout-close" id="checkoutClose">✕</button>
<h2 class="checkout-title">Checkout</h2>
<p class="checkout-subtitle">Fill in your details to complete your order.</p>
<form id="checkoutForm" action="{{ route('shop.checkout') }}" method="POST">
@csrf
<div id="checkoutHiddenItems"></div>
<input type="hidden" name="payment_method" id="paymentMethodInput" value="cash">
<div class="form-group"><label>Full Name</label><input type="text" name="customer_name" id="chkName" placeholder="e.g. Maria Santos" required></div>
<div class="form-group"><label>Email Address</label><input type="email" name="email" id="chkEmail" placeholder="yourname@email.com" required></div>
<div class="form-group"><label>Shipping Address</label><textarea name="shipping_address" id="chkAddress" rows="2" placeholder="Street, Barangay, City, Province"></textarea></div>
<div class="checkout-order-summary" id="checkoutSummary"></div>
<div class="checkout-total-row"><span>Grand Total</span><span class="checkout-total-amt" id="checkoutGrandTotal">₱0</span></div>
<span class="payment-section-heading">Payment Method</span>
<div class="gcash-lock-notice" id="gcashLockNotice"><span class="lock-icon">⚠️</span><span>Orders above <strong>₱10,000</strong> require GCash payment for security.</span></div>
<div class="payment-methods" id="paymentMethods">
<div class="payment-option" id="optGcash" onclick="selectPayment('gcash')"><span class="pay-icon">📱</span><span class="pay-label">GCash</span><span class="pay-sub">Pay via GCash</span><span class="pay-check" id="checkGcash"></span></div>
<div class="payment-option selected" id="optCash" onclick="selectPayment('cash')"><span class="pay-icon">💵</span><span class="pay-label">Cash on Delivery</span><span class="pay-sub">Pay upon arrival</span><span class="pay-check" id="checkCash">✓</span></div>
</div>
<div class="form-group gcash-ref-group" id="gcashRefGroup">
<div class="gcash-info-box">📲 Send payment to <strong>09XX-XXX-XXXX</strong> · Account: <strong>PawHaven Shop</strong><br>Enter the <strong>13-digit reference number</strong> from your GCash receipt below.</div>
<label>GCash Reference Number</label>
<input type="text" name="gcash_reference" id="gcashRef" placeholder="e.g. 1234567890123" maxlength="13" oninput="this.value = this.value.replace(/\D/g,'')">
</div>
<div id="otpSection" style="display:none;">
<div class="form-group">
<label>One-Time Password</label>
<p style="font-size:.8rem; color:var(--brown-muted); margin-bottom:.6rem; line-height:1.5;">A 6-digit OTP will be sent to <strong id="otpEmailDisplay"></strong>.</p>
<div style="display:flex; gap:.5rem;">
<input type="text" id="otpInput" placeholder="6-digit OTP" maxlength="6" inputmode="numeric" autocomplete="one-time-code">
<button type="button" id="otpBtn" onclick="sendOTP()">Send OTP</button>
</div>
<p id="otpStatus" style="font-size:.78rem; margin-top:.4rem; min-height:1.2em;"></p>
</div>
</div>
<button type="button" id="proceedToOtpBtn" onclick="proceedToOTP()">Verify &amp; Place Order →</button>
<button type="button" id="placeOrderBtn" style="display:none;" onclick="verifyAndSubmit()">Place Order →</button>
</form>
</div>
</div>
</div>
{{-- AUTH MODAL --}}
<div id="shopAuthModal" class="modal-hidden">
<div class="shop-auth-content">
<button class="shop-modal-close-btn" id="shopCloseAuthModal">&times;</button>
<div id="shopAuthLoginForm" class="shop-auth-tab">
<div style="text-align:center; margin-bottom:24px;"><div style="font-size:2.5rem; margin-bottom:.5rem;">🐾</div><h3 class="auth-title">Welcome Back!</h3><p class="auth-subtitle">Log in to access your PawHaven account</p></div>
<div id="shopAuthLoginError" class="auth-error"></div>
<div id="shopAuthLoginSuccess" class="auth-success"></div>
<form id="shopLoginForm">
@csrf
<div class="auth-input-group"><label for="shopLoginEmail">Email Address</label><input type="email" id="shopLoginEmail" name="email" placeholder="yourname@email.com" required></div>
<div class="auth-input-group">
<label for="shopLoginPassword">Password</label>
<div class="pw-wrapper">
<input type="password" id="shopLoginPassword" name="password" placeholder="••••••••" required>
<button type="button" class="pw-toggle" data-target="shopLoginPassword" aria-label="Show password">
<svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
<svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
</button>
</div>
</div>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; font-size:.85rem;">
<label style="display:flex; align-items:center; gap:6px; cursor:pointer; color:var(--brown-muted);"><input type="checkbox" id="shopRememberMe" name="remember" style="accent-color:var(--orange);">Remember me</label>
<a href="#" style="color:var(--orange); text-decoration:none; font-weight:600;">Forgot password?</a>
</div>
<button type="submit" class="auth-btn" id="shopLoginSubmitBtn">Log In to PawHaven</button>
</form>
<div class="auth-divider">or continue with</div>
<div class="auth-social"><button type="button" class="auth-social-btn">🔵 Google</button><button type="button" class="auth-social-btn">📘 Facebook</button></div>
<div class="auth-toggle">Don't have an account?<button type="button" class="switch-auth-link" data-switch-to="signup">Sign Up</button></div>
</div>
<div id="shopAuthSignupForm" class="shop-auth-tab tab-hidden">
<div style="text-align:center; margin-bottom:24px;"><div style="font-size:2.5rem; margin-bottom:.5rem;">🎉</div><h3 class="auth-title">Join PawHaven</h3><p class="auth-subtitle">Create your account to start shopping</p></div>
<div id="shopAuthSignupError" class="auth-error"></div>
<div id="shopAuthSignupSuccess" class="auth-success"></div>
<form id="shopSignupForm">
@csrf
<div class="auth-input-group"><label for="shopSignupName">Full Name</label><input type="text" id="shopSignupName" name="name" placeholder="Juan Dela Cruz" required></div>
<div class="auth-input-group"><label for="shopSignupEmail">Email Address</label><input type="email" id="shopSignupEmail" name="email" placeholder="yourname@email.com" required></div>
<div class="auth-input-group">
<label for="shopSignupPassword">Password</label>
<div class="pw-wrapper">
<input type="password" id="shopSignupPassword" name="password" placeholder="••••••••" minlength="8" required>
<button type="button" class="pw-toggle" data-target="shopSignupPassword" aria-label="Show password">
<svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
<svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
</button>
</div>
<div class="pw-hints" id="shopPwHints">
<div class="pw-hint" id="shop-hint-length"><div class="pw-hint-dot">✓</div><span>8+ characters</span></div>
<div class="pw-hint" id="shop-hint-upper"><div class="pw-hint-dot">✓</div><span>Uppercase (A–Z)</span></div>
<div class="pw-hint" id="shop-hint-lower"><div class="pw-hint-dot">✓</div><span>Lowercase (a–z)</span></div>
<div class="pw-hint" id="shop-hint-number"><div class="pw-hint-dot">✓</div><span>A number (0–9)</span></div>
</div>
</div>
<div class="auth-input-group">
<label for="shopSignupPasswordConfirm">Confirm Password</label>
<div class="pw-wrapper">
<input type="password" id="shopSignupPasswordConfirm" name="password_confirmation" placeholder="••••••••" minlength="8" required>
<button type="button" class="pw-toggle" data-target="shopSignupPasswordConfirm" aria-label="Show password">
<svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
<svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
</button>
</div>
</div>
<div style="margin-bottom:20px; font-size:.85rem; color:var(--brown-muted);">
<label style="display:flex; align-items:flex-start; gap:8px; cursor:pointer;">
<input type="checkbox" name="terms" required style="accent-color:var(--orange); margin-top:3px;">
<span>I agree to PawHaven's <a href="#" style="color:var(--orange); text-decoration:none;">Terms of Service</a> and <a href="#" style="color:var(--orange); text-decoration:none;">Privacy Policy</a></span>
</label>
</div>
<button type="submit" class="auth-btn" id="shopSignupSubmitBtn">Create Account</button>
</form>
<div class="auth-divider">or sign up with</div>
<div class="auth-social"><button type="button" class="auth-social-btn">🔵 Google</button><button type="button" class="auth-social-btn">📘 Facebook</button></div>
<div class="auth-toggle">Already have an account?<button type="button" class="switch-auth-link" data-switch-to="login">Sign In</button></div>
</div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
function getCsrfToken() {
return document.querySelector('meta[name="csrf-token"]')?.content
|| document.querySelector('input[name="_token"]')?.value || '';
}
// ══════════ AUTH MODAL ══════════
(function () {
const modal = document.getElementById('shopAuthModal');
const loginTab = document.getElementById('shopAuthLoginForm');
const signupTab = document.getElementById('shopAuthSignupForm');
const closeBtn = document.getElementById('shopCloseAuthModal');
const loginErr = document.getElementById('shopAuthLoginError');
const loginOk = document.getElementById('shopAuthLoginSuccess');
const signupErr = document.getElementById('shopAuthSignupError');
const signupOk = document.getElementById('shopAuthSignupSuccess');
function clearMessages() { [loginErr, loginOk, signupErr, signupOk].forEach(el => { if (el) el.style.display = 'none'; }); }
function resetHints() { ['shop-hint-length','shop-hint-upper','shop-hint-lower','shop-hint-number'].forEach(id => document.getElementById(id)?.classList.remove('met')); }
function resetEyes() {
document.querySelectorAll('#shopAuthModal .pw-toggle').forEach(btn => {
const input = document.getElementById(btn.dataset.target);
if (input) input.type = 'password';
const open = btn.querySelector('.eye-open'), closed = btn.querySelector('.eye-closed');
if (open) open.style.display = 'block';
if (closed) closed.style.display = 'none';
});
}
function openAuthModal(tab) {
if (!modal) return;
tab = tab || 'login';
modal.classList.remove('modal-hidden');
document.body.style.overflow = 'hidden';
document.getElementById('shopLoginForm')?.reset();
document.getElementById('shopSignupForm')?.reset();
clearMessages(); resetEyes(); resetHints();
switchTab(tab);
}
function closeAuthModal() {
if (!modal) return;
modal.classList.add('modal-hidden');
document.body.style.overflow = '';
}
function switchTab(to) {
if (to === 'signup') { loginTab?.classList.add('tab-hidden'); signupTab?.classList.remove('tab-hidden'); document.getElementById('shopSignupName')?.focus(); }
else { loginTab?.classList.remove('tab-hidden'); signupTab?.classList.add('tab-hidden'); document.getElementById('shopLoginEmail')?.focus(); }
clearMessages(); resetHints();
}
closeBtn?.addEventListener('click', closeAuthModal);
modal?.addEventListener('click', e => { if (e.target === modal) closeAuthModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeAuthModal(); });
modal?.addEventListener('click', e => {
const link = e.target.closest('.switch-auth-link');
if (link) { e.preventDefault(); e.stopPropagation(); switchTab(link.dataset.switchTo); }
}, true);
document.querySelectorAll('#shopAuthModal .pw-toggle').forEach(btn => {
btn.addEventListener('click', function () {
const input = document.getElementById(this.dataset.target);
if (!input) return;
const open = this.querySelector('.eye-open'), closed = this.querySelector('.eye-closed');
if (input.type === 'password') { input.type = 'text'; if (open) open.style.display = 'none'; if (closed) closed.style.display = 'block'; }
else { input.type = 'password'; if (open) open.style.display = 'block'; if (closed) closed.style.display = 'none'; }
});
});
document.getElementById('shopSignupPassword')?.addEventListener('input', function () {
const v = this.value;
const checks = { 'shop-hint-length': v.length >= 8, 'shop-hint-upper': /[A-Z]/.test(v), 'shop-hint-lower': /[a-z]/.test(v), 'shop-hint-number': /[0-9]/.test(v) };
Object.keys(checks).forEach(id => document.getElementById(id)?.classList.toggle('met', checks[id]));
});
document.getElementById('shopLoginForm')?.addEventListener('submit', function (e) {
e.preventDefault();
const email = document.getElementById('shopLoginEmail').value.trim();
const password = document.getElementById('shopLoginPassword').value;
const remember = document.getElementById('shopRememberMe').checked;
const btn = document.getElementById('shopLoginSubmitBtn');
if (!email || !password) { loginErr.textContent = '❌ Please enter your email and password.'; loginErr.style.display = 'block'; return; }
btn.disabled = true; btn.textContent = 'Logging in…';
loginErr.style.display = 'none'; loginOk.style.display = 'none';
const body = new FormData();
body.append('email', email); body.append('password', password);
body.append('remember', remember ? '1' : '0'); body.append('_token', getCsrfToken());
fetch("{{ route('login') }}", { method: 'POST', headers: { 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' }, body })
.then(async res => {
const data = await res.json().catch(() => ({}));
if (res.ok && data.success) { loginOk.textContent = '✅ Login successful!'; loginOk.style.display = 'block'; setTimeout(() => window.location.href = data.redirect || "{{ route('shop') }}", 800); }
else if (res.status === 422) { btn.disabled = false; btn.textContent = 'Log In to PawHaven'; let msg = data.message || 'Invalid credentials.'; if (data.errors?.email) msg = data.errors.email[0]; loginErr.textContent = '❌ ' + msg; loginErr.style.display = 'block'; }
else { throw new Error(data.message); }
}).catch(() => { btn.disabled = false; btn.textContent = 'Log In to PawHaven'; loginErr.textContent = '❌ Connection error.'; loginErr.style.display = 'block'; });
});
document.getElementById('shopSignupForm')?.addEventListener('submit', function (e) {
e.preventDefault();
const password = document.getElementById('shopSignupPassword').value;
const confirm = document.getElementById('shopSignupPasswordConfirm').value;
const btn = document.getElementById('shopSignupSubmitBtn');
const validations = [[password.length < 8, '❌ Password must be at least 8 characters.'], [!/[A-Z]/.test(password), '❌ Password must include an uppercase letter.'], [!/[a-z]/.test(password), '❌ Password must include a lowercase letter.'], [!/[0-9]/.test(password), '❌ Password must include a number.'], [password !== confirm, '❌ Passwords do not match.']];
for (const [fail, msg] of validations) { if (fail) { signupErr.textContent = msg; signupErr.style.display = 'block'; return; } }
btn.disabled = true; btn.textContent = 'Creating account…';
signupErr.style.display = 'none'; signupOk.style.display = 'none';
const body = new FormData();
body.append('name', document.getElementById('shopSignupName').value.trim());
body.append('email', document.getElementById('shopSignupEmail').value.trim());
body.append('password', password);
body.append('password_confirmation', confirm);
body.append('_token', getCsrfToken());
fetch("{{ route('register') }}", { method: 'POST', headers: { 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' }, body })
.then(async res => {
const data = await res.json().catch(() => ({}));
if (res.ok && data.success) { signupOk.textContent = '✅ Account created!'; signupOk.style.display = 'block'; setTimeout(() => window.location.href = data.redirect || "{{ route('shop') }}", 1500); }
else if (res.status === 422) { btn.disabled = false; btn.textContent = 'Create Account'; let msg = 'Registration failed.'; if (data.errors) msg = Object.values(data.errors)[0][0]; signupErr.textContent = '❌ ' + msg; signupErr.style.display = 'block'; }
else { throw new Error('Unexpected error.'); }
}).catch(() => { btn.disabled = false; btn.textContent = 'Create Account'; signupErr.textContent = '❌ Connection error.'; signupErr.style.display = 'block'; });
});
document.getElementById('shopOpenLoginBtn')?.addEventListener('click', e => { e.preventDefault(); openAuthModal('login'); });
const guestToggle = document.getElementById('guestDropdownToggle');
const guestMenu = document.getElementById('guestDropdownMenu');
if (guestToggle && guestMenu) {
guestToggle.addEventListener('click', e => { e.preventDefault(); e.stopPropagation(); guestMenu.classList.toggle('show'); guestToggle.classList.toggle('active'); });
document.addEventListener('click', e => { if (!guestToggle.contains(e.target) && !guestMenu.contains(e.target)) { guestMenu.classList.remove('show'); guestToggle.classList.remove('active'); } });
document.addEventListener('keydown', e => { if (e.key === 'Escape') { guestMenu.classList.remove('show'); guestToggle.classList.remove('active'); } });
}
document.getElementById('dropdownCart')?.addEventListener('click', e => { e.preventDefault(); openCart(); });

// ══════════════════════════════════════════════════════════════════════════
// FIX: Wire up the guest "3D Habitat Builder" dropdown button.
// Previously this had no click handler so guests couldn't navigate to it.
// ══════════════════════════════════════════════════════════════════════════
document.getElementById('open3DCustomizer')?.addEventListener('click', function (e) {
    e.preventDefault();
    // Close the guest dropdown first for a clean UX transition
    if (guestMenu) guestMenu.classList.remove('show');
    if (guestToggle) guestToggle.classList.remove('active');
    window.location.href = '{{ route('shop.3d') }}';
});

// ══════════ USER DROPDOWN (AUTHENTICATED) ══════════
const userToggle = document.getElementById('userDropdownToggle');
const userMenu = document.getElementById('userDropdownMenu');
if (userToggle && userMenu) {
userToggle.addEventListener('click', e => { e.preventDefault(); e.stopPropagation(); userMenu.classList.toggle('show'); userToggle.classList.toggle('active'); });
document.addEventListener('click', e => { if (!userToggle.contains(e.target) && !userMenu.contains(e.target)) { userMenu.classList.remove('show'); userToggle.classList.remove('active'); } });
document.addEventListener('keydown', e => { if (e.key === 'Escape') { userMenu.classList.remove('show'); userToggle.classList.remove('active'); } });
}
document.getElementById('userCartToggle')?.addEventListener('click', e => {
e.preventDefault();
openCart();
if(userMenu) userMenu.classList.remove('show');
if(userToggle) userToggle.classList.remove('active');
});
window.__shopOpenAuthModal = openAuthModal;
})();
// ══════════ SHOP LOGIC ══════════
const allProducts = CATALOG;
let cart = JSON.parse(sessionStorage.getItem('ph_cart') || '[]');
let activeType = new URLSearchParams(location.search).get('type') || '';
let activeCat = '', maxPrice = 50000, availOnly = false, searchQ = '', sortMode = 'default';
let selectedPayment = 'cash';
const GCASH_LIMIT = 10000;
document.getElementById('statTotal').textContent = allProducts.length;
document.getElementById('statPets').textContent = allProducts.filter(p => p.type === 'pet').length;
document.getElementById('statServices').textContent = allProducts.filter(p => p.type === 'service').length;
const autoAdd = new URLSearchParams(location.search).get('addToCart');
if (autoAdd) { const item = allProducts.find(p => String(p.id) === String(autoAdd)); if (item && item.available) addToCart(item); }
function getCategories(type) { const items = type ? allProducts.filter(p => p.type === type) : allProducts; return [...new Set(items.map(p => p.category))].sort(); }
function renderCatPills() {
const cats = getCategories(activeType);
document.getElementById('catPills').innerHTML = ['', ...cats].map(c => `<button class="pill${activeCat === c ? ' active' : ''}" data-cat="${c}">${c || 'All'}</button>`).join('');
document.querySelectorAll('#catPills .pill').forEach(btn => btn.addEventListener('click', () => { activeCat = btn.dataset.cat; renderCatPills(); renderGrid(); }));
}
function renderGrid() {
let items = allProducts.filter(p => {
if (activeType && p.type !== activeType) return false;
if (activeCat && p.category !== activeCat) return false;
if (availOnly && !p.available) return false;
if (p.price > maxPrice) return false;
if (searchQ && !p.name.toLowerCase().includes(searchQ)) return false;
return true;
});
if (sortMode === 'price-asc') items.sort((a, b) => a.price - b.price);
if (sortMode === 'price-desc') items.sort((a, b) => b.price - a.price);
if (sortMode === 'name-asc') items.sort((a, b) => a.name.localeCompare(b.name));
document.getElementById('resultsBar').textContent = `${items.length} result${items.length !== 1 ? 's' : ''} found`;
document.getElementById('emptyState').classList.toggle('hidden', items.length > 0);
document.getElementById('productGrid').innerHTML = items.map(p => {
const badgeHtml = p.badge ? `<span class="badge badge-${p.badge}">${p.badgeLabel}</span>` : '';
const inCart = cart.some(c => String(c.id) === String(p.id));
const availCls = p.available ? '' : 'unavailable';
const imgContent = p.image
? `<img src="${p.image}" alt="${p.name}" style="width:100%;height:100%;object-fit:cover;">`
: `<span class="card-emoji">${p.emoji}</span>`;
return `<div class="product-card ${availCls}">
<div class="card-img">
${imgContent}
${badgeHtml}
${!p.available ? '<div class="unavail-overlay">Out of Stock</div>' : ''}
</div>
<div class="card-body">
<div class="card-category">${p.category}</div>
<h3 class="card-name">${p.name}</h3>
<p class="card-desc">${p.desc}</p>
<div class="card-footer">
<span class="card-price">₱${p.price.toLocaleString()}</span>
${p.available
? `<button class="add-to-cart ${inCart ? 'in-cart' : ''}" onclick="addToCart(${JSON.stringify(p).replace(/"/g, '&quot;')})">${inCart ? '✓ Added' : '+ Add'}</button>`
: `<span class="unavail-tag">Unavailable</span>`}
</div>
</div>
</div>`;
}).join('');
}
function addToCart(item) {
const existing = cart.find(c => String(c.id) === String(item.id));
if (existing) existing.qty++;
else          cart.push({ ...item, qty: 1 });
saveCart(); renderCart(); renderGrid();
}
function removeFromCart(id) {
cart = cart.filter(c => String(c.id) !== String(id));
saveCart(); renderCart(); renderGrid();
}
function updateQty(id, delta) {
const item = cart.find(c => String(c.id) === String(id));
if (!item) return;
item.qty = Math.max(1, item.qty + delta);
saveCart(); renderCart();
}
function saveCart() {
sessionStorage.setItem('ph_cart', JSON.stringify(cart));
const total = cart.reduce((s, c) => s + c.qty, 0);
const countEl = document.getElementById('cartCount'); if (countEl) countEl.textContent = total;
const dropdownCountEl = document.getElementById('dropdownCartCount'); if (dropdownCountEl) dropdownCountEl.textContent = total;
}
function renderCart() {
const total = cart.reduce((s, c) => s + c.price * c.qty, 0);
document.getElementById('cartTotal').textContent = '₱' + total.toLocaleString();
document.getElementById('cartItems').innerHTML = cart.length
? cart.map(c => `<div class="cart-item"><span class="cart-item-emoji">${c.emoji}</span><div class="cart-item-info"><div class="cart-item-name">${c.name}</div><div class="cart-item-price">₱${(c.price * c.qty).toLocaleString()}</div></div><div class="cart-qty-wrap"><button onclick="window.__cart.updateQty('${c.id}', -1)">−</button><span>${c.qty}</span><button onclick="window.__cart.updateQty('${c.id}', +1)">+</button></div><button class="cart-remove" onclick="window.__cart.removeFromCart('${c.id}')">✕</button></div>`).join('')
: `<div class="cart-empty"><span class="cart-empty-icon">🛒</span>Your cart is empty</div>`;
}
function selectPayment(method) {
if (method === 'cash' && document.getElementById('optCash').classList.contains('locked')) return;
selectedPayment = method;
document.getElementById('paymentMethodInput').value = method;
const isGcash = method === 'gcash';
document.getElementById('optGcash').classList.toggle('selected', isGcash);
document.getElementById('optCash').classList.toggle('selected', !isGcash);
document.getElementById('checkGcash').textContent = isGcash ? '✓' : '';
document.getElementById('checkCash').textContent = !isGcash ? '✓' : '';
document.getElementById('gcashRefGroup').classList.toggle('show', isGcash);
if (!isGcash) document.getElementById('gcashRef').value = '';
}
function applyPaymentRules(total) {
const cashOption = document.getElementById('optCash');
const lockNotice = document.getElementById('gcashLockNotice');
if (total > GCASH_LIMIT) { cashOption.classList.add('locked'); lockNotice.classList.add('show'); selectPayment('gcash'); }
else { cashOption.classList.remove('locked'); lockNotice.classList.remove('show'); selectPayment('cash'); }
}
function proceedToOTP() {
const name = document.getElementById('chkName').value.trim();
const email = document.getElementById('chkEmail').value.trim();
if (!name || !email) { alert('Please fill in your full name and email.'); return; }
if (selectedPayment === 'gcash') {
const ref = document.getElementById('gcashRef').value.trim();
if (ref.length < 13) { alert('Enter complete 13-digit reference.'); return; }
}
document.getElementById('otpEmailDisplay').textContent = email;
document.getElementById('otpSection').style.display = 'block';
document.getElementById('proceedToOtpBtn').style.display = 'none';
}
async function sendOTP() {
const email = document.getElementById('chkEmail').value.trim();
const btn = document.getElementById('otpBtn');
const status = document.getElementById('otpStatus');
if (!email) { status.textContent = 'Enter email first.'; status.style.color = '#EF4444'; return; }
btn.disabled = true; btn.textContent = 'Sending…';
try {
const res = await fetch('{{ route("shop.otp.send") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF }, body: JSON.stringify({ email, name: document.getElementById('chkName').value.trim() }) });
const data = await res.json();
if (res.ok && data.success) {
status.textContent = `✅ OTP sent to ${email}`; status.style.color = '#34A853';
let countdown = 60; btn.textContent = `Resend in ${countdown}s`;
const timer = setInterval(() => { countdown--; btn.textContent = `Resend in ${countdown}s`; if (countdown <= 0) { clearInterval(timer); btn.disabled = false; btn.textContent = 'Resend OTP'; } }, 1000);
} else { status.textContent = data.message || 'Failed'; status.style.color = '#EF4444'; btn.disabled = false; btn.textContent = 'Send OTP'; }
} catch { status.textContent = 'Network error'; status.style.color = '#EF4444'; btn.disabled = false; btn.textContent = 'Send OTP'; }
}
document.getElementById('otpInput').addEventListener('input', function () { document.getElementById('placeOrderBtn').style.display = this.value.length === 6 ? 'block' : 'none'; });
async function verifyAndSubmit() {
const email = document.getElementById('chkEmail').value.trim();
const otp = document.getElementById('otpInput').value.trim();
const status = document.getElementById('otpStatus');
const btn = document.getElementById('placeOrderBtn');
btn.disabled = true; btn.textContent = 'Verifying…';
try {
const res = await fetch('{{ route("shop.otp.verify") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF }, body: JSON.stringify({ email, otp }) });
const data = await res.json();
if (res.ok && data.success) { status.textContent = '✅ Verified!'; status.style.color = '#34A853'; btn.textContent = 'Placing Order…'; setTimeout(() => document.getElementById('checkoutForm').submit(), 600); }
else { status.textContent = data.message || 'Incorrect OTP'; status.style.color = '#EF4444'; btn.disabled = false; btn.textContent = 'Place Order →'; }
} catch { status.textContent = 'Network error'; status.style.color = '#EF4444'; btn.disabled = false; btn.textContent = 'Place Order →'; }
}
function openCart() { document.getElementById('cartDrawer').classList.add('open'); document.getElementById('cartOverlay').classList.add('show'); }
function closeCart() { document.getElementById('cartDrawer').classList.remove('open'); document.getElementById('cartOverlay').classList.remove('show'); }
// ══════════════════════════════════════════════════════════════════════════
// FIX: Expose functions that are called via inline onclick attributes to the
// global scope. Functions defined inside DOMContentLoaded are local and
// invisible to onclick="..." handlers which execute in global (window) scope.
// ══════════════════════════════════════════════════════════════════════════
window.__cart = { removeFromCart, updateQty };
window.addToCart      = addToCart;
window.selectPayment  = selectPayment;
window.proceedToOTP   = proceedToOTP;
window.sendOTP        = sendOTP;
window.verifyAndSubmit = verifyAndSubmit;
document.getElementById('checkoutBtn').addEventListener('click', () => {
if (!cart.length) return;
const hidden = document.getElementById('checkoutHiddenItems'); hidden.innerHTML = '';
cart.forEach((item, i) => { hidden.innerHTML += `<input type="hidden" name="items[${i}][name]" value="${item.name}"><input type="hidden" name="items[${i}][emoji]" value="${item.emoji}"><input type="hidden" name="items[${i}][qty]" value="${item.qty}"><input type="hidden" name="items[${i}][price]" value="${item.price}">`; });
const total = cart.reduce((s, c) => s + c.price * c.qty, 0);
document.getElementById('checkoutSummary').innerHTML = cart.map(c => `<div class="summary-row"><span>${c.emoji} ${c.name} ×${c.qty}</span><span>₱${(c.price * c.qty).toLocaleString()}</span></div>`).join('');
document.getElementById('checkoutGrandTotal').textContent = '₱' + total.toLocaleString();
document.getElementById('otpSection').style.display = 'none';
document.getElementById('proceedToOtpBtn').style.display = 'block';
document.getElementById('placeOrderBtn').style.display = 'none';
applyPaymentRules(total);
document.getElementById('checkoutModal').classList.remove('hidden');
closeCart();
});
document.getElementById('checkoutClose').addEventListener('click', () => { document.getElementById('checkoutModal').classList.add('hidden'); });
document.getElementById('cartToggle')?.addEventListener('click', openCart);
document.getElementById('cartClose').addEventListener('click', closeCart);
document.getElementById('cartOverlay').addEventListener('click', closeCart);
document.querySelectorAll('#typePills .pill').forEach(btn => {
btn.addEventListener('click', () => {
document.querySelectorAll('#typePills .pill').forEach(b => b.classList.remove('active'));
btn.classList.add('active'); activeType = btn.dataset.type; activeCat = '';
renderCatPills(); renderGrid();
});
});
document.getElementById('priceSlider').addEventListener('input', function () { maxPrice = parseInt(this.value); document.getElementById('priceLabel').textContent = maxPrice >= 50000 ? 'Up to ₱50,000+' : 'Up to ₱' + maxPrice.toLocaleString(); renderGrid(); });
document.getElementById('availOnly').addEventListener('change', function () { availOnly = this.checked; renderGrid(); });
document.getElementById('searchInput').addEventListener('input', function () { searchQ = this.value.toLowerCase(); renderGrid(); });
document.getElementById('sortSelect').addEventListener('change', function () { sortMode = this.value; renderGrid(); });
saveCart(); renderCart(); renderCatPills(); renderGrid();
if (activeType) { document.querySelectorAll('#typePills .pill').forEach(b => b.classList.toggle('active', b.dataset.type === activeType)); }
// ══════════ CUSTOMER MESSAGES (auth only) ══════════
(function () {
const drawer  = document.getElementById('msgDrawer');
const overlay = document.getElementById('msgOverlay');
const window_ = document.getElementById('msgWindow');
const input   = document.getElementById('msgInput');
if (!drawer) return;  // guest — skip
function openMsg()  { drawer.classList.add('open'); overlay.classList.add('show'); loadMyMessages(); }
function closeMsg() { drawer.classList.remove('open'); overlay.classList.remove('show'); }
document.getElementById('msgToggle')?.addEventListener('click', openMsg);
document.getElementById('msgClose')?.addEventListener('click', closeMsg);
overlay?.addEventListener('click', closeMsg);
function renderBubbles(messages) {
if (!messages.length) {
window_.innerHTML = `<div style="text-align:center; color:var(--brown-muted); padding:2rem 0;">
<div style="font-size:2rem; margin-bottom:8px;">💬</div>
No messages yet. Say hello! 👋
</div>`;
return;
}
window_.innerHTML = messages.map(m => {
const isOut = m.type === 'received';
return `<div class="msg-row ${isOut ? 'out' : 'in'}">
<div class="${isOut ? 'msg-bubble-out' : 'msg-bubble-in'}">${escapeHtml(m.text)}</div>
<span class="msg-time">${m.time}</span>
</div>`;
}).join('');
window_.scrollTop = window_.scrollHeight;
}
function escapeHtml(str) {
return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
async function loadMyMessages() {
window_.innerHTML = `<div style="text-align:center; color:var(--brown-muted); padding:2rem 0;">Loading…</div>`;
try {
const res  = await fetch('/api/my-messages', { headers: { 'Accept': 'application/json' } });
const data = await res.json();
renderBubbles(data.messages || []);
} catch {
window_.innerHTML = `<div style="text-align:center; color:#ef4444; padding:2rem 0;">Failed to load. Try again.</div>`;
}
}
window.sendMyMessage = async function () {
const text = input?.value?.trim();
if (!text) return;
input.value = '';
const row = document.createElement('div');
row.className = 'msg-row out';
row.innerHTML = `<div class="msg-bubble-out">${escapeHtml(text)}</div><span class="msg-time">Just now</span>`;
window_.appendChild(row);
window_.scrollTop = window_.scrollHeight;
try {
await fetch('/api/my-messages/send', {
method:  'POST',
headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
body:    JSON.stringify({ text }),
});
} catch {
row.querySelector('.msg-bubble-out').style.opacity = '0.5';
}
};
})();
}); // end DOMContentLoaded
</script>
@endsection