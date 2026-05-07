<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm navbar-glow">
    <div class="container">
        <!-- Brand with Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/ComputeCart Logo.png') }}" 
                 alt="ComputeCart Logo" 
                 style="height:70px; width:70; object-fit:contain;" 
                 class="me-2">
            ComputeCart
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('products.index') }}" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                        <li>
                            <a class="dropdown-item fw-bold" href="{{ route('products.index') }}">
                                All Products
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @isset($categories)
                            @foreach($categories as $category)
                                <li>
                                    <a class="dropdown-item" href="{{ route('products.index', ['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        @endisset
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('checkout.index') }}">Checkout</a></li>
                
                <!-- ✅ Added SmartConfigurator -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('configurator.show') }}">SmartConfigurator</a>
                </li>

                @auth
                    @if(Auth::user()->role_id == 1)
                        <!-- ✅ Admin Dashboard link only for admins -->
                        <li class="nav-item">
                            <a class="nav-link text-danger fw-bold" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Admin Dashboard
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Inline CSS for navbar effects -->
<style>
    /* Glow/hover/active effects for navbar links */
    .navbar-nav .nav-link {
        padding: 0.6rem 1rem;
        border-radius: 6px;
        transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
    }
    .navbar-nav .nav-link:hover {
        background-color: rgba(0,0,0,0.05);
        color: #000;
        box-shadow: 0 0 8px rgba(0,0,0,0.2);
    }
    .navbar-nav .nav-link.active {
        background-color: rgba(0,0,0,0.1);
        color: #17a2b8 !important;
        box-shadow: 0 0 10px rgba(23,162,184,0.6);
    }

    /* Glow effect for dropdown items */
    .dropdown-menu .dropdown-item {
        transition: background-color 0.3s ease, color 0.3s ease;
        border-radius: 4px;
    }
    .dropdown-menu .dropdown-item:hover {
        background-color: rgba(0,0,0,0.05);
        color: #17a2b8;
    }

    /* ✅ Animated glowing border for navbar */
    .navbar-glow {
        position: relative;
        overflow: visible; /* fix dropdown cropping */
    }
    .navbar-glow::after {
        content: "";
        position: absolute;
        bottom: 0; left: 0;
        width: 100%; height: 3px;
        background: linear-gradient(90deg, #0ff, #00f, #f0f);
        background-size: 300% 100%;
        animation: glowline 6s linear infinite;
    }
    @keyframes glowline {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }
</style>
