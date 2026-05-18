@extends('layouts.app')

@section('title', 'PawHaven — Where Every Pet Finds a Home')

@section('content')

@php
// 1. Featured Pets (IDs 1-10 in shop catalog)
$featuredPets = [
    ['id'=>1, 'name'=>'Golden Retriever', 'emoji'=>'🐕', 'category'=>'Dogs', 'price'=>18000, 'badge'=>'popular', 'desc'=>'Friendly and loyal family companion.'],
    ['id'=>2, 'name'=>'Siamese Kitten', 'emoji'=>'🐱', 'category'=>'Cats', 'price'=>12000, 'badge'=>'new', 'desc'=>'Elegant and affectionate with blue eyes.'],
    ['id'=>5, 'name'=>'African Grey', 'emoji'=>'🦜', 'category'=>'Birds', 'price'=>45000, 'badge'=>'premium', 'desc'=>'Highly intelligent and impressive mimicry.'],
];

// 2. Essential Supplies (IDs 11-24 in shop catalog)
$essentialSupplies = [
    ['id'=>11, 'name'=>'Premium Kibble', 'emoji'=>'🍖', 'category'=>'Food', 'price'=>850, 'badge'=>'bestseller', 'desc'=>'High-protein formula for puppies.'],
    ['id'=>13, 'name'=>'Self-Cleaning Litter', 'emoji'=>'📦', 'category'=>'Accessories', 'price'=>4500, 'badge'=>'new', 'desc'=>'Hands-free maintenance.'],
    ['id'=>21, 'name'=>'Orthopedic Bed', 'emoji'=>'🛏️', 'category'=>'Accessories', 'price'=>2200, 'badge'=>'popular', 'desc'=>'Memory foam for joint support.'],
];

// 3. Services (IDs 25-28 in shop catalog) - ADDING 'id' HERE FIXES YOUR ERROR
$services = [
    [
        'id' => 25, 
        'title' => 'Full Grooming', 
        'icon' => '✂️', 
        'desc' => 'Complete bath, haircut, and nail trimming.',
    ],
    [
        'id' => 26, 
        'title' => 'Vet Checkup', 
        'icon' => '🩺', 
        'desc' => 'General health assessment by professionals.',
    ],
    [
        'id' => 27, 
        'title' => 'Pet Boarding', 
        'icon' => '🏨', 
        'desc' => 'Safe and comfortable overnight stays.',
    ],
];
@endphp
{{-- ─── EXTRA STYLES FOR PRODUCTS SECTION ─── --}}
<style>
/* ── PRODUCTS SECTION ── */
.products-section {
    padding: 6rem 1.5rem;
    background: var(--cream, #FDF8F1);
}
.products-section .section-inner {
    max-width: 1200px;
    margin: 0 auto;
}
.products-grid-landing {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}
.product-card-landing {
    background: #fff;
    border-radius: 1.5rem;
    border: 2px solid #F3E9DC;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s;
}
.product-card-landing:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(45,36,30,0.10);
    border-color: #EBD7BC;
}
.product-card-img-lnd {
    aspect-ratio: 1;
    background: #FDF8F1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    position: relative;
    border-bottom: 1px solid #F3E9DC;
}
.product-badge-lnd {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    font-size: 0.62rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 0.2rem 0.6rem;
    border-radius: 50px;
}
.badge-bestseller-lnd { background: #FEE2E2; color: #DC2626; }
.badge-new-lnd        { background: #E9F7F2; color: #34A853; }
.badge-popular-lnd    { background: #FDF2E9; color: #E68A39; }
.badge-fun-lnd        { background: #E9F0FE; color: #2563EB; }
.badge-premium-lnd    { background: #FEF9C3; color: #B45309; }
.badge-essential-lnd  { background: #CFFAFE; color: #0E7490; }

.product-card-body-lnd {
    padding: 1.2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.product-category-lnd {
    font-size: 0.68rem;
    font-weight: 900;
    color: #E68A39;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 0.3rem;
}
.product-name-lnd {
    font-size: 1rem;
    font-weight: 800;
    color: #2D241E;
    margin-bottom: 0.4rem;
    line-height: 1.3;
}
.product-desc-lnd {
    font-size: 0.8rem;
    color: #A68B6D;
    line-height: 1.55;
    flex: 1;
    margin-bottom: 0.9rem;
}
.product-footer-lnd {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}
.product-price-lnd {
    font-size: 1.1rem;
    font-weight: 800;
    color: #2D241E;
}
.btn-shop-lnd {
    background: #E68A39;
    color: white;
    border: none;
    padding: 0.45rem 1rem;
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 800;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    transition: background 0.2s, transform 0.15s;
    white-space: nowrap;
}
.btn-shop-lnd:hover {
    background: #CF7529;
    transform: scale(1.04);
}

@media (max-width: 768px) {
    .products-grid-landing { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
}
@media (max-width: 480px) {
    .products-grid-landing { grid-template-columns: 1fr; }
}
</style>

<!-- =================== NAVBAR =================== -->
<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-brand">
            <span class="brand-icon">🐾</span>
            <span class="brand-text">PawHaven</span>
        </a>

        <ul class="nav-links">
            <li><a href="#about">About</a></li>
            <li><a href="#pets">Our Pets</a></li>
            <li><a href="#products">Our Products</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#testimonials">Reviews</a></li>
            <li><a href="#contact">Contact</a></li>
           <li><a href="{{ route('order.track') }}" class="nav-link">Track Order</a></li>
        </ul>

        <div class="nav-actions">
            @auth
                <span class="nav-welcome">Hi, {{ Auth::user()->name }}! 🐾</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-nav-outline">Log Out</button>
                </form>
            @else
                <button class="btn-nav-outline" id="openLoginBtn">Log In</button>
                <a href="#" id="navSignupBtn" class="btn-nav-filled">Sign Up</a>
            @endauth
        </div>

        <button class="hamburger" id="hamburger" aria-label="Open menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#about">About</a>
        <a href="#pets">Our Pets</a>
        <a href="#products">Our Products</a>
        <a href="#services">Services</a>
        <a href="#testimonials">Reviews</a>
        <a href="#contact">Contact</a>
        @guest
            <button class="btn-nav-outline mobile-login-btn" id="mobileLoginBtn">Log In</button>
        @endguest
    </div>
</nav>
<!-- =================== END NAVBAR =================== -->


<!-- =================== HERO =================== -->
<section class="hero" id="hero">
    <div class="hero-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="hero-inner">
        <div class="hero-content" data-aos="fade-up">
            <div class="hero-badge">🏆 #1 Trusted Pet Shop in the Philippines</div>
            <h1 class="hero-title">
                Find Your <em>Perfect</em><br />Furry Companion
            </h1>
            <p class="hero-desc">
                Discover a world where pets are treated like family. From adorable puppies to exotic birds,
                PawHaven is your one-stop destination for premium pets, supplies & care.
            </p>
            <div class="hero-actions">
                <a href="#pets" class="btn-primary">Explore Pets</a>
                <a href="#services" class="btn-ghost">Our Services</a>
            </div>

            <div class="hero-stats">
                <div class="stat">
                    <strong>500+</strong>
                    <span>Happy Customers</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <strong>50+</strong>
                    <span>Breeds Available</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <strong>10+</strong>
                    <span>Years of Love</span>
                </div>
            </div>
        </div>

        <div class="hero-visual" data-aos="fade-left">
            <div class="hero-card main-card">
                <div class="pet-emoji-large">🐕</div>
                <div class="card-info">
                    <span class="card-name">Golden Retriever</span>
                    <span class="card-price">₱18,000</span>
                </div>
                <div class="card-badge">Available Now</div>
            </div>
            <div class="hero-card side-card side-card-1">
                <span>🐈</span>
                <small>Persian Cat</small>
            </div>
            <div class="hero-card side-card side-card-2">
                <span>🦜</span>
                <small>African Grey</small>
            </div>
            <div class="floating-paw fp-1">🐾</div>
            <div class="floating-paw fp-2">🐾</div>
            <div class="floating-paw fp-3">🐾</div>
        </div>
    </div>

    <div class="scroll-indicator">
        <span>Scroll to explore</span>
        <div class="scroll-dot"></div>
    </div>
</section>
<!-- =================== END HERO =================== -->


<!-- =================== ABOUT STRIP =================== -->
<section class="about-strip" id="about">
    <div class="strip-inner">
        <div class="strip-text">
            <div class="section-label">About PawHaven</div>
            <h2>More Than Just a <em>Pet Store</em></h2>
            <p>
                Since 2014, PawHaven has been the heart of pet care in the Philippines. We believe every animal
                deserves love, health, and the perfect home. Our team of passionate pet experts ensures every
                visit — for you and your pet — is extraordinary.
            </p>
            <a href="#services" class="btn-primary">Discover Our Services</a>
        </div>
        <div class="strip-pillars">
            <div class="pillar">
                <div class="pillar-icon">💚</div>
                <h4>Ethically Sourced</h4>
                <p>All our pets come from responsible, humane breeders.</p>
            </div>
            <div class="pillar">
                <div class="pillar-icon">🩺</div>
                <h4>Vet Certified</h4>
                <p>Every pet is health-checked & vaccinated before adoption.</p>
            </div>
            <div class="pillar">
                <div class="pillar-icon">💛</div>
                <h4>After-Care Support</h4>
                <p>We're here for you even after you bring your pet home.</p>
            </div>
        </div>
    </div>
</section>
<!-- =================== END ABOUT STRIP =================== -->


<!-- =================== FEATURED PETS =================== -->
{{--
    IMPORTANT: Your HomeController must include an 'id' field in $featuredPets
    that matches the catalog IDs in shop.blade.php (1–10).

    Example in HomeController@index:
    $featuredPets = [
        ['id'=>1,  'emoji'=>'🐕', 'category'=>'Dogs',  'name'=>'Golden Retriever Puppy', 'badge'=>'Popular', 'desc'=>'...', 'price'=>'₱18,000'],
        ['id'=>2,  'emoji'=>'🐱', 'category'=>'Cats',  'name'=>'Siamese Kitten',          'badge'=>'New',     'desc'=>'...', 'price'=>'₱12,000'],
        ['id'=>5,  'emoji'=>'🦜', 'category'=>'Birds', 'name'=>'African Grey Parrot',     'badge'=>'Premium', 'desc'=>'...', 'price'=>'₱45,000'],
        ['id'=>10, 'emoji'=>'🐶', 'category'=>'Dogs',  'name'=>'Shih Tzu Puppy',          'badge'=>'Popular', 'desc'=>'...', 'price'=>'₱22,000'],
    ];
--}}
<section class="pets-section" id="pets">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-label">Meet Our Pets</div>
            <h2>Find Your <em>New Best Friend</em></h2>
            <p>Handpicked, healthy & ready to love you unconditionally.</p>
        </div>

        <div class="pets-grid">
            @foreach($featuredPets as $pet)
            <div class="pet-card">
                <div class="pet-card-img">
                    <span class="pet-emoji">{{ $pet['emoji'] }}</span>
                    <div class="pet-badge badge-{{ strtolower($pet['badge']) }}">{{ $pet['badge'] }}</div>
                </div>
                <div class="pet-card-body">
                    <div class="pet-category">{{ $pet['category'] }}</div>
                    <h3 class="pet-name">{{ $pet['name'] }}</h3>
                    <p class="pet-desc">{{ $pet['desc'] }}</p>
                    <div class="pet-footer">
                        <span class="pet-price">{{ $pet['price'] }}</span>
                        {{-- Clicking "Add to Cart" goes to the shop and auto-adds this pet --}}
                        <a href="{{ route('customer.shop', ['addToCart' => $pet['id']]) }}"
                           class="btn-adopt">
                            Add to Cart 🛒
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pets-cta">
            <a href="{{ route('customer.shop', ['type' => 'pet']) }}" class="btn-primary">View All Pets 🐾</a>
        </div>
    </div>
</section>
<!-- =================== END FEATURED PETS =================== -->
{{--
    pet-matcher.blade.php  (or drop the <section> block directly into welcome.blade.php)
    Usage: @include('partials.pet-matcher')
    Place it right after the FEATURED PETS section.
    No backend needed — pure JS quiz logic.
--}}

{{-- ================================================================
     PET MATCHER QUIZ — Styles
     These are quiz-specific. All shared vars (--g600, etc.)
     come from app.css already loaded in the admin layout.
     If this lives on the PUBLIC layout (app.blade.php), keep
     the :root block below; otherwise only the quiz classes matter.
     ================================================================ --}}
<style>
/* ── Root tokens (mirrors PawHaven's warm brand palette) ── */
:root {
    --cream:     #FDF8F1;
    --brown:     #2D241E;
    --orange:    #E68A39;
    --orange-dk: #CF7529;
    --muted:     #A68B6D;
    --card-br:   #F3E9DC;
    --green:     #34A853;
    --font-body: 'DM Sans', sans-serif;
    --font-head: 'DM Serif Display', serif;
}

/* ── Section wrapper ── */
.matcher-section {
    padding: 6rem 1.5rem;
    background: linear-gradient(160deg, #FDF8F1 60%, #FFF4E6 100%);
    position: relative;
    overflow: hidden;
}

/* Decorative floating paws behind everything */
.matcher-section::before {
    content: '🐾';
    position: absolute;
    font-size: 9rem;
    opacity: .04;
    top: -2rem;
    left: -2rem;
    pointer-events: none;
    transform: rotate(-20deg);
}
.matcher-section::after {
    content: '🐾';
    position: absolute;
    font-size: 9rem;
    opacity: .04;
    bottom: -2rem;
    right: -2rem;
    pointer-events: none;
    transform: rotate(15deg);
}

.matcher-inner {
    max-width: 780px;
    margin: 0 auto;
}

/* ── Section header ── */
.matcher-header { text-align: center; margin-bottom: 2.5rem; }
.matcher-header .section-label {
    display: inline-block;
    font-size: .72rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .12em;
    color: var(--orange);
    margin-bottom: .6rem;
}
.matcher-header h2 {
    font-family: var(--font-head);
    font-size: clamp(1.7rem, 4vw, 2.4rem);
    color: var(--brown);
    line-height: 1.2;
    margin-bottom: .6rem;
}
.matcher-header h2 em { font-style: italic; color: var(--orange); }
.matcher-header p { color: var(--muted); font-size: .95rem; }

/* ── Quiz card ── */
.quiz-card {
    background: #fff;
    border: 2px solid var(--card-br);
    border-radius: 2rem;
    padding: 2.5rem 2rem;
    box-shadow: 0 20px 60px rgba(45,36,30,.08);
    position: relative;
}

/* ── Progress bar ── */
.quiz-progress-wrap {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}
.quiz-progress-track {
    flex: 1;
    height: 6px;
    background: var(--card-br);
    border-radius: 99px;
    overflow: hidden;
}
.quiz-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--orange), #F4A35A);
    border-radius: 99px;
    transition: width .5s cubic-bezier(.4,0,.2,1);
}
.quiz-step-label {
    font-size: .75rem;
    font-weight: 700;
    color: var(--muted);
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── Step panel ── */
.quiz-step {
    display: none;
    animation: stepIn .35s ease;
}
.quiz-step.active { display: block; }
@keyframes stepIn {
    from { opacity: 0; transform: translateX(18px); }
    to   { opacity: 1; transform: none; }
}

.quiz-question {
    font-family: var(--font-head);
    font-size: clamp(1.1rem, 3vw, 1.5rem);
    color: var(--brown);
    margin-bottom: .4rem;
    line-height: 1.3;
}
.quiz-sub {
    font-size: .85rem;
    color: var(--muted);
    margin-bottom: 1.6rem;
}

/* ── Option grid ── */
.quiz-options {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: .85rem;
    margin-bottom: 1.75rem;
}

.quiz-option {
    border: 2px solid var(--card-br);
    border-radius: 1.2rem;
    padding: 1.1rem 1rem;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .5rem;
    text-align: center;
    background: var(--cream);
    transition: border-color .2s, background .2s, transform .18s, box-shadow .18s;
    user-select: none;
    -webkit-user-select: none;
}
.quiz-option:hover {
    border-color: #F4A35A;
    background: #FFFBF6;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(230,138,57,.12);
}
.quiz-option.selected {
    border-color: var(--orange);
    background: #FFF4E6;
    box-shadow: 0 0 0 4px rgba(230,138,57,.12);
    transform: translateY(-3px);
}
.quiz-option .opt-emoji { font-size: 2rem; line-height: 1; }
.quiz-option .opt-label {
    font-size: .875rem;
    font-weight: 700;
    color: var(--brown);
    line-height: 1.3;
}
.quiz-option .opt-sub {
    font-size: .72rem;
    color: var(--muted);
    line-height: 1.4;
}
/* Checkmark when selected */
.quiz-option .opt-check {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--orange);
    color: #fff;
    font-size: .7rem;
    display: none;
    align-items: center;
    justify-content: center;
    margin-top: .2rem;
    font-weight: 900;
}
.quiz-option.selected .opt-check { display: flex; }

/* ── Nav buttons ── */
.quiz-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.btn-quiz-back {
    background: none;
    border: 2px solid var(--card-br);
    border-radius: 50px;
    padding: .65rem 1.4rem;
    font-family: var(--font-body);
    font-size: .875rem;
    font-weight: 700;
    color: var(--muted);
    cursor: pointer;
    transition: border-color .2s, color .2s;
}
.btn-quiz-back:hover { border-color: var(--muted); color: var(--brown); }
.btn-quiz-next {
    background: var(--orange);
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: .7rem 2rem;
    font-family: var(--font-body);
    font-size: .9rem;
    font-weight: 800;
    cursor: pointer;
    transition: background .2s, transform .15s;
    margin-left: auto;
}
.btn-quiz-next:hover:not(:disabled) { background: var(--orange-dk); transform: scale(1.03); }
.btn-quiz-next:disabled { opacity: .4; cursor: not-allowed; transform: none; }

/* ── Result panel ── */
#quizResult { display: none; animation: stepIn .4s ease; }
#quizResult.active { display: block; }

.result-header { text-align: center; margin-bottom: 2rem; }
.result-header .result-emoji { font-size: 3.5rem; line-height: 1; margin-bottom: .5rem; }
.result-header h3 {
    font-family: var(--font-head);
    font-size: 1.5rem;
    color: var(--brown);
    margin-bottom: .4rem;
}
.result-header p { color: var(--muted); font-size: .9rem; max-width: 460px; margin: 0 auto; }

/* Result reasoning pill */
.result-reason {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: #E9F7F2;
    color: var(--green);
    border-radius: 99px;
    padding: .35rem .9rem;
    font-size: .75rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

/* Match cards grid */
.match-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}
.match-card {
    background: var(--cream);
    border: 2px solid var(--card-br);
    border-radius: 1.4rem;
    padding: 1.3rem 1rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .5rem;
    transition: transform .2s, box-shadow .2s, border-color .2s;
    position: relative;
    overflow: hidden;
}
.match-card:hover { transform: translateY(-5px); box-shadow: 0 14px 36px rgba(45,36,30,.1); border-color: #EBD7BC; }
.match-card .mc-emoji   { font-size: 3rem; line-height: 1; }
.match-card .mc-name    { font-weight: 800; font-size: .95rem; color: var(--brown); }
.match-card .mc-category{ font-size: .7rem; font-weight: 700; color: var(--orange); text-transform: uppercase; letter-spacing: .08em; }
.match-card .mc-why     { font-size: .75rem; color: var(--muted); line-height: 1.5; margin-top: .2rem; }
.match-card .mc-fit {
    position: absolute;
    top: .7rem; right: .7rem;
    font-size: .6rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .18rem .55rem;
    border-radius: 50px;
    background: #FEE2E2;
    color: #DC2626;
}
.match-card.best .mc-fit { background: #FEF9C3; color: #B45309; }

.match-card .mc-cta {
    margin-top: .4rem;
    background: var(--orange);
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: .42rem 1rem;
    font-family: var(--font-body);
    font-size: .77rem;
    font-weight: 800;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background .18s, transform .15s;
}
.match-card .mc-cta:hover { background: var(--orange-dk); transform: scale(1.04); }

/* Retake button */
.btn-retake {
    display: block;
    width: fit-content;
    margin: 0 auto;
    background: none;
    border: 2px solid var(--card-br);
    border-radius: 50px;
    padding: .65rem 1.6rem;
    font-family: var(--font-body);
    font-size: .875rem;
    font-weight: 700;
    color: var(--muted);
    cursor: pointer;
    transition: border-color .2s, color .2s;
}
.btn-retake:hover { border-color: var(--orange); color: var(--orange); }

/* ── Confetti canvas ── */
#quizConfetti {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 10;
    border-radius: 2rem;
}

@media (max-width: 540px) {
    .quiz-card { padding: 1.5rem 1rem; }
    .quiz-options { grid-template-columns: 1fr 1fr; }
    .match-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 380px) {
    .quiz-options { grid-template-columns: 1fr; }
    .match-grid   { grid-template-columns: 1fr; }
}
</style>

<!-- =================== PET MATCHER QUIZ =================== -->
<section class="matcher-section" id="pet-matcher">
    <div class="matcher-inner">

        <div class="matcher-header">
            <div class="section-label">🐾 Find Your Match</div>
            <h2>Not Sure Which Pet Is Right<br>for <em>Your Lifestyle?</em></h2>
            <p>Answer 3 quick questions and we'll recommend the perfect companion for you.</p>
        </div>

        <div class="quiz-card">

            {{-- Confetti canvas (positioned absolute inside card) --}}
            <canvas id="quizConfetti"></canvas>

            {{-- ── PROGRESS BAR ── --}}
            <div class="quiz-progress-wrap" id="quizProgressWrap">
                <div class="quiz-progress-track">
                    <div class="quiz-progress-fill" id="quizProgressFill" style="width:33%"></div>
                </div>
                <span class="quiz-step-label" id="quizStepLabel">Step 1 of 3</span>
            </div>

            {{-- ════════════════════════
                 STEP 1 — Living Space
                 ════════════════════════ --}}
            <div class="quiz-step active" id="step-1">
                <p class="quiz-question">🏠 How much living space do you have?</p>
                <p class="quiz-sub">Your home environment matters a lot for a pet's wellbeing.</p>
                <div class="quiz-options">
                    <div class="quiz-option" data-step="1" data-val="small" onclick="pickOption(this)">
                        <span class="opt-emoji">🏢</span>
                        <span class="opt-label">Small Apartment</span>
                        <span class="opt-sub">Studio or 1-bedroom, limited outdoor access</span>
                        <span class="opt-check">✓</span>
                    </div>
                    <div class="quiz-option" data-step="1" data-val="medium" onclick="pickOption(this)">
                        <span class="opt-emoji">🏠</span>
                        <span class="opt-label">Medium House</span>
                        <span class="opt-sub">2–3 bedrooms, small yard or patio</span>
                        <span class="opt-check">✓</span>
                    </div>
                    <div class="quiz-option" data-step="1" data-val="large" onclick="pickOption(this)">
                        <span class="opt-emoji">🏡</span>
                        <span class="opt-label">Large House</span>
                        <span class="opt-sub">Spacious yard, room to roam freely</span>
                        <span class="opt-check">✓</span>
                    </div>
                </div>
                <div class="quiz-nav">
                    <button class="btn-quiz-next" id="next1" disabled onclick="goStep(2)">Next →</button>
                </div>
            </div>

            {{-- ════════════════════════
                 STEP 2 — Activity Level
                 ════════════════════════ --}}
            <div class="quiz-step" id="step-2">
                <p class="quiz-question">🏃 How active is your lifestyle?</p>
                <p class="quiz-sub">This helps us match your energy with the right pet.</p>
                <div class="quiz-options">
                    <div class="quiz-option" data-step="2" data-val="low" onclick="pickOption(this)">
                        <span class="opt-emoji">🛋️</span>
                        <span class="opt-label">Couch Lover</span>
                        <span class="opt-sub">I prefer relaxing at home most of the time</span>
                        <span class="opt-check">✓</span>
                    </div>
                    <div class="quiz-option" data-step="2" data-val="medium" onclick="pickOption(this)">
                        <span class="opt-emoji">🚶</span>
                        <span class="opt-label">Moderately Active</span>
                        <span class="opt-sub">Regular walks, occasional outdoor activities</span>
                        <span class="opt-check">✓</span>
                    </div>
                    <div class="quiz-option" data-step="2" data-val="high" onclick="pickOption(this)">
                        <span class="opt-emoji">🏋️</span>
                        <span class="opt-label">Very Active</span>
                        <span class="opt-sub">Daily runs, hikes, outdoor adventures</span>
                        <span class="opt-check">✓</span>
                    </div>
                </div>
                <div class="quiz-nav">
                    <button class="btn-quiz-back" onclick="goStep(1)">← Back</button>
                    <button class="btn-quiz-next" id="next2" disabled onclick="goStep(3)">Next →</button>
                </div>
            </div>

            {{-- ════════════════════════
                 STEP 3 — Kids / Family
                 ════════════════════════ --}}
            <div class="quiz-step" id="step-3">
                <p class="quiz-question">👨‍👩‍👧 What's your family situation?</p>
                <p class="quiz-sub">Some pets are better suited for families with young children.</p>
                <div class="quiz-options">
                    <div class="quiz-option" data-step="3" data-val="no-kids" onclick="pickOption(this)">
                        <span class="opt-emoji">🧑</span>
                        <span class="opt-label">No Kids</span>
                        <span class="opt-sub">Living alone or with adults only</span>
                        <span class="opt-check">✓</span>
                    </div>
                    <div class="quiz-option" data-step="3" data-val="older-kids" onclick="pickOption(this)">
                        <span class="opt-emoji">👦</span>
                        <span class="opt-label">Older Kids</span>
                        <span class="opt-sub">Kids 8 and up who can interact responsibly</span>
                        <span class="opt-check">✓</span>
                    </div>
                    <div class="quiz-option" data-step="3" data-val="young-kids" onclick="pickOption(this)">
                        <span class="opt-emoji">👶</span>
                        <span class="opt-label">Young Kids</span>
                        <span class="opt-sub">Toddlers or children under 8 at home</span>
                        <span class="opt-check">✓</span>
                    </div>
                </div>
                <div class="quiz-nav">
                    <button class="btn-quiz-back" onclick="goStep(2)">← Back</button>
                    <button class="btn-quiz-next" id="next3" disabled onclick="showResult()">See My Match 🐾</button>
                </div>
            </div>

            {{-- ════════════════════════
                 RESULT PANEL
                 ════════════════════════ --}}
            <div id="quizResult">
                <div class="result-header">
                    <div class="result-emoji" id="resultEmoji">🐾</div>
                    <h3 id="resultTitle">Your Perfect Match!</h3>
                    <p id="resultDesc">Based on your lifestyle, here are our top picks for you.</p>
                    <br/>
                    <span class="result-reason" id="resultReason"></span>
                </div>
                <div class="match-grid" id="matchGrid"></div>
                <button class="btn-retake" onclick="retakeQuiz()">↩ Retake Quiz</button>
            </div>

        </div>{{-- /.quiz-card --}}
    </div>
</section>
<!-- =================== END PET MATCHER QUIZ =================== -->

<script>
/* ================================================================
   PET MATCHER — Quiz Logic
   ================================================================ */

/* ── All possible pet matches ─────────────────────────────────── */
const PET_DB = [
    {
        id: 1, name: 'Golden Retriever', emoji: '🐕', category: 'Dogs',
        why: 'Gentle, family-friendly, and loves outdoor play.',
        catalogId: 1,
        tags: { space: ['medium','large'], activity: ['medium','high'], kids: ['no-kids','older-kids','young-kids'] }
    },
    {
        id: 2, name: 'Siamese Kitten', emoji: '🐱', category: 'Cats',
        why: 'Elegant and affectionate, perfect for quieter homes.',
        catalogId: 2,
        tags: { space: ['small','medium'], activity: ['low','medium'], kids: ['no-kids','older-kids'] }
    },
    {
        id: 3, name: 'Persian Cat', emoji: '🐈', category: 'Cats',
        why: 'Calm and low-maintenance, loves cozy indoor life.',
        catalogId: 3,
        tags: { space: ['small','medium','large'], activity: ['low'], kids: ['no-kids','older-kids'] }
    },
    {
        id: 4, name: 'Labrador Puppy', emoji: '🐶', category: 'Dogs',
        why: 'Energetic, loves kids, and thrives with space to run.',
        catalogId: 1,
        tags: { space: ['medium','large'], activity: ['high'], kids: ['no-kids','older-kids','young-kids'] }
    },
    {
        id: 5, name: 'African Grey Parrot', emoji: '🦜', category: 'Birds',
        why: 'Highly intelligent and bonds deeply with adults.',
        catalogId: 5,
        tags: { space: ['small','medium'], activity: ['low','medium'], kids: ['no-kids'] }
    },
    {
        id: 6, name: 'Holland Lop Rabbit', emoji: '🐰', category: 'Small Pets',
        why: 'Gentle and quiet — ideal for apartments and young kids.',
        catalogId: 6,
        tags: { space: ['small','medium'], activity: ['low','medium'], kids: ['no-kids','older-kids','young-kids'] }
    },
    {
        id: 7, name: 'Border Collie', emoji: '🐕‍🦺', category: 'Dogs',
        why: 'Super smart and energetic — needs space and daily exercise.',
        catalogId: 1,
        tags: { space: ['large'], activity: ['high'], kids: ['no-kids','older-kids'] }
    },
    {
        id: 8, name: 'Shih Tzu', emoji: '🐩', category: 'Dogs',
        why: 'Small, friendly, and low-energy — great for any home.',
        catalogId: 1,
        tags: { space: ['small','medium','large'], activity: ['low','medium'], kids: ['no-kids','older-kids','young-kids'] }
    },
    {
        id: 9, name: 'Hamster', emoji: '🐹', category: 'Small Pets',
        why: 'Tiny, easy to care for, and endlessly entertaining.',
        catalogId: 6,
        tags: { space: ['small','medium'], activity: ['low'], kids: ['no-kids','older-kids','young-kids'] }
    },
    {
        id: 10, name: 'Cockatiel', emoji: '🦅', category: 'Birds',
        why: 'Cheerful and social — sings along to your daily routine.',
        catalogId: 5,
        tags: { space: ['small','medium','large'], activity: ['low','medium'], kids: ['no-kids','older-kids'] }
    },
];

/* ── Result copy based on answers ─────────────────────────────── */
const RESULT_COPY = {
    // [space]-[activity]-[kids]
    'small-low-no-kids':     { emoji:'😺', title:'The Peaceful Solo Companion', reason:'🏢 Cozy space + calm vibes = purr-fect.' },
    'small-low-older-kids':  { emoji:'🐰', title:'The Gentle Family Pet',        reason:'🐣 Easy-care pets fit your busy family.' },
    'small-low-young-kids':  { emoji:'🐹', title:'The Safe Starter Pet',         reason:'👶 Small and gentle for little hands.' },
    'small-medium-no-kids':  { emoji:'🦜', title:'The Chatty Apartment Buddy',   reason:'🏢 Smart birds thrive in cozy homes.' },
    'small-medium-older-kids':{ emoji:'🐩', title:'The Compact Family Dog',      reason:'👦 Small but full of love and energy.' },
    'small-medium-young-kids':{ emoji:'🐰', title:'The Apartment-Friendly Friend', reason:'👶 Gentle pets are safest for toddlers.' },
    'small-high-no-kids':    { emoji:'🐩', title:'The Energetic Compact Buddy',  reason:'🏋️ Even small dogs love active owners.' },
    'small-high-older-kids': { emoji:'🐩', title:'The Fun Family Pet',           reason:'👦 Active family, lively little dog.' },
    'small-high-young-kids': { emoji:'🐰', title:'The Safe Active Companion',    reason:'👶 Gentle but fun for active families.' },
    'medium-low-no-kids':    { emoji:'🐈', title:'The Elegant Indoor Companion', reason:'🛋️ Calm cats love a chill household.' },
    'medium-low-older-kids': { emoji:'🐱', title:'The Friendly Home Cat',        reason:'👦 Older kids get along great with cats.' },
    'medium-low-young-kids': { emoji:'🐹', title:'The Kid-Safe Starter Pet',     reason:'👶 Small pets are easy for young kids.' },
    'medium-medium-no-kids': { emoji:'🐕', title:'The Balanced Lifestyle Match', reason:'🚶 A happy medium for home and walks.' },
    'medium-medium-older-kids':{ emoji:'🐕', title:'The Classic Family Dog',     reason:'👨‍👩‍👧 The all-around family favourite.' },
    'medium-medium-young-kids':{ emoji:'🐩', title:'The Gentle Family Dog',      reason:'👶 Patient small dogs love gentle kids.' },
    'medium-high-no-kids':   { emoji:'🐕', title:'The Active Companion',         reason:'🏋️ You both love burning energy!' },
    'medium-high-older-kids':{ emoji:'🐕', title:'The Family Adventure Dog',     reason:'👦 Big energy + active family = bliss.' },
    'medium-high-young-kids':{ emoji:'🐶', title:'The Loyal Family Guard',       reason:'👶 Labs are famous for loving babies.' },
    'large-low-no-kids':     { emoji:'🐈', title:'The Regal Homebody',           reason:'🛋️ Big space, calm lifestyle — cat paradise.' },
    'large-low-older-kids':  { emoji:'🐕', title:'The Laid-Back Family Dog',     reason:'👦 Easygoing dogs love a big yard.' },
    'large-low-young-kids':  { emoji:'🐶', title:'The Gentle Giant Buddy',       reason:'👶 Calm large dogs are great with tots.' },
    'large-medium-no-kids':  { emoji:'🐕', title:'The All-Round Companion',      reason:'🏠 Space + balance = dog heaven.' },
    'large-medium-older-kids':{ emoji:'🐕', title:'The Backyard Best Friend',    reason:'👦 Room to play and kids to love.' },
    'large-medium-young-kids':{ emoji:'🐕', title:'The Safe Family Dog',         reason:'👶 Family dogs shine in big homes.' },
    'large-high-no-kids':    { emoji:'🐕‍🦺', title:'The Athletic Powerhouse',   reason:'🏋️ Big yard + high energy = Border Collie.' },
    'large-high-older-kids': { emoji:'🐕‍🦺', title:'The Adventure Family Dog',  reason:'👦 Smart energetic dogs love active kids.' },
    'large-high-young-kids': { emoji:'🐶', title:'The Loyal Family Protector',   reason:'👶 Labradors are legendary family dogs.' },
};

/* ── State ──────────────────────────────────────────────────────── */
const answers = { 1: null, 2: null, 3: null };

/* ── Pick an option ─────────────────────────────────────────────── */
function pickOption(el) {
    const step = parseInt(el.dataset.step);
    const val  = el.dataset.val;
    /* Deselect siblings */
    el.closest('.quiz-options').querySelectorAll('.quiz-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    answers[step] = val;
    /* Enable next button */
    document.getElementById('next' + step).disabled = false;
}

/* ── Navigate between steps ─────────────────────────────────────── */
function goStep(n) {
    document.querySelectorAll('.quiz-step').forEach(s => s.classList.remove('active'));
    document.getElementById('step-' + n).classList.add('active');
    /* Progress bar: step 1=33%, 2=66%, 3=100% */
    const pct = (n / 3) * 100;
    document.getElementById('quizProgressFill').style.width = pct + '%';
    document.getElementById('quizStepLabel').textContent = `Step ${n} of 3`;
    document.getElementById('quizProgressWrap').style.display = 'flex';
    document.getElementById('quizResult').classList.remove('active');
    document.getElementById('quizResult').style.display = 'none';
}

/* ── Show result ─────────────────────────────────────────────────── */
function showResult() {
    const key   = `${answers[1]}-${answers[2]}-${answers[3]}`;
    const copy  = RESULT_COPY[key] || { emoji:'🐾', title:'A Wonderful Match Awaits!', reason:'🐾 Any pet would love your home.' };

    /* Filter pets matching ALL 3 answers */
    const matches = PET_DB.filter(p =>
        p.tags.space.includes(answers[1]) &&
        p.tags.activity.includes(answers[2]) &&
        p.tags.kids.includes(answers[3])
    ).slice(0, 4); /* Max 4 shown */

    /* Fallback: show top 3 most broadly matched */
    const shown = matches.length ? matches : PET_DB.slice(0, 3);

    /* Populate result UI */
    document.getElementById('resultEmoji').textContent = copy.emoji;
    document.getElementById('resultTitle').textContent = copy.title;
    document.getElementById('resultDesc').textContent  =
        `Based on your lifestyle, here ${shown.length === 1 ? 'is our top pick' : 'are our top picks'} for you.`;
    document.getElementById('resultReason').textContent = copy.reason;

    document.getElementById('matchGrid').innerHTML = shown.map((pet, i) => `
        <div class="match-card ${i === 0 ? 'best' : ''}">
            <span class="mc-fit">${i === 0 ? '⭐ Best Match' : 'Great Fit'}</span>
            <div class="mc-emoji">${pet.emoji}</div>
            <div class="mc-category">${pet.category}</div>
            <div class="mc-name">${pet.name}</div>
            <div class="mc-why">${pet.why}</div>
            <a href="/shop?addToCart=${pet.catalogId}" class="mc-cta">View Pet 🐾</a>
        </div>`
    ).join('');

    /* Hide steps, show result */
    document.querySelectorAll('.quiz-step').forEach(s => s.classList.remove('active'));
    document.getElementById('quizProgressWrap').style.display = 'none';
    const result = document.getElementById('quizResult');
    result.style.display = 'block';
    result.classList.add('active');

    /* Confetti! */
    fireConfetti();
}

/* ── Retake quiz ─────────────────────────────────────────────────── */
function retakeQuiz() {
    answers[1] = answers[2] = answers[3] = null;
    document.querySelectorAll('.quiz-option').forEach(o => o.classList.remove('selected'));
    ['next1','next2','next3'].forEach(id => document.getElementById(id).disabled = true);
    document.getElementById('quizResult').style.display = 'none';
    document.getElementById('quizResult').classList.remove('active');
    goStep(1);
}

/* ── Mini confetti burst ─────────────────────────────────────────── */
function fireConfetti() {
    const canvas = document.getElementById('quizConfetti');
    const ctx    = canvas.getContext('2d');
    const card   = canvas.parentElement;
    canvas.width  = card.offsetWidth;
    canvas.height = card.offsetHeight;

    const COLORS = ['#E68A39','#F4A35A','#34A853','#FEF9C3','#FEE2E2','#2D241E'];
    const particles = Array.from({length: 80}, () => ({
        x:  Math.random() * canvas.width,
        y: -10,
        r:  Math.random() * 6 + 3,
        color: COLORS[Math.floor(Math.random() * COLORS.length)],
        speed: Math.random() * 3 + 1.5,
        spin:  Math.random() * 0.2 - 0.1,
        angle: Math.random() * Math.PI * 2,
        drift: Math.random() * 2 - 1,
    }));

    let frame = 0;
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.angle);
            ctx.fillStyle = p.color;
            ctx.globalAlpha = Math.max(0, 1 - frame / 90);
            ctx.fillRect(-p.r / 2, -p.r, p.r, p.r * 2);
            ctx.restore();
            p.y     += p.speed;
            p.x     += p.drift;
            p.angle += p.spin;
        });
        frame++;
        if (frame < 100) requestAnimationFrame(draw);
        else ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
    draw();
}
</script>

<!-- =================== OUR PRODUCTS =================== -->
<section class="products-section" id="products">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-label">Our Products</div>
            <h2>Premium Supplies for <em>Happy Pets</em></h2>
            <p>Everything your companion needs — food, toys, grooming, and more.</p>
        </div>

        @php
        // catalogId matches the 'id' field in the shop catalog (shop.blade.php)
        $featuredProducts = [
            ['catalogId' => 11, 'name' => 'Premium Puppy Kibble',    'emoji' => '🍖', 'category' => 'Food',        'badge' => 'bestseller', 'badgeLabel' => 'Bestseller', 'desc' => 'High-protein formula specially crafted for healthy, growing puppies.',             'price' => '₱850'],
            ['catalogId' => 12, 'name' => 'Interactive Cat Wand',     'emoji' => '🧶', 'category' => 'Toys',        'badge' => 'fun',        'badgeLabel' => 'Fun',        'desc' => 'Feather wand toy to keep your feline entertained and active for hours.',          'price' => '₱350'],
            ['catalogId' => 14, 'name' => 'Grooming Brush Set',       'emoji' => '🪮', 'category' => 'Grooming',    'badge' => 'popular',    'badgeLabel' => 'Popular',    'desc' => '3-piece set for all coat types — includes slicker brush, comb, and deshedder.', 'price' => '₱1,200'],
            ['catalogId' => 13, 'name' => 'Self-Cleaning Litter Box', 'emoji' => '📦', 'category' => 'Accessories', 'badge' => 'new',        'badgeLabel' => 'New',        'desc' => 'Automatic self-cleaning mechanism for completely hassle-free maintenance.',       'price' => '₱4,500'],
            ['catalogId' => 20, 'name' => 'Pet Vitamin Drops',        'emoji' => '💊', 'category' => 'Health',      'badge' => 'essential',  'badgeLabel' => 'Essential',  'desc' => 'Daily multivitamin liquid drops for dogs and cats. Easy to administer.',         'price' => '₱480'],
            ['catalogId' => 21, 'name' => 'Orthopedic Dog Bed',       'emoji' => '🛏️', 'category' => 'Accessories', 'badge' => 'popular',    'badgeLabel' => 'Popular',    'desc' => 'Memory foam bed that supports joints. Removable and machine-washable cover.',    'price' => '₱2,200'],
            ['catalogId' => 24, 'name' => 'Automatic Pet Feeder',     'emoji' => '🤖', 'category' => 'Accessories', 'badge' => 'new',        'badgeLabel' => 'New',        'desc' => 'Programmable feeder with 4L hopper. Wi-Fi app control for scheduled meals.',    'price' => '₱3,800'],
            ['catalogId' => 16, 'name' => 'Hamster Exercise Wheel',   'emoji' => '🎡', 'category' => 'Toys',        'badge' => 'fun',        'badgeLabel' => 'Fun',        'desc' => 'Silent spinner wheel, 8-inch diameter. Perfect for hamsters and small pets.',    'price' => '₱650'],
        ];
        @endphp

        <div class="products-grid-landing">
            @foreach($featuredProducts as $product)
            <div class="product-card-landing">
                <div class="product-card-img-lnd">
                    <span>{{ $product['emoji'] }}</span>
                    <span class="product-badge-lnd badge-{{ $product['badge'] }}-lnd">{{ $product['badgeLabel'] }}</span>
                </div>
                <div class="product-card-body-lnd">
                    <div class="product-category-lnd">{{ $product['category'] }}</div>
                    <h3 class="product-name-lnd">{{ $product['name'] }}</h3>
                    <p class="product-desc-lnd">{{ $product['desc'] }}</p>
                    <div class="product-footer-lnd">
                        <span class="product-price-lnd">{{ $product['price'] }}</span>
                        {{-- Clicking "Add to Cart" goes to shop and auto-adds this product --}}
                        <a href="{{ route('customer.shop', ['addToCart' => $product['catalogId']]) }}"
                           class="btn-shop-lnd">
                            Add to Cart 🛒
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pets-cta">
            <a href="{{ route('customer.shop', ['type' => 'product']) }}" class="btn-primary">View All Products 🛍️</a>
        </div>
    </div>
</section>
<!-- =================== END OUR PRODUCTS =================== -->


<!-- =================== SERVICES =================== -->
{{--
    IMPORTANT: Your HomeController must include an 'id' field in $services
    that matches the catalog IDs in shop.blade.php (25–28).

    Example in HomeController@index:
    $services = [
        ['id'=>25, 'icon'=>'✂️', 'title'=>'Full Pet Grooming',   'desc'=>'Complete bath, haircut, nail trim, and ear cleaning.'],
        ['id'=>26, 'icon'=>'🩺', 'title'=>'Basic Vet Checkup',   'desc'=>'General health assessment by our licensed veterinarians.'],
        ['id'=>27, 'icon'=>'🏨', 'title'=>'Overnight Boarding',  'desc'=>'Safe, comfortable overnight stay with daily playtime included.'],
        ['id'=>28, 'icon'=>'🦮', 'title'=>'Obedience Training',  'desc'=>'5-session behavioral training course for dogs of all ages.'],
    ];
--}}
<section class="services-section" id="services">
    <div class="section-inner">
        <div class="section-header light">
            <div class="section-label">What We Offer</div>
            <h2>Complete <em>Pet Care</em> Under One Roof</h2>
            <p>Everything your pet needs — from first breath to forever home.</p>
        </div>

        <div class="services-grid">
            @foreach($services as $service)
            <div class="service-card">
                <div class="service-icon">{{ $service['icon'] }}</div>
                <h4>{{ $service['title'] }}</h4>
                <p>{{ $service['desc'] }}</p>
                {{-- "Book Now" goes to shop and auto-adds this service to cart --}}
                <a href="{{ route('customer.shop', ['addToCart' => $service['id']]) }}"
                   class="service-link">
                    Book Now →
                </a>
            </div>
            @endforeach
        </div>

        <div class="pets-cta" style="margin-top: 45px; text-align: center;">
            <a href="{{ route('customer.shop', ['type' => 'service']) }}" class="btn-primary">View All Services 📋</a>
        </div>
    </div>
</section>
<!-- =================== END SERVICES =================== -->


<!-- =================== PROMO BANNER =================== -->
<section class="promo-banner">
    <div class="promo-inner">
        <div class="promo-emoji">🎉</div>
        <div class="promo-text">
            <h3>First Visit Special — Get <strong>20% OFF</strong> on Grooming!</h3>
            <p>Use code <strong>PAWLOVE</strong> when you book your first grooming session.</p>
        </div>
        {{-- Book Now links to Full Pet Grooming (id 25) --}}
        <a href="{{ route('customer.shop', ['addToCart' => 25]) }}" class="btn-promo">Book Now</a>
    </div>
</section>
<!-- =================== END PROMO BANNER =================== -->


<!-- =================== TESTIMONIALS =================== -->
<section class="testimonials-section" id="testimonials">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-label">Happy Pet Parents</div>
            <h2>What Our <em>Customers Say</em></h2>
        </div>

        <div class="testimonials-grid">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <div class="stars">
                    @for($i = 0; $i < $testimonial['stars']; $i++)
                        ★
                    @endfor
                </div>
                <blockquote>"{{ $testimonial['quote'] }}"</blockquote>
                <div class="testimonial-author">
                    <div class="avatar">{{ $testimonial['avatar'] }}</div>
                    <div>
                        <strong>{{ $testimonial['name'] }}</strong>
                        <span>{{ $testimonial['role'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- =================== END TESTIMONIALS =================== -->


<!-- =================== CONTACT =================== -->
<section class="contact-section" id="contact">
    <div class="section-inner contact-inner">
        <div class="contact-info">
            <div class="section-label">Get In Touch</div>
            <h2>Visit Us or <em>Send a Message</em></h2>
            <p>We'd love to hear from you. Drop by our shop or reach out — our team is always happy to help.</p>

            <ul class="contact-details">
                <li>📍 <span>123 Paws Street, Quezon City, Metro Manila</span></li>
                <li>📞 <span>+63 912 345 6789</span></li>
                <li>✉️ <span>hello@pawhaven.ph</span></li>
                <li>🕐 <span>Mon–Sat: 8:00 AM – 7:00 PM</span></li>
            </ul>

            <div class="contact-socials">
                <a href="#" class="social-pill">Facebook</a>
                <a href="#" class="social-pill">Instagram</a>
                <a href="#" class="social-pill">TikTok</a>
            </div>
        </div>

        <form class="contact-form" method="POST" action="#">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" placeholder="Juan dela Cruz" required />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" placeholder="juan@email.com" required />
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea rows="4" placeholder="Ask us anything about our pets or services..."></textarea>
            </div>
            <button type="submit" class="btn-primary w-full">Send Message 🐾</button>
        </form>
    </div>
</section>
<!-- =================== END CONTACT =================== -->


<!-- =================== FOOTER =================== -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <span class="brand-icon">🐾</span>
            <span class="brand-text">PawHaven</span>
            <p>Where every pet finds a loving home.</p>
        </div>

        <div class="footer-links">
            <div class="footer-col">
                <h5>Shop</h5>
                <a href="{{ route('customer.shop', ['type' => 'pet']) }}">All Pets</a>
                <a href="{{ route('customer.shop', ['type' => 'pet']) }}">Dogs</a>
                <a href="{{ route('customer.shop', ['type' => 'pet']) }}">Cats</a>
                <a href="{{ route('customer.shop', ['type' => 'product']) }}">Supplies</a>
            </div>
            <div class="footer-col">
                <h5>Services</h5>
                <a href="{{ route('customer.shop', ['addToCart' => 25]) }}">Grooming</a>
                <a href="{{ route('customer.shop', ['addToCart' => 26]) }}">Veterinary</a>
                <a href="{{ route('customer.shop', ['addToCart' => 27]) }}">Boarding</a>
                <a href="{{ route('customer.shop', ['addToCart' => 28]) }}">Training</a>
            </div>
            <div class="footer-col">
                <h5>Support</h5>
                <a href="#">FAQ</a>
                <a href="#contact">Contact Us</a>
                <a href="#">Shipping Info</a>
                <a href="#">Returns</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} PawHaven. Made with 🐾 for pet lovers everywhere.</p>
        <div class="footer-legal">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
    </div>
</footer>
<!-- =================== END FOOTER =================== -->

@endsection 