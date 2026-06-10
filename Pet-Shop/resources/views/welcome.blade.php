@extends('layouts.app')
@section('title', 'PawHaven — Pets, Supplies & Services')
@section('content')
{{-- ─── EXTRA STYLES ─── --}}
<style>
/* ── RESET / BASE ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
--brown-dark:   #2D241E;
--brown-mid:    #A68B6D;
--orange:       #E68A39;
--cream:        #FDF8F1;
--cream-border: #F3E9DC;
--white:        #ffffff;
--modal-z:      9999;
}
/* ── NAVBAR ── */
.navbar {
position: sticky; top: 0; z-index: 100;
background: var(--white);
border-bottom: 1px solid var(--cream-border);
padding: 0 1.5rem; height: 68px;
display: flex; align-items: center; justify-content: space-between;
box-shadow: 0 2px 12px rgba(45,36,30,.06);
}
.navbar-logo {
font-size: 1.35rem; font-weight: 800; color: var(--brown-dark);
text-decoration: none; display: flex; align-items: center; gap: .4rem;
}
.navbar-logo span { color: var(--orange); }
.navbar-links {
display: flex; align-items: center; gap: 2rem; list-style: none;
}
.navbar-links a {
font-size: .88rem; font-weight: 600; color: var(--brown-dark);
text-decoration: none; transition: color .2s;
}
.navbar-links a:hover { color: var(--orange); }
.navbar-actions { display: flex; align-items: center; gap: .75rem; }
.btn-nav-cart {
background: var(--brown-dark); color: var(--white);
padding: 8px 20px; border-radius: 99px; font-size: .82rem;
font-weight: 700; text-decoration: none;
}
.btn-nav-login {
background: transparent; color: var(--brown-dark);
padding: 8px 18px; border-radius: 99px; font-size: .82rem;
font-weight: 600; text-decoration: none;
border: 1.5px solid var(--cream-border);
cursor: pointer;
}
.btn-nav-login:hover {
border-color: var(--orange);
color: var(--orange);
}
.navbar-hamburger {
display: none; background: none; border: none;
cursor: pointer; padding: 6px; font-size: 1.5rem;
color: var(--brown-dark);
}
/* ── MODAL STYLES ── */
.modal-overlay {
position: fixed; top: 0; left: 0; right: 0; bottom: 0;
background: rgba(45, 36, 30, 0.6);
display: flex; align-items: center; justify-content: center;
z-index: var(--modal-z);
opacity: 1;
visibility: visible;   
pointer-events: auto;  
transition: opacity 0.3s ease;
}
.modal-overlay.hidden {
display: none;
opacity: 0;
visibility: hidden;
pointer-events: none;
}
.modal-content {
background: var(--white); padding: 32px; border-radius: 20px;
box-shadow: 0 20px 60px rgba(0,0,0,0.2);
max-width: 480px; width: 90%; position: relative;
animation: modalSlide 0.3s ease;
max-height: 90vh; overflow-y: auto;
}
@keyframes modalSlide {
from { transform: translateY(-20px); opacity: 0; }
to { transform: translateY(0); opacity: 1; }
}
.modal-close {
position: absolute; top: 16px; right: 16px;
background: none; border: none; font-size: 1.5rem;
color: var(--brown-mid); cursor: pointer;
width: 32px; height: 32px; border-radius: 50%;
display: flex; align-items: center; justify-content: center;
transition: background .2s;
}
.modal-close:hover { background: var(--cream-border); color: var(--brown-dark); }
/* ── AUTH MODAL STYLES ── */
.auth-modal-form { display: block; }
.auth-modal-form.hidden { display: none; }
.auth-title {
font-family: 'Playfair Display', serif;
font-size: 1.5rem; font-weight: 700;
color: var(--brown-dark); text-align: center;
margin-bottom: 8px;
}
.auth-subtitle {
text-align: center; color: var(--brown-mid);
font-size: .9rem; margin-bottom: 24px;
}
.auth-input-group { margin-bottom: 16px; }
.auth-input-group label {
display: block; color: var(--brown-dark);
font-weight: 600; font-size: .85rem;
margin-bottom: 6px;
}
.auth-input-group input {
width: 100%; padding: 12px;
border: 1px solid var(--cream-border);
border-radius: 12px; background: var(--cream);
color: var(--brown-dark); font-size: 1rem;
outline: none; transition: border-color .2s;
}
.auth-input-group input:focus {
border-color: var(--orange);
box-shadow: 0 0 0 3px rgba(230, 138, 57, 0.15);
}
/* ── PASSWORD WRAPPER (eye toggle) ── */
.pw-wrapper {
position: relative; display: flex; align-items: center;
}
.pw-wrapper input {
padding-right: 44px !important;
width: 100%;
}
.pw-toggle {
position: absolute; right: 12px;
background: none; border: none; cursor: pointer;
color: var(--brown-mid); padding: 4px;
display: flex; align-items: center; justify-content: center;
transition: color .2s;
}
.pw-toggle:hover { color: var(--orange); }
.pw-toggle svg { width: 20px; height: 20px; pointer-events: none; }
/* ── PASSWORD STRENGTH HINTS ── */
.pw-hints {
margin-top: 10px;
display: grid;
grid-template-columns: 1fr 1fr;
gap: 6px 12px;
}
.pw-hint {
display: flex;
align-items: center;
gap: 6px;
font-size: .75rem;
color: #b09884;
transition: color .25s;
}
.pw-hint.met {
color: #16a34a;
}
.pw-hint-dot {
width: 16px; height: 16px;
border-radius: 50%;
border: 1.5px solid #d6c6b8;
display: flex; align-items: center; justify-content: center;
flex-shrink: 0;
font-size: 9px; font-weight: 700; color: transparent;
transition: background .25s, border-color .25s, color .25s;
}
.pw-hint.met .pw-hint-dot {
background: #16a34a;
border-color: #16a34a;
color: white;
}
.auth-btn {
width: 100%; background: var(--orange);
color: white; border: none; padding: 14px;
border-radius: 30px; font-size: 1rem;
font-weight: 700; cursor: pointer;
transition: background .2s, transform .2s;
}
.auth-btn:hover {
background: #cf7830;
transform: translateY(-2px);
}
.auth-btn:disabled {
background: var(--cream-border);
cursor: not-allowed;
transform: none;
}
/* ── AUTH TOGGLE LINKS ── */
.auth-toggle {
text-align: center;
margin-top: 20px;
font-size: .9rem;
color: var(--brown-mid);
position: relative;
z-index: 10;
}
.auth-toggle a.switch-auth-link {
color: var(--orange) !important;
font-weight: 600 !important;
text-decoration: none !important;
cursor: pointer !important;
user-select: none;
display: inline-block;
padding: 4px 8px;
margin-left: 2px;
border-radius: 6px;
transition: all 0.2s ease;
pointer-events: auto !important;
position: relative;
z-index: 100;
background: transparent;
border: none;
font-family: inherit;
font-size: inherit;
}
.auth-toggle a.switch-auth-link:hover {
text-decoration: underline !important;
background: rgba(230, 138, 57, 0.1);
transform: translateY(-1px);
}
.auth-divider {
text-align: center; margin: 20px 0;
color: var(--brown-mid); font-size: .85rem;
position: relative;
}
.auth-divider::before,
.auth-divider::after {
content: ''; position: absolute; top: 50%;
width: 40%; height: 1px;
background: var(--cream-border);
}
.auth-divider::before { left: 0; }
.auth-divider::after { right: 0; }
.auth-social {
display: flex; gap: 12px; justify-content: center;
}
.auth-social-btn {
flex: 1; padding: 10px; border-radius: 12px;
border: 1px solid var(--cream-border);
background: var(--white); color: var(--brown-dark);
font-size: .85rem; font-weight: 600;
cursor: pointer; display: flex; align-items: center;
justify-content: center; gap: 6px;
transition: background .2s, border-color .2s;
}
.auth-social-btn:hover {
background: var(--cream);
border-color: var(--orange);
}
.auth-error {
background: #fef2f2; border: 1px solid #fecaca;
color: #991b1b; padding: 12px; border-radius: 10px;
font-size: .85rem; margin-bottom: 16px; display: none;
}
.auth-success {
background: #f0fdf4; border: 1px solid #bbf7d0;
color: #166534; padding: 12px; border-radius: 10px;
font-size: .85rem; margin-bottom: 16px; display: none;
}
/* ── TRACKING RESULT MODAL ── */
.track-result { max-height: 70vh; overflow-y: auto; padding-right: 8px; }
.track-result::-webkit-scrollbar { width: 6px; }
.track-result::-webkit-scrollbar-thumb { background: var(--cream-border); border-radius: 3px; }
.status-badge {
display: inline-block; padding: 8px 24px; border-radius: 30px;
font-size: .9rem; font-weight: 700; color: white;
}
.timeline-step {
display: flex; align-items: center; gap: 12px;
padding: 12px 0; border-bottom: 1px solid var(--cream-border);
}
.timeline-step:last-child { border-bottom: none; }
.step-dot {
width: 14px; height: 14px; border-radius: 50%;
border: 3px solid white; box-shadow: 0 0 0 2px var(--cream-border);
flex-shrink: 0;
}
.step-dot.active { box-shadow: 0 0 0 2px currentColor; }
.step-content { flex: 1; }
.step-title { font-weight: 600; color: var(--brown-dark); font-size: .9rem; }
.step-desc { font-size: .8rem; color: var(--brown-mid); }
/* ── HERO ── */
.hero {
background: var(--cream); padding: 5rem 1.5rem 4rem;
overflow: hidden; position: relative;
}
.hero-inner {
max-width: 1100px; margin: 0 auto;
display: grid; grid-template-columns: 1fr 1fr;
align-items: center; gap: 3rem;
}
.hero-label {
display: inline-block; background: #FDEBD0; color: var(--orange);
font-size: .72rem; font-weight: 800; text-transform: uppercase;
letter-spacing: .14em; padding: 5px 14px; border-radius: 99px;
margin-bottom: 1.25rem;
}
.hero-title {
font-size: clamp(2rem, 4vw, 3.1rem); font-weight: 800;
color: var(--brown-dark); line-height: 1.15;
margin-bottom: 1.25rem; letter-spacing: -.03em;
}
.hero-title em { font-style: normal; color: var(--orange); }
.hero-subtitle {
font-size: 1rem; color: var(--brown-mid); line-height: 1.7;
max-width: 460px; margin-bottom: 2rem;
}
.hero-ctas { display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; }
.btn-primary {
background: var(--orange); color: var(--white);
padding: 12px 28px; border-radius: 99px; font-size: .88rem;
font-weight: 700; text-decoration: none; display: inline-block;
transition: background .2s, transform .2s;
}
.btn-primary:hover { background: #cf7830; transform: translateY(-2px); }
.btn-secondary {
background: transparent; color: var(--brown-dark);
padding: 12px 28px; border-radius: 99px; font-size: .88rem;
font-weight: 700; text-decoration: none;
border: 2px solid var(--cream-border);
}
.btn-secondary:hover { border-color: var(--orange); color: var(--orange); }
.hero-stats {
display: flex; gap: 2rem; margin-top: 2.5rem;
padding-top: 2rem; border-top: 1px solid var(--cream-border);
}
.hero-stat-num { font-size: 1.6rem; font-weight: 800; color: var(--brown-dark); }
.hero-stat-label { font-size: .75rem; color: var(--brown-mid); font-weight: 600; }
.hero-visual { display: flex; justify-content: center; align-items: center; }
.hero-bubble-wrap {
display: grid; grid-template-columns: 1fr 1fr;
gap: 1rem; max-width: 400px; width: 100%;
}
.hero-bubble {
background: var(--white); border: 1px solid var(--cream-border);
border-radius: 1.5rem; padding: 1.25rem; text-align: center;
transition: box-shadow .2s, transform .2s;
}
.hero-bubble:hover { box-shadow: 0 8px 24px rgba(45,36,30,.10); transform: translateY(-4px); }
.hero-bubble-emoji { font-size: 2.8rem; margin-bottom: .5rem; display: block; }
.hero-bubble-name { font-size: .82rem; font-weight: 700; color: var(--brown-dark); }
.hero-bubble-sub { font-size: .7rem; color: var(--brown-mid); }
.hero-bubble.featured {
grid-column: span 2; display: flex; align-items: center;
gap: 1rem; text-align: left;
background: linear-gradient(135deg, #FDF2E9, #FEF8F0);
}
.hero-bubble.featured .hero-bubble-emoji { font-size: 3.2rem; margin: 0; }
.hero-bubble-badge {
display: inline-block; background: #FEF3C7; color: #92400E;
font-size: .62rem; font-weight: 700; text-transform: uppercase;
padding: 3px 8px; border-radius: 99px; margin-bottom: .3rem;
}
/* ── SECTIONS ── */
.section-label {
display: inline-block; background: #FDEBD0; color: var(--orange);
font-size: .7rem; font-weight: 800; text-transform: uppercase;
letter-spacing: .14em; padding: 5px 14px; border-radius: 99px;
margin-bottom: 1rem;
}
.section-header { margin-bottom: 2.5rem; }
.section-header h2 {
font-size: clamp(1.6rem, 3vw, 2.3rem); font-weight: 800;
color: var(--brown-dark); letter-spacing: -.03em;
}
.section-header h2 em { font-style: normal; color: var(--orange); }
.section-header p { color: var(--brown-mid); font-size: .95rem; }
.pets-section { padding: 6rem 1.5rem; background: var(--white); }
.pets-section .section-inner { max-width: 1200px; margin: 0 auto; }
.pets-grid {
display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
gap: 1.5rem; margin-bottom: 3rem;
}
.pet-card {
background: var(--white); border-radius: 1.5rem;
border: 1px solid var(--cream-border); overflow: hidden;
transition: box-shadow .2s, transform .2s;
}
.pet-card:hover { box-shadow: 0 8px 32px rgba(45,36,30,.10); transform: translateY(-3px); }
.pet-card-img {
background: #FDF2E9; height: 180px; display: flex;
align-items: center; justify-content: center; font-size: 4rem;
position: relative;
}
.pet-emoji { font-size: 4rem; }
.pet-badge {
position: absolute; top: 10px; right: 10px;
padding: 3px 10px; border-radius: 99px; font-size: 10px;
font-weight: 700; text-transform: uppercase;
}
.badge-popular { background: #E9F0FE; color: #1E40AF; }
.badge-new { background: #E9F7F2; color: #166534; }
.badge-rare { background: #FCE7F3; color: #9D174D; }
.badge-sale { background: #FEF9C3; color: #854D0E; }
.pet-card-body { padding: 1.25rem; }
.pet-category { font-size: .65rem; font-weight: 700; text-transform: uppercase; color: var(--brown-mid); }
.pet-name { font-size: 1rem; font-weight: 700; color: var(--brown-dark); margin: .4rem 0; }
.pet-desc { font-size: .8rem; color: #8c7e74; line-height: 1.5; margin-bottom: 1rem; }
.pet-footer { display: flex; align-items: center; justify-content: space-between; }
.pet-price { font-size: 1.1rem; font-weight: 700; color: var(--orange); }
.btn-adopt {
background: var(--brown-dark); color: var(--white);
padding: 6px 14px; border-radius: 99px; font-size: .75rem;
font-weight: 700; text-decoration: none;
}
.btn-adopt:hover { background: var(--orange); }
.pets-cta { text-align: center; }
.about-strip { background: var(--brown-dark); padding: 5rem 1.5rem; }
.strip-inner {
max-width: 1100px; margin: 0 auto; display: grid;
grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;
}
.strip-text .section-label { background: rgba(230,138,57,.18); color: #f9a660; }
.strip-text h2 { color: var(--white); }
.strip-text h2 em { color: var(--orange); }
.strip-text p { color: #c8b49e; font-size: .95rem; line-height: 1.7; }
.strip-pillars { display: flex; flex-direction: column; gap: 1.5rem; }
.pillar {
background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.09);
border-radius: 1rem; padding: 1.25rem 1.5rem;
display: flex; gap: 1rem; align-items: flex-start;
}
.pillar-icon { font-size: 1.6rem; flex-shrink: 0; }
.pillar h4 { font-size: .95rem; font-weight: 700; color: var(--white); }
.pillar p { font-size: .8rem; color: #b09884; line-height: 1.5; }
.products-section { padding: 6rem 1.5rem; background: var(--cream); }
.products-section .section-inner { max-width: 1200px; margin: 0 auto; }
.products-grid-landing {
display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
gap: 1.5rem; margin-bottom: 3rem;
}
.product-card-landing {
background: var(--white); border-radius: 1.5rem;
border: 1px solid var(--cream-border); overflow: hidden;
}
.product-card-landing:hover { box-shadow: 0 8px 32px rgba(45,36,30,.10); transform: translateY(-3px); }
.product-card-img-lnd {
background: #FDF2E9; height: 130px; display: flex;
align-items: center; justify-content: center; font-size: 3.5rem;
position: relative;
}
.product-badge-lnd {
position: absolute; top: 10px; right: 10px;
padding: 3px 10px; border-radius: 99px; font-size: 10px;
font-weight: 700; text-transform: uppercase;
}
.badge-bestseller-lnd { background:#FEF3C7; color:#92400E; }
.badge-popular-lnd { background:#E9F0FE; color:#1E40AF; }
.badge-new-lnd { background:#E9F7F2; color:#166534; }
.product-card-body-lnd { padding: 1.25rem; }
.product-category-lnd { font-size:.65rem; font-weight:700; text-transform:uppercase; color:var(--brown-mid); }
.product-name-lnd { font-size:1rem; font-weight:700; color:var(--brown-dark); margin:.4rem 0; }
.product-desc-lnd { font-size:.8rem; color:#8c7e74; line-height:1.5; margin-bottom:1rem; }
.product-footer-lnd { display:flex; align-items:center; justify-content:space-between; }
.product-price-lnd { font-size:1.1rem; font-weight:700; color:var(--orange); }
.btn-shop-lnd {
background:var(--brown-dark); color:var(--white); padding:6px 14px;
border-radius:99px; font-size:.75rem; font-weight:700; text-decoration:none;
}
.btn-shop-lnd:hover { background:var(--orange); }

/* ── CONTACT SECTION ── */
.contact-section {
padding: 6rem 1.5rem;
background: var(--white);
}
.contact-wrapper {
display: grid;
grid-template-columns: 1.2fr 1fr;
gap: 3rem;
margin-top: 3rem;
align-items: start;
}
.contact-form-card {
background: var(--cream);
border: 1.5px solid var(--cream-border);
border-radius: 1.5rem;
padding: 2.5rem;
}
.contact-form-group {
margin-bottom: 1.25rem;
}
.contact-form-group label {
display: block;
font-weight: 600;
color: var(--brown-dark);
margin-bottom: 0.5rem;
font-size: 0.9rem;
}
.contact-form-group input,
.contact-form-group textarea {
width: 100%;
padding: 12px 16px;
border: 1.5px solid var(--cream-border);
border-radius: 12px;
background: var(--white);
color: var(--brown-dark);
font-size: 0.95rem;
font-family: inherit;
transition: border-color 0.2s, box-shadow 0.2s;
}
.contact-form-group input:focus,
.contact-form-group textarea:focus {
outline: none;
border-color: var(--orange);
box-shadow: 0 0 0 3px rgba(230, 138, 57, 0.15);
}
.contact-form-group textarea {
resize: vertical;
min-height: 120px;
}
.contact-submit-btn {
width: 100%;
background: var(--orange);
color: white;
border: none;
padding: 14px;
border-radius: 30px;
font-size: 1rem;
font-weight: 700;
cursor: pointer;
transition: background 0.2s, transform 0.2s;
}
.contact-submit-btn:hover {
background: #cf7830;
transform: translateY(-2px);
}
.contact-submit-btn:disabled {
background: var(--cream-border);
cursor: not-allowed;
transform: none;
}
.contact-msg {
padding: 12px;
border-radius: 10px;
font-size: 0.85rem;
margin-bottom: 16px;
display: none;
}
.contact-msg.success {
background: #f0fdf4;
border: 1px solid #bbf7d0;
color: #166534;
}
.contact-msg.error {
background: #fef2f2;
border: 1px solid #fecaca;
color: #991b1b;
}
.contact-info-stack {
display: flex;
flex-direction: column;
gap: 1.25rem;
}
.contact-card-horizontal {
background: var(--cream);
border: 1.5px solid var(--cream-border);
border-radius: 1.25rem;
padding: 1.5rem;
text-decoration: none;
color: var(--brown-dark);
transition: all 0.3s ease;
display: flex;
align-items: center;
gap: 1rem;
}
.contact-card-horizontal:hover {
transform: translateY(-4px);
box-shadow: 0 8px 24px rgba(45,36,30,.08);
border-color: var(--orange);
background: var(--white);
}
.contact-card-horizontal .contact-icon {
width: 52px;
height: 52px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
flex-shrink: 0;
margin-bottom: 0;
}
.contact-card-horizontal h3 {
font-size: 1rem;
font-weight: 700;
margin: 0 0 2px 0;
}
.contact-card-horizontal p {
font-size: 0.85rem;
color: var(--brown-mid);
margin: 0;
}
.email-icon { background: #FEF3C7; color: #D97706; }
.fb-icon { background: #E9F0FE; color: #1877F2; }
.tt-icon { background: #F3E9DC; color: #000000; }

/* ── FOOTER ── */
footer { background:#2D241E; color:#A68B6D; padding:3rem 1.5rem; }
footer a { color:#A68B6D; text-decoration:none; font-size:.85rem; }
footer a:hover { color:var(--orange); }
/* ── RESPONSIVE ── */
@media (max-width: 900px) {
.hero-inner { grid-template-columns: 1fr; }
.hero-visual { display: none; }
.strip-inner { grid-template-columns: 1fr; gap: 2.5rem; }
.contact-wrapper { grid-template-columns: 1fr; }
.navbar-links { display: none; flex-direction: column;
position: absolute; top: 68px; left: 0; right: 0;
background: var(--white); padding: 1rem;
border-bottom: 1px solid var(--cream-border);
box-shadow: 0 4px 12px rgba(0,0,0,.1);
}
.navbar-links.show { display: flex; }
.navbar-hamburger { display: block; }
}
@media (max-width: 600px) {
.hero-stats { gap: 1.25rem; }
.hero-ctas { flex-direction: column; align-items: flex-start; }
}
</style>
{{-- ══════════════════════════════════════════════════════════
NAVBAR
═══════════════════════════════════════════════════════════ --}}
<nav class="navbar">
<a href="{{ route('home') }}" class="navbar-logo">🐾 Paw<span>Haven</span></a>
<ul class="navbar-links" id="navLinks">
<li><a href="#pets">Pets</a></li>
<li><a href="#supplies">Supplies</a></li>
<li><a href="#services">Services</a></li>
<li><a href="#about">About</a></li>
<li><a href="#contact">Contact</a></li>
</ul>
<div class="navbar-actions">
@auth
<a href="{{ route('shop') }}" class="btn-nav-login">My Account</a>
@else
<button type="button" class="btn-nav-login" id="openAuthModal">Log In</button>
@endauth
<a href="{{ route('shop') }}" class="btn-nav-cart"> Shop</a>
</div>
<button class="navbar-hamburger" id="navToggle" aria-label="Open menu">☰</button>
</nav>
{{-- ══════════════════════════════════════════════════════════
HERO
═══════════════════════════════════════════════════════════ --}}
<section class="hero" id="home">
<div class="hero-inner">
<div class="hero-text">
<div class="hero-label">🇵 Philippines' #1 Pet Shop</div>
<h1 class="hero-title">Find Your Perfect<br><em>Furry Companion</em></h1>
<p class="hero-subtitle">Ethically sourced pets, premium supplies, and professional grooming & vet services — all in one loving place.</p>
<div class="hero-ctas">
<a href="{{ route('shop', ['type' => 'pet']) }}" class="btn-primary">Shop Pets 🐶</a>
<a href="#services" class="btn-secondary">Our Services</a>
</div>
<div class="hero-stats">
<div><div class="hero-stat-num">5,000+</div><div class="hero-stat-label">Happy Pet Owners</div></div>
<div><div class="hero-stat-num">10 Yrs</div><div class="hero-stat-label">In Business</div></div>
<div><div class="hero-stat-num">100%</div><div class="hero-stat-label">Vet Certified</div></div>
</div>
</div>
<div class="hero-visual">
<div class="hero-bubble-wrap">
<div class="hero-bubble featured">
<span class="hero-bubble-emoji">🐕</span>
<div>
<div class="hero-bubble-badge">⭐ Featured</div>
<div class="hero-bubble-name">Golden Retriever Pup</div>
<div class="hero-bubble-sub">Vet checked · Vaccinated</div>
</div>
</div>
<div class="hero-bubble"><span class="hero-bubble-emoji">🐈</span><div class="hero-bubble-name">Kittens</div><div class="hero-bubble-sub">Ready to adopt</div></div>
<div class="hero-bubble"><span class="hero-bubble-emoji">🐟</span><div class="hero-bubble-name">Fish & Aquatics</div><div class="hero-bubble-sub">200+ varieties</div></div>
<div class="hero-bubble"><span class="hero-bubble-emoji"></span><div class="hero-bubble-name">Small Pets</div><div class="hero-bubble-sub">Hamsters, birds & more</div></div>
<div class="hero-bubble"><span class="hero-bubble-emoji">🛁</span><div class="hero-bubble-name">Grooming</div><div class="hero-bubble-sub">Book a session</div></div>
</div>
</div>
</div>
</section>
{{-- FEATURED PETS --}}
<section class="pets-section" id="pets">
<div class="section-inner">
<div class="section-header">
<div class="section-label">Meet Our Pets</div>
<h2>Find Your <em>New Best Friend</em></h2>
<p>Handpicked, healthy & ready to love you unconditionally.</p>
</div>
<div class="pets-grid">
@forelse($featuredPets as $pet)
<div class="pet-card">
<div class="pet-card-img">
@if($pet->image_path)
<img src="{{ Storage::url($pet->image_path) }}" alt="{{ $pet->name }}" style="width:100%;height:100%;object-fit:cover;">
@else
<span class="pet-emoji">{{ $pet->emoji }}</span>
@endif
<div class="pet-badge badge-{{ strtolower($pet->badge ?? 'popular') }}">{{ $pet->badge_label ?? 'Available' }}</div>
</div>
<div class="pet-card-body">
<div class="pet-category">{{ $pet->category }}</div>
<h3 class="pet-name">{{ $pet->name }}</h3>
<p class="pet-desc">{{ $pet->description }}</p>
<div class="pet-footer">
<span class="pet-price">₱{{ number_format($pet->price) }}</span>
<a href="{{ route('shop', ['addToCart' => 'pet-'.$pet->id]) }}" class="btn-adopt">Add to Cart 🛒</a>
</div>
</div>
</div>
@empty
<p style="text-align:center;color:var(--brown-mid);grid-column:1/-1;">No pets available right now.</p>
@endforelse
</div>
<div class="pets-cta">
<a href="{{ route('shop', ['type' => 'pet']) }}" class="btn-primary">View All Pets 🐾</a>
</div>
</div>
</section>
{{-- ABOUT STRIP --}}
<section class="about-strip" id="about">
<div class="strip-inner">
<div class="strip-text">
<div class="section-label">About PawHaven</div>
<h2>More Than Just a <em>Pet Store</em></h2>
<p>Since 2014, PawHaven has been the heart of pet care in the Philippines. We believe every animal deserves love, health, and the perfect home.</p>
<a href="#services" class="btn-primary">Discover Our Services</a>
</div>
<div class="strip-pillars">
<div class="pillar"><div class="pillar-icon">💚</div><div><h4>Ethically Sourced</h4><p>All our pets come from responsible, humane breeders.</p></div></div>
<div class="pillar"><div class="pillar-icon">🩺</div><div><h4>Vet Certified</h4><p>Every pet is health-checked & vaccinated before adoption.</p></div></div>
<div class="pillar"><div class="pillar-icon">💛</div><div><h4>After-Care Support</h4><p>We're here for you even after you bring your pet home.</p></div></div>
</div>
</div>
</section>
{{-- FEATURED SUPPLIES --}}
<section class="products-section" id="supplies">
<div class="section-inner">
<div class="section-header" style="text-align:center;">
<div class="section-label">Our Store</div>
<h2>Premium Supplies for <em>Happy Pets</em></h2>
<p>Everything your companion needs — food, toys, grooming, and more.</p>
</div>
<div class="products-grid-landing">
@forelse($featuredProducts as $product)
<div class="product-card-landing">
<div class="product-card-img-lnd">
@if($product->image_path)
<img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
@else
<span>{{ $product->emoji }}</span>
@endif
<span class="product-badge-lnd badge-{{ $product->badge ?? 'popular' }}-lnd">{{ $product->badge_label ?? 'Popular' }}</span>
</div>
<div class="product-card-body-lnd">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="product-category-lnd">{{ $product->category }}</div>
        
        {{-- Show available weight sizes if it's a Food item --}}
        @if($product->category === 'Food' && is_array($product->weight_options) && count($product->weight_options) > 0)
            <div style="font-size:9px; color:#92400E; background:#FEF9C3; border:1px solid #FDE68A; border-radius:6px; padding:2px 6px; font-weight:bold;">
                ⚖️ {{ collect($product->weight_options)->pluck('kg')->join(', ') }}kg
            </div>
        @endif
    </div>
    
    <h3 class="product-name-lnd">{{ $product->name }}</h3>
    <p class="product-desc-lnd">{{ $product->description }}</p>
    
    <div class="product-footer-lnd">
        @php
            $displayPrice = $product->price;
            $prefix = '';
            
            // If it has weight options, grab the lowest price and add "From"
            if ($product->category === 'Food' && is_array($product->weight_options) && count($product->weight_options) > 0) {
                $minPrice = collect($product->weight_options)->min('price');
                $displayPrice = $minPrice;
                $prefix = '<span style="font-size:0.75rem; color:var(--brown-mid); font-weight:normal;">From</span> ';
            }
        @endphp
        
        <span class="product-price-lnd">{!! $prefix !!}₱{{ number_format($displayPrice, 2) }}</span>
        <a href="{{ route('shop', ['addToCart' => 'supply-'.$product->id]) }}" class="btn-shop-lnd">Add to Cart</a>
    </div>
</div>
</div>
@empty
<p style="text-align:center;color:var(--brown-mid);grid-column:1/-1;">No supplies listed yet.</p>
@endforelse
</div>
<div style="text-align:center;">
<a href="{{ route('shop', ['type' => 'product']) }}" class="btn-primary">View All Products 🛍️</a>
</div>
</div>
</section>
{{-- SERVICES --}}
<section id="services" style="padding:6rem 1.5rem; background:#fff;">
<div style="max-width:1100px; margin:0 auto;">
<div class="section-header" style="text-align:center; margin-bottom:3rem;">
<div class="section-label">What We Offer</div>
<h2>Our <em>Pet Services</em></h2>
<p>Professional care tailored to keep your pet healthy and happy.</p>
</div>
<div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1.5rem;">
@forelse($services as $service)
<div style="background:#FDF8F1; border-radius:1.5rem; padding:2rem; border:1px solid #F3E9DC;">
@if($service->image_path)
    <div style="width:100%; height:160px; border-radius:1rem; overflow:hidden; margin-bottom:1rem;">
        <img src="{{ Storage::url($service->image_path) }}"
             alt="{{ $service->name }}"
             style="width:100%; height:100%; object-fit:cover;">
    </div>
@else
    <div style="font-size:2.5rem; margin-bottom:1rem;">{{ $service->icon }}</div>
@endif
<h3 style="font-size:1.1rem; font-weight:700; color:#2D241E; margin-bottom:.5rem;">{{ $service->name }}</h3>
<p style="font-size:.85rem; color:#8c7e74; line-height:1.6; margin-bottom:1.5rem;">{{ $service->description }}</p>
<div style="display:flex; align-items:center; justify-content:space-between;">
<span style="font-size:1.1rem; font-weight:700; color:#E68A39;">₱{{ number_format($service->price) }}</span>
<a href="{{ route('shop', ['addToCart' => 'service-'.$service->id]) }}" style="background:#E68A39; color:#fff; padding:6px 18px; border-radius:99px; font-size:.75rem; font-weight:700; text-decoration:none;">Book Now</a>
</div>
</div>
@empty
<p style="text-align:center;color:var(--brown-mid);grid-column:1/-1;">No services available right now.</p>
@endforelse
</div>
<div style="text-align:center; margin-top:2.5rem;">
<a href="{{ route('shop', ['type' => 'service']) }}" class="btn-primary">View All Services 📋</a>
</div>
</div>
</section>

{{-- ══════════════════════════════════════════════════════════
CONTACT US SECTION
═══════════════════════════════════════════════════════════ --}}
<section class="contact-section" id="contact">
    <div class="section-inner" style="max-width: 1100px; margin: 0 auto;">
        <div class="section-header" style="text-align: center;">
            <div class="section-label">Reach Out</div>
            <h2>Let's <em>Connect</em></h2>
            <p>Have questions about our pets, services, or your order? We'd love to hear from you!</p>
        </div>
        
        <div class="contact-wrapper">
            <!-- Left: Contact Form -->
            <div class="contact-form-card">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--brown-dark); margin-bottom: 0.5rem;">Send us a Message</h3>
                <p style="font-size: 0.9rem; color: var(--brown-mid); margin-bottom: 1.5rem;">Fill out the form below and our team will get back to you within 24 hours.</p>
                
                <div id="contactSuccess" class="contact-msg success"></div>
                <div id="contactError" class="contact-msg error"></div>
                
                <form id="contactForm">
                    @csrf
                    <div class="contact-form-group">
                        <label for="contactName">Your Name</label>
                        <input type="text" id="contactName" name="name" placeholder="Juan Dela Cruz" required>
                    </div>
                    <div class="contact-form-group">
                        <label for="contactEmail">Email Address</label>
                        <input type="email" id="contactEmail" name="email" placeholder="yourname@email.com" required>
                    </div>
                    <div class="contact-form-group">
                        <label for="contactMessage">Message</label>
                        <textarea id="contactMessage" name="message" placeholder="How can we help you today?" required></textarea>
                    </div>
                    <button type="submit" class="contact-submit-btn" id="contactSubmitBtn">Send Message ✉️</button>
                </form>
            </div>

            <!-- Right: Info Cards Stack -->
            <div class="contact-info-stack">
                <a href="mailto:support@pawhaven.ph" class="contact-card-horizontal">
                    <div class="contact-icon email-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <div>
                        <h3>Email Us</h3>
                        <p>support@pawhaven.ph</p>
                    </div>
                </a>

                <a href="https://facebook.com/pawhaven" target="_blank" class="contact-card-horizontal">
                    <div class="contact-icon fb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <div>
                        <h3>Facebook</h3>
                        <p>@PawHavenPH</p>
                    </div>
                </a>

                <a href="https://tiktok.com/@pawhaven" target="_blank" class="contact-card-horizontal">
                    <div class="contact-icon tt-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.84-.1z"/></svg>
                    </div>
                    <div>
                        <h3>TikTok</h3>
                        <p>@pawhaven</p>
                    </div>
                </a>
                
                <!-- Business Hours Card -->
                <div class="contact-form-card" style="padding: 1.5rem; background: var(--white); border: 1.5px dashed var(--cream-border);">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--brown-dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">🕒 Business Hours</h3>
                    <p style="font-size: 0.85rem; color: var(--brown-mid); line-height: 1.6; margin: 0;">
                        Monday - Friday: 9:00 AM - 6:00 PM<br>
                        Saturday: 10:00 AM - 4:00 PM<br>
                        Sunday: Closed
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer>
<div style="max-width:1100px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:2rem;">
<div>
<div style="font-size:1.3rem; font-weight:700; color:#fff; margin-bottom:.75rem;">🐾 PawHaven</div>
<p style="font-size:.85rem; line-height:1.6;">Your trusted pet shop since 2014. Ethically sourced, vet certified, always loving.</p>
</div>
<div>
<div style="font-weight:700; color:#fff; margin-bottom:.75rem; font-size:.85rem; text-transform:uppercase;">Pets</div>
<div style="display:flex; flex-direction:column; gap:.5rem; font-size:.85rem;">
<a href="{{ route('shop', ['type' => 'pet']) }}">All Pets</a>
<a href="{{ route('shop', ['type' => 'pet', 'category' => 'Dogs']) }}">Dogs</a>
<a href="{{ route('shop', ['type' => 'pet', 'category' => 'Cats']) }}">Cats</a>
</div>
</div>
<div>
<div style="font-weight:700; color:#fff; margin-bottom:.75rem; font-size:.85rem; text-transform:uppercase;">Supplies</div>
<div style="display:flex; flex-direction:column; gap:.5rem; font-size:.85rem;">
<a href="{{ route('shop', ['type' => 'product']) }}">All Products</a>
<a href="{{ route('shop', ['type' => 'product', 'category' => 'Food']) }}">Food</a>
<a href="{{ route('shop', ['type' => 'product', 'category' => 'Toys']) }}">Toys</a>
</div>
</div>
<div>
<div style="font-weight:700; color:#fff; margin-bottom:.75rem; font-size:.85rem; text-transform:uppercase;">Help</div>
<div style="display:flex; flex-direction:column; gap:.5rem; font-size:.85rem;">
<a href="#" id="footerTrackOrder">Track Order</a>
<a href="mailto:support@pawhaven.ph">Contact Support</a>
</div>
</div>
</div>
<div style="text-align:center; margin-top:2.5rem; padding-top:1.5rem; border-top:1px solid #3d3028; font-size:.8rem;">
© {{ date('Y') }} PawHaven. All rights reserved.
</div>
</footer>

{{-- ══════════════════════════════════════════════════════════
AUTH MODAL (Login / Signup) - RESTORED HTML
═══════════════════════════════════════════════════════════ --}}
<div id="authModal" class="modal-overlay hidden">
    <div class="modal-content">
        <button class="modal-close" id="closeAuthModal">&times;</button>
        
        {{-- LOGIN FORM --}}
        <div id="authLoginForm" class="auth-modal-form">
            <h3 class="auth-title">Welcome Back!</h3>
            <p class="auth-subtitle">Log in to access your PawHaven account</p>
            
            <div id="authLoginError" class="auth-error"></div>
            <div id="authLoginSuccess" class="auth-success"></div>
            
            <form id="loginForm">
                @csrf
                <div class="auth-input-group">
                    <label for="loginEmail">Email Address</label>
                    <input type="email" id="loginEmail" name="email" placeholder="yourname@email.com" required>
                </div>
                <div class="auth-input-group">
                    <label for="loginPassword">Password</label>
                    <div class="pw-wrapper">
                        <input type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                        <button type="button" class="pw-toggle" data-target="loginPassword" aria-label="Show password">
                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; font-size:.85rem;">
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer; color:var(--brown-mid);"><input type="checkbox" id="rememberMe" name="remember" style="accent-color:var(--orange);">Remember me</label>
                    <a href="#" style="color:var(--orange); text-decoration:none; font-weight:600;">Forgot password?</a>
                </div>
                <button type="submit" class="auth-btn" id="loginSubmitBtn">Log In to PawHaven</button>
            </form>
            <div class="auth-divider">or continue with</div>
            <div class="auth-social"><button type="button" class="auth-social-btn">🔵 Google</button><button type="button" class="auth-social-btn">📘 Facebook</button></div>
            <div class="auth-toggle">Don't have an account?<a class="switch-auth-link" data-switch-to="signup">Sign Up</a></div>
        </div>

        {{-- SIGNUP FORM --}}
        <div id="authSignupForm" class="auth-modal-form hidden">
            <h3 class="auth-title">Join PawHaven</h3>
            <p class="auth-subtitle">Create your account to start shopping</p>
            
            <div id="authSignupError" class="auth-error"></div>
            <div id="authSignupSuccess" class="auth-success"></div>
            
            <form id="signupForm">
                @csrf
                <div class="auth-input-group"><label for="signupName">Full Name</label><input type="text" id="signupName" name="name" placeholder="Juan Dela Cruz" required></div>
                <div class="auth-input-group"><label for="signupEmail">Email Address</label><input type="email" id="signupEmail" name="email" placeholder="yourname@email.com" required></div>
                <div class="auth-input-group">
                    <label for="signupPassword">Password</label>
                    <div class="pw-wrapper">
                        <input type="password" id="signupPassword" name="password" placeholder="••••••••" minlength="8" required>
                        <button type="button" class="pw-toggle" data-target="signupPassword" aria-label="Show password">
                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    <div class="pw-hints">
                        <div class="pw-hint" id="hint-length"><div class="pw-hint-dot">✓</div><span>8+ characters</span></div>
                        <div class="pw-hint" id="hint-upper"><div class="pw-hint-dot">✓</div><span>Uppercase (A–Z)</span></div>
                        <div class="pw-hint" id="hint-lower"><div class="pw-hint-dot">✓</div><span>Lowercase (a–z)</span></div>
                        <div class="pw-hint" id="hint-number"><div class="pw-hint-dot">✓</div><span>A number (0–9)</span></div>
                    </div>
                </div>
                <div class="auth-input-group">
                    <label for="signupPasswordConfirm">Confirm Password</label>
                    <div class="pw-wrapper">
                        <input type="password" id="signupPasswordConfirm" name="password_confirmation" placeholder="••••••••" minlength="8" required>
                        <button type="button" class="pw-toggle" data-target="signupPasswordConfirm" aria-label="Show password">
                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="auth-btn" id="signupSubmitBtn">Create Account</button>
            </form>
            <div class="auth-divider">or sign up with</div>
            <div class="auth-social"><button type="button" class="auth-social-btn">🔵 Google</button><button type="button" class="auth-social-btn">📘 Facebook</button></div>
            <div class="auth-toggle">Already have an account?<a class="switch-auth-link" data-switch-to="login">Sign In</a></div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
ORDER TRACKING MODAL
═══════════════════════════════════════════════════════════ --}}
<div id="trackOrderModal" class="modal-overlay hidden">
<div class="modal-content">
<button class="modal-close" id="closeTrackModal">&times;</button>
<div style="text-align:center; margin-bottom:24px;">
<div style="font-size:2.5rem; margin-bottom:.5rem;">🔍</div>
<h3 style="font-family:'Playfair Display',serif; color:var(--brown-dark); font-size:1.5rem;">Track Your Order</h3>
<p style="color:var(--brown-mid); font-size:.9rem;">Enter your Order ID and email to check status</p>
</div>
<div id="trackError" style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px; border-radius:10px; font-size:.85rem; margin-bottom:16px; display:none;"></div>
<form id="trackOrderForm">
@csrf
<div style="margin-bottom:16px;">
<label style="display:block; color:var(--brown-dark); font-weight:600; font-size:.85rem; margin-bottom:6px;">Order ID</label>
<input type="text" name="order_id" id="trackOrderId" placeholder="e.g., PH-ABC12345" required
style="width:100%; padding:12px; border:1px solid var(--cream-border); border-radius:12px; background:var(--cream); color:var(--brown-dark); font-size:1rem; outline:none;">
</div>
<div style="margin-bottom:24px;">
<label style="display:block; color:var(--brown-dark); font-weight:600; font-size:.85rem; margin-bottom:6px;">Email Address</label>
<input type="email" name="email" id="trackEmail" placeholder="yourname@email.com" required
style="width:100%; padding:12px; border:1px solid var(--cream-border); border-radius:12px; background:var(--cream); color:var(--brown-dark); font-size:1rem; outline:none;">
</div>
<button type="submit" id="trackSubmitBtn"
style="width:100%; background:var(--orange); color:white; border:none; padding:14px; border-radius:30px; font-size:1rem; font-weight:700; cursor:pointer;">
🔍 Track Order
</button>
</form>
<div id="trackLoading" style="display:none; text-align:center; padding:20px;">
<div style="font-size:1.5rem; margin-bottom:8px;">⏳</div>
<p style="color:var(--brown-mid);">Searching for your order...</p>
</div>
</div>
</div>
{{-- TRACKING RESULT MODAL --}}
<div id="trackResultModal" class="modal-overlay hidden">
<div class="modal-content" style="max-width:600px;">
<button class="modal-close" id="closeResultModal">&times;</button>
<div id="trackResultContent" class="track-result"></div>
</div>
</div>
{{-- DATA ATTRIBUTE FOR JS --}}
<div id="app-data"
data-track-base="/track"
data-ajax-url="{{ route('order.track.ajax') }}"
style="display:none;"></div>
{{-- ══════════════════════════════════════════════════════════
JAVASCRIPT
═══════════════════════════════════════════════════════════ --}}
<script>
const APP_DATA = document.getElementById('app-data')?.dataset || {};
const WELCOME_TRACK_BASE_URL = APP_DATA.trackBase || '/track';
const WELCOME_TRACK_AJAX_URL = APP_DATA.ajaxUrl || '/track/ajax';
function getCsrfToken() {
return document.querySelector('meta[name="csrf-token"]')?.content
|| document.querySelector('input[name="_token"]')?.value
|| '';
}
document.addEventListener('DOMContentLoaded', function() {
// ============ PASSWORD EYE TOGGLE ============
document.querySelectorAll('.pw-toggle').forEach(function(btn) {
btn.addEventListener('click', function() {
const input    = document.getElementById(this.dataset.target);
if (!input) return;
const eyeOpen   = this.querySelector('.eye-open');
const eyeClosed = this.querySelector('.eye-closed');
if (input.type === 'password') {
input.type = 'text';
if (eyeOpen)   eyeOpen.style.display   = 'none';
if (eyeClosed) eyeClosed.style.display = 'block';
this.setAttribute('aria-label', 'Hide password');
} else {
input.type = 'password';
if (eyeOpen)   eyeOpen.style.display   = 'block';
if (eyeClosed) eyeClosed.style.display = 'none';
this.setAttribute('aria-label', 'Show password');
}
});
});
// ============ PASSWORD STRENGTH HINTS ============
var signupPwInput = document.getElementById('signupPassword');
if (signupPwInput) {
signupPwInput.addEventListener('input', function() {
var val = this.value;
var checks = {
'hint-length': val.length >= 8,
'hint-upper':  /[A-Z]/.test(val),
'hint-lower':  /[a-z]/.test(val),
'hint-number': /[0-9]/.test(val)
};
Object.keys(checks).forEach(function(id) {
var el = document.getElementById(id);
if (el) el.classList.toggle('met', checks[id]);
});
});
}
// ============ MOBILE MENU ============
var navToggle = document.getElementById('navToggle');
var navLinks  = document.getElementById('navLinks');
if (navToggle && navLinks) {
navToggle.addEventListener('click', function(e) {
e.preventDefault();
e.stopPropagation();
navLinks.classList.toggle('show');
});
}
// ============ AUTH MODAL ============
var authModal       = document.getElementById('authModal');
var authLoginForm   = document.getElementById('authLoginForm');
var authSignupForm  = document.getElementById('authSignupForm');
var closeAuthModal  = document.getElementById('closeAuthModal');
var loginForm       = document.getElementById('loginForm');
var signupForm      = document.getElementById('signupForm');
var authLoginError    = document.getElementById('authLoginError');
var authSignupError   = document.getElementById('authSignupError');
var authLoginSuccess  = document.getElementById('authLoginSuccess');
var authSignupSuccess = document.getElementById('authSignupSuccess');
function resetHints() {
['hint-length','hint-upper','hint-lower','hint-number'].forEach(function(id) {
var el = document.getElementById(id);
if (el) el.classList.remove('met');
});
}
function resetEyeToggles() {
document.querySelectorAll('.pw-toggle').forEach(function(btn) {
var input = document.getElementById(btn.dataset.target);
if (input) input.type = 'password';
var eyeOpen   = btn.querySelector('.eye-open');
var eyeClosed = btn.querySelector('.eye-closed');
if (eyeOpen)   eyeOpen.style.display   = 'block';
if (eyeClosed) eyeClosed.style.display = 'none';
});
}
function openAuthModal(defaultTab) {
if (!authModal) return;
defaultTab = defaultTab || 'login';
authModal.classList.remove('hidden');   // removes display:none
document.body.style.overflow = 'hidden';
if (loginForm)  loginForm.reset();
if (signupForm) signupForm.reset();
if (authLoginError)    authLoginError.style.display    = 'none';
if (authSignupError)   authSignupError.style.display   = 'none';
if (authLoginSuccess)  authLoginSuccess.style.display  = 'none';
if (authSignupSuccess) authSignupSuccess.style.display = 'none';
resetEyeToggles();
resetHints();
if (defaultTab === 'signup') {
if (authLoginForm)  authLoginForm.classList.add('hidden');
if (authSignupForm) authSignupForm.classList.remove('hidden');
document.getElementById('signupName')?.focus();
} else {
if (authLoginForm)  authLoginForm.classList.remove('hidden');
if (authSignupForm) authSignupForm.classList.add('hidden');
document.getElementById('loginEmail')?.focus();
}
}
function closeAuthModalFn() {
if (!authModal) return;
authModal.classList.add('hidden');
document.body.style.overflow = '';
}
function switchAuthTab(to) {
if (to === 'signup') {
if (authLoginForm)  authLoginForm.classList.add('hidden');
if (authSignupForm) authSignupForm.classList.remove('hidden');
document.getElementById('signupName')?.focus();
} else {
if (authLoginForm)  authLoginForm.classList.remove('hidden');
if (authSignupForm) authSignupForm.classList.add('hidden');
document.getElementById('loginEmail')?.focus();
}
if (authLoginError)    authLoginError.style.display    = 'none';
if (authSignupError)   authSignupError.style.display   = 'none';
if (authLoginSuccess)  authLoginSuccess.style.display  = 'none';
if (authSignupSuccess) authSignupSuccess.style.display = 'none';
resetHints();
}
window.__switchAuthTab = switchAuthTab;
document.getElementById('openAuthModal')?.addEventListener('click', function(e) {
e.preventDefault();
openAuthModal('login');
});
closeAuthModal?.addEventListener('click', closeAuthModalFn);
authModal?.addEventListener('click', function(e) {
if (e.target === authModal) closeAuthModalFn();
});
if (authModal) {
authModal.addEventListener('click', function(e) {
var target = e.target.closest('.switch-auth-link');
if (target) {
e.preventDefault();
e.stopPropagation();
var switchTo = target.getAttribute('data-switch-to');
if (switchTo) switchAuthTab(switchTo);
return false;
}
}, true);
}
// ============ LOGIN FORM ============
loginForm?.addEventListener('submit', function(e) {
e.preventDefault();
const email = document.getElementById('loginEmail')?.value?.trim();
const password = document.getElementById('loginPassword')?.value;
const remember = document.getElementById('rememberMe')?.checked || false;
const submitBtn = document.getElementById('loginSubmitBtn');
if (!email || !password) {
if (authLoginError) {
authLoginError.textContent = '❌ Please enter your email and password.';
authLoginError.style.display = 'block';
}
return;
}
if (submitBtn) {
submitBtn.disabled = true;
submitBtn.textContent = 'Logging in...';
}
if (authLoginError) authLoginError.style.display = 'none';
if (authLoginSuccess) authLoginSuccess.style.display = 'none';
const formData = new FormData();
formData.append('email', email);
formData.append('password', password);
formData.append('remember', remember ? '1' : '0');
formData.append('_token', getCsrfToken());
fetch("{{ route('login') }}", {
method: 'POST',
headers: {
'X-CSRF-TOKEN': getCsrfToken(),
'Accept': 'application/json',
},
body: formData
})
.then(async (res) => {
const data = await res.json().catch(() => ({}));
if (res.ok && data.success) {
if (authLoginSuccess) {
authLoginSuccess.textContent = '✅ Login successful! Redirecting...';
authLoginSuccess.style.display = 'block';
}
setTimeout(() => window.location.href = data.redirect || "{{ route('shop') }}", 800);
}
else if (res.status === 422) {
if (submitBtn) {
submitBtn.disabled = false;
submitBtn.textContent = 'Log In to PawHaven';
}
let errorMsg = data.message || 'Invalid credentials.';
if (data.errors && data.errors.email) {
errorMsg = data.errors.email[0];
}
if (authLoginError) {
authLoginError.textContent = '❌ ' + errorMsg;
authLoginError.style.display = 'block';
}
}
else {
throw new Error(data.message || 'Unexpected server response.');
}
})
.catch((err) => {
console.error('Login fetch error:', err);
if (submitBtn) {
submitBtn.disabled = false;
submitBtn.textContent = 'Log In to PawHaven';
}
if (authLoginError) {
authLoginError.textContent = '❌ Connection error. Please try again.';
authLoginError.style.display = 'block';
}
});
});
// ============ SIGNUP FORM ============
signupForm?.addEventListener('submit', function(e) {
e.preventDefault();
const password = document.getElementById('signupPassword')?.value;
const confirm  = document.getElementById('signupPasswordConfirm')?.value;
const submitBtn = document.getElementById('signupSubmitBtn');
if (password.length < 8) {
if (authSignupError) { authSignupError.textContent = '❌ Password must be at least 8 characters.'; authSignupError.style.display = 'block'; }
return;
}
if (!/[A-Z]/.test(password)) {
if (authSignupError) { authSignupError.textContent = '❌ Password must include at least one uppercase letter (A–Z).'; authSignupError.style.display = 'block'; }
return;
}
if (!/[a-z]/.test(password)) {
if (authSignupError) { authSignupError.textContent = '❌ Password must include at least one lowercase letter (a–z).'; authSignupError.style.display = 'block'; }
return;
}
if (!/[0-9]/.test(password)) {
if (authSignupError) { authSignupError.textContent = '❌ Password must include at least one number (0–9).'; authSignupError.style.display = 'block'; }
return;
}
if (password !== confirm) {
if (authSignupError) { authSignupError.textContent = '❌ Passwords do not match.'; authSignupError.style.display = 'block'; }
return;
}
if (submitBtn) {
submitBtn.disabled = true;
submitBtn.textContent = 'Creating account...';
}
if (authSignupError) authSignupError.style.display = 'none';
if (authSignupSuccess) authSignupSuccess.style.display = 'none';
const formData = new FormData();
formData.append('name', document.getElementById('signupName')?.value?.trim());
formData.append('email', document.getElementById('signupEmail')?.value?.trim());
formData.append('password', password);
formData.append('password_confirmation', confirm);
formData.append('_token', getCsrfToken());
fetch("{{ route('register') }}", {
method: 'POST',
headers: {
'X-CSRF-TOKEN': getCsrfToken(),
'Accept': 'application/json'
},
body: formData
})
.then(async (res) => {
const data = await res.json().catch(() => ({}));
if (res.ok && data.success) {
if (authSignupSuccess) {
authSignupSuccess.textContent = '✅ Account created! Welcome to PawHaven 🎉';
authSignupSuccess.style.display = 'block';
}
setTimeout(() => window.location.href = data.redirect || "{{ route('shop') }}", 1500);
}
else if (res.status === 422) {
if (submitBtn) {
submitBtn.disabled = false;
submitBtn.textContent = 'Create Account';
}
let errorMsg = 'Registration failed.';
if (data.errors) {
errorMsg = Object.values(data.errors)[0][0];
} else if (data.message) {
errorMsg = data.message;
}
if (authSignupError) {
authSignupError.textContent = '❌ ' + errorMsg;
authSignupError.style.display = 'block';
}
}
else {
throw new Error('Unexpected error occurred.');
}
})
.catch((err) => {
if (submitBtn) {
submitBtn.disabled = false;
submitBtn.textContent = 'Create Account';
}
if (authSignupError) {
authSignupError.textContent = '❌ Connection error. Please try again.';
authSignupError.style.display = 'block';
}
});
});
// ============ SOCIAL LOGIN BUTTONS ============
document.querySelectorAll('.auth-social-btn').forEach(function(btn) {
btn.addEventListener('click', function() {
var provider = this.textContent.trim().split(' ')[1];
if (authLoginError)  authLoginError.style.display  = 'none';
if (authSignupError) authSignupError.style.display = 'none';
var successBox = authLoginSuccess || authSignupSuccess;
if (successBox) {
successBox.style.display = 'block';
successBox.textContent   = '🔄 Connecting to ' + provider + '...';
setTimeout(function() {
successBox.textContent = '✅ Connected with ' + provider + '!';
setTimeout(closeAuthModalFn, 1000);
}, 1500);
}
});
});
// ============ TRACKING MODAL ============
var trackModal         = document.getElementById('trackOrderModal');
var resultModal        = document.getElementById('trackResultModal');
var closeTrack         = document.getElementById('closeTrackModal');
var closeResult        = document.getElementById('closeResultModal');
var trackForm          = document.getElementById('trackOrderForm');
var trackError         = document.getElementById('trackError');
var trackLoading       = document.getElementById('trackLoading');
var trackResultContent = document.getElementById('trackResultContent');
function openTrackModal() {
if (!trackModal) return;
trackModal.classList.remove('hidden');
document.body.style.overflow = 'hidden';
if (trackError) trackError.style.display = 'none';
document.getElementById('trackOrderId')?.focus();
}
function closeTrackModalFn() {
if (!trackModal) return;
trackModal.classList.add('hidden');
document.body.style.overflow = '';
if (trackForm) trackForm.reset();
}
function openResultModal(html) {
if (trackResultContent) trackResultContent.innerHTML = html;
if (resultModal) { resultModal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
}
function closeResultModalFn() {
if (!resultModal) return;
resultModal.classList.add('hidden');
document.body.style.overflow = '';
}
document.getElementById('footerTrackOrder')?.addEventListener('click', function(e) {
e.preventDefault();
openTrackModal();
});
closeTrack?.addEventListener('click', closeTrackModalFn);
closeResult?.addEventListener('click', closeResultModalFn);
trackModal?.addEventListener('click', function(e) { if (e.target === trackModal) closeTrackModalFn(); });
resultModal?.addEventListener('click', function(e) { if (e.target === resultModal) closeResultModalFn(); });
trackForm?.addEventListener('submit', function(e) {
e.preventDefault();
if (trackError)   trackError.style.display   = 'none';
if (trackLoading) trackLoading.style.display = 'block';
var submitBtn = document.getElementById('trackSubmitBtn');
if (submitBtn) submitBtn.disabled = true;
fetch(WELCOME_TRACK_AJAX_URL, {
method: 'POST',
headers: { 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
body: new FormData(trackForm)
})
.then(function(res) { return res.json(); })
.then(function(data) {
if (trackLoading) trackLoading.style.display = 'none';
if (submitBtn) submitBtn.disabled = false;
if (!data.success) {
if (trackError) { trackError.textContent = data.message || 'Order not found.'; trackError.style.display = 'block'; }
return;
}
var order = data.order;
var itemsHtml = (order.items || []).map(function(item) {
return '<div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--cream-border);">'
+ '<span><strong>' + (item.icon || '📦') + '</strong> ' + item.name + ' ×' + item.quantity + '</span>'
+ '<span style="color:var(--orange);font-weight:600;">₱' + item.price + '</span></div>';
}).join('');
var resultHtml = `
<div style="text-align:center;margin-bottom:24px;">
<h3 style="font-family:'Playfair Display',serif;color:var(--brown-dark);font-size:1.3rem;">Order #${order.order_number}</h3>
<span class="status-badge" style="background:${order.status_color||'#6b7280'};margin-top:8px;">${order.status}</span>
</div>
<div style="background:var(--cream);padding:16px;border-radius:12px;margin-bottom:20px;">
<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:.85rem;">
<div><strong style="color:var(--brown-dark);">Customer:</strong><br>${order.customer_name}</div>
<div><strong style="color:var(--brown-dark);">Email:</strong><br>${order.email}</div>
<div style="grid-column:1/-1;"><strong style="color:var(--brown-dark);">Address:</strong><br>${order.shipping_address||'Not provided'}</div>
</div>
</div>
<div style="margin-bottom:20px;">
<strong style="color:var(--brown-dark);font-size:.9rem;">Items:</strong>
<div style="margin-top:8px;">${itemsHtml}</div>
<div style="display:flex;justify-content:space-between;padding-top:12px;font-weight:700;color:var(--brown-dark);border-top:2px solid var(--cream-border);">
<span>Total</span><span style="color:var(--orange);">₱${order.total}</span>
</div>
</div>
<div style="margin-bottom:20px;">
<strong style="color:var(--brown-dark);font-size:.9rem;">Timeline:</strong>
<div style="margin-top:12px;">
<div class="timeline-step"><div class="step-dot" style="background:#10b981;color:#10b981;"></div><div class="step-content"><div class="step-title">Order Placed</div><div class="step-desc">${order.ordered_at||'Just now'}</div></div></div>
<div class="timeline-step"><div class="step-dot ${order.timeline?.processing?'active':''}" style="background:${order.timeline?.processing?'#3b82f6':'var(--cream-border)'};color:${order.timeline?.processing?'#3b82f6':'var(--cream-border)'};"></div><div class="step-content"><div class="step-title" style="color:${order.timeline?.processing?'var(--brown-dark)':'var(--brown-mid)'};">Processing</div><div class="step-desc">Preparing your order</div></div></div>
<div class="timeline-step"><div class="step-dot ${order.timeline?.shipped?'active':''}" style="background:${order.timeline?.shipped?'#8b5cf6':'var(--cream-border)'};color:${order.timeline?.shipped?'#8b5cf6':'var(--cream-border)'};"></div><div class="step-content"><div class="step-title" style="color:${order.timeline?.shipped?'var(--brown-dark)':'var(--brown-mid)'};">Shipped</div><div class="step-desc">On the way to you</div></div></div>
<div class="timeline-step"><div class="step-dot ${order.timeline?.delivered?'active':''}" style="background:${order.timeline?.delivered?'#10b981':'var(--cream-border)'};color:${order.timeline?.delivered?'#10b981':'var(--cream-border)'};"></div><div class="step-content"><div class="step-title" style="color:${order.timeline?.delivered?'var(--brown-dark)':'var(--brown-mid)'};">Delivered</div><div class="step-desc">Order completed</div></div></div>
</div>
</div>
${order.tracking_notes?`<div style="background:#fffbeb;border-left:4px solid #f59e0b;padding:12px;border-radius:8px;"><p style="color:#92400e;margin:0;font-size:.85rem;"><strong>Note:</strong> ${order.tracking_notes}</p></div>`:''}
<div style="text-align:center;margin-top:20px;">
<a href="${WELCOME_TRACK_BASE_URL}/${order.order_number}" target="_blank" style="color:var(--orange);font-size:.85rem;font-weight:600;text-decoration:none;">View Full Details →</a>
</div>`;
openResultModal(resultHtml);
closeTrackModalFn();
})
.catch(function(err) {
console.error('Tracking error:', err);
if (trackLoading) trackLoading.style.display = 'none';
if (submitBtn) submitBtn.disabled = false;
if (trackError) { trackError.textContent = 'Connection error. Please try again.'; trackError.style.display = 'block'; }
});
});

// ============ CONTACT FORM ============
var contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();

        var btn       = document.getElementById('contactSubmitBtn');
        var successEl = document.getElementById('contactSuccess');
        var errorEl   = document.getElementById('contactError');

        if (successEl) successEl.style.display = 'none';
        if (errorEl)   errorEl.style.display   = 'none';

        btn.disabled    = true;
        btn.textContent = 'Sending...';

        fetch('/contact', {
            method:  'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept':       'application/json'
            },
            body: new FormData(contactForm)
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            btn.disabled    = false;
            btn.textContent = 'Send Message ✉️';

            if (data.success) {
                if (successEl) {
                    successEl.textContent  = '✅ Message sent! We\'ll get back to you within 24 hours.';
                    successEl.style.display = 'block';
                }
                contactForm.reset();
            } else {
                if (errorEl) {
                    errorEl.textContent  = '❌ Something went wrong. Please try again.';
                    errorEl.style.display = 'block';
                }
            }
        })
        .catch(function() {
            btn.disabled    = false;
            btn.textContent = 'Send Message ✉️';
            if (errorEl) {
                errorEl.textContent  = '❌ Connection error. Please try again.';
                errorEl.style.display = 'block';
            }
        });
    });
}
// Close all modals on Escape
document.addEventListener('keydown', function(e) {
if (e.key === 'Escape') { closeAuthModalFn(); closeTrackModalFn(); closeResultModalFn(); }
});
});
</script>
@endsection