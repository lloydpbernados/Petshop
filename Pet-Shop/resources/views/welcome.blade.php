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