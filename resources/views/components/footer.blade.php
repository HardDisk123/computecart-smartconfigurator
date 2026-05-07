<footer class="footer-modern mt-auto">
    <div class="container py-5">
        <div class="row align-items-center">

            <!-- Left: Branding -->
            <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                <h4 class="fw-bold brand-text">ComputeCart</h4>
                <p class="small footer-text mb-0">&copy; {{ date('Y') }} ComputeCart. All rights reserved.</p>
            </div>

            <!-- Center: Quick Links -->
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                    <li class="list-inline-item"><a href="{{ route('products.index') }}" class="footer-link">Products</a></li>
                    <li class="list-inline-item"><a href="{{ route('cart.index') }}" class="footer-link">Cart</a></li>
                    <li class="list-inline-item"><a href="{{ route('checkout.index') }}" class="footer-link">Checkout</a></li>
                </ul>
            </div>

            <!-- Right: Social Icons -->
            <div class="col-md-4 text-center text-md-end">
                <a href="#" class="footer-icon"><i class="bi bi-facebook"></i></a>
                <a href="#" class="footer-icon"><i class="bi bi-twitter"></i></a>
                <a href="#" class="footer-icon"><i class="bi bi-instagram"></i></a>
                <a href="#" class="footer-icon"><i class="bi bi-github"></i></a>
            </div>
        </div>
    </div>
</footer>

<!-- ✅ Footer CSS -->
<style>
    .footer-modern {
        background: linear-gradient(135deg, #111 0%, #222 50%, #111 100%);
        border-top: 2px solid #333;
        position: relative;
        overflow: hidden;
    }

    /* Animated glowing border */
    .footer-modern::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 2px;
        background: linear-gradient(90deg, #0ff, #00f, #f0f);
        animation: glowline 6s linear infinite;
    }
    @keyframes glowline {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    /* Branding text (no glow by default) */
.brand-text {
    color: #fff;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    text-shadow: none; /* no glow initially */
    cursor: pointer;
}

/* Glow only on hover */
.brand-text:hover {
    text-shadow: 0 0 12px #fff, 0 0 20px rgb(255, 255, 255);
}

    /* Footer text glow */
    .footer-text {
        color: #fff;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        text-shadow: none; /* no glow initially */
        cursor: pointer;
    }

    .footer-text:hover {
        text-shadow: 0 0 6px rgb(255, 255, 255);
    }

    /* Links with neon underline */
    .footer-link {
        color: #bbb;
        text-decoration: none;
        margin: 0 10px;
        font-size: 0.95rem;
        position: relative;
        transition: color 0.3s ease;
    }
    .footer-link::after {
        content: "";
        position: absolute;
        bottom: -4px; left: 0;
        width: 0%; height: 2px;
        background: rgb(252, 252, 252);
        transition: width 0.3s ease;
    }
    .footer-link:hover {
        color: #fff;
        text-shadow: 0 0 8px rgb(255, 255, 255);
    }
    .footer-link:hover::after {
        width: 100%;
    }

    /* Social icons with glow */
    .footer-icon {
        color: #bbb;
        margin-left: 12px;
        font-size: 1.5rem;
        transition: color 0.3s ease, transform 0.3s ease, text-shadow 0.3s ease;
    }
    .footer-icon:hover {
        color: rgb(255, 255, 255);
        transform: scale(1.2);
        text-shadow: 0 0 12px rgb(255, 255, 255), 0 0 20px rgb(255, 255, 255);
    }
</style>
