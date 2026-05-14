@extends('layouts.app')

@section('title', 'PawHaven — Where Every Pet Finds a Home')

@section('content')

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
                    <span class="card-price">₱12,500</span>
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
                        <button class="btn-adopt">Inquire</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pets-cta">
            <a href="#" class="btn-primary">View All Pets</a>
        </div>
    </div>
</section>
<!-- =================== END FEATURED PETS =================== -->


<!-- =================== SERVICES =================== -->
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
                <a href="#" class="service-link">Learn more →</a>
            </div>
            @endforeach
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
        <a href="#" class="btn-promo">Book Now</a>
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
                <a href="#">Dogs</a>
                <a href="#">Cats</a>
                <a href="#">Birds</a>
                <a href="#">Rabbits</a>
            </div>
            <div class="footer-col">
                <h5>Services</h5>
                <a href="#">Grooming</a>
                <a href="#">Veterinary</a>
                <a href="#">Boarding</a>
                <a href="#">Training</a>
            </div>
            <div class="footer-col">
                <h5>Support</h5>
                <a href="#">FAQ</a>
                <a href="#">Contact Us</a>
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