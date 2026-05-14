/* ============================================================
   PawHaven — app.js
   ============================================================ */

document.addEventListener("DOMContentLoaded", () => {
    /* ── Modal Logic ───────────────────────────── */
    const loginModal = document.getElementById("loginModal");
    const signupModal = document.getElementById("signupModal");

    // Primary Triggers (Navbar & Mobile Menu)
    const openLoginBtn = document.getElementById("openLoginBtn"); // Desktop Login
    const openSignupBtn = document.getElementById("openSignupBtn"); // The link in Login Modal
    const navSignupBtn = document.getElementById("navSignupBtn"); // Add this ID to your orange navbar button
    const mobileLoginBtn = document.getElementById("mobileLoginBtn");

    // Close buttons
    const closeLogin = document.getElementById("closeModal");
    const closeSignup = document.getElementById("closeSignupModal");
    const switchToLogin = document.getElementById("switchToLogin");

    const toggleBodyScroll = (isModalOpen) => {
        document.body.style.overflow = isModalOpen ? "hidden" : "";
    };

    const showLogin = (e) => {
        if (e) e.preventDefault();
        signupModal?.classList.remove("active");
        loginModal?.classList.add("active");
        toggleBodyScroll(true);
    };

    const showSignup = (e) => {
        if (e) e.preventDefault();
        loginModal?.classList.remove("active");
        signupModal?.classList.add("active");
        toggleBodyScroll(true);
    };

    const closeAllModals = () => {
        loginModal?.classList.remove("active");
        signupModal?.classList.remove("active");
        toggleBodyScroll(false);
    };

    // Event Listeners for Opening
    openLoginBtn?.addEventListener("click", showLogin);
    mobileLoginBtn?.addEventListener("click", showLogin);
    switchToLogin?.addEventListener("click", showLogin);

    openSignupBtn?.addEventListener("click", showSignup);
    navSignupBtn?.addEventListener("click", showSignup); // Listener for the orange button

    // Event Listeners for Closing
    closeLogin?.addEventListener("click", closeAllModals);
    closeSignup?.addEventListener("click", closeAllModals);

    // Close on backdrop click or Escape key
    window.addEventListener("click", (e) => {
        if (e.target === loginModal || e.target === signupModal)
            closeAllModals();
    });
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeAllModals();
    });

    /* ── Password Toggle ───────────────────────── */
    const togglePw = document.getElementById("togglePw");
    const pwInput = document.getElementById("password");

    togglePw?.addEventListener("click", () => {
        const isHidden = pwInput.type === "password";
        pwInput.type = isHidden ? "text" : "password";
        togglePw.textContent = isHidden ? "🙈" : "👁";
    });

    /* ── Hamburger / Mobile Menu ───────────────── */
    const hamburger = document.getElementById("hamburger");
    const mobileMenu = document.getElementById("mobileMenu");

    hamburger?.addEventListener("click", () => {
        const isOpen = mobileMenu?.classList.toggle("open");
        hamburger.setAttribute("aria-expanded", isOpen ? "true" : "false");
        hamburger.classList.toggle("is-open", isOpen);
    });

    mobileMenu?.querySelectorAll("a, button").forEach((el) => {
        el.addEventListener("click", () => {
            mobileMenu.classList.remove("open");
            hamburger?.classList.remove("is-open");
        });
    });

    /* ── Navbar Scroll Shadow ─────────────────── */
    const navbar = document.querySelector(".navbar");
    window.addEventListener(
        "scroll",
        () => {
            if (window.scrollY > 20) {
                navbar?.classList.add("scrolled");
            } else {
                navbar?.classList.remove("scrolled");
            }
        },
        { passive: true },
    );

    /* ── Flash Toast Auto-dismiss ──────────────── */
    const flashMsg = document.querySelector("[data-flash]");
    if (flashMsg) {
        setTimeout(() => {
            flashMsg.style.opacity = "0";
            flashMsg.style.transform = "translateY(-12px)";
            setTimeout(() => flashMsg.remove(), 400);
        }, 3500);
    }
});
