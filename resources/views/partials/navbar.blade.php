{{-- ================================================
FILE: resources/views/partials/navbar.blade.php
================================================ --}}

<style>
    /* CSS Khusus untuk Navbar Hitam Kebiruan */
    .custom-navbar {
        background: rgba(13, 22, 38, 0.95) !important;
        backdrop-filter: blur(10px);
        border-bottom: 1px solid #1a2f4d;
        padding: 0.8rem 0;
    }

    .custom-navbar .navbar-brand {
        font-weight: 700;
        letter-spacing: 1px;
        color: #00a8ff !important;
    }

    /* Gaya Tombol Navigasi Seragam */
    .nav-btn-custom {
        color: #d1e3ff !important;
        border: 1px solid #1a2f4d !important;
        border-radius: 8px !important;
        padding: 0.5rem 1.1rem !important;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.03);
        display: inline-flex;
        align-items: center;
        text-decoration: none !important;
        position: relative;
    }

    .nav-btn-custom:hover, .nav-btn-custom.active {
        background: rgba(0, 168, 255, 0.1) !important;
        color: #00a8ff !important;
        border-color: #00a8ff !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 168, 255, 0.15);
    }

    /* Styling Search Bar (Teks Putih) */
    .search-container .form-control {
        background-color: #060b13;
        border: 1px solid #1a2f4d;
        color: #ffffff !important; /* Warna saat mengetik jadi putih */
        border-radius: 8px 0 0 8px;
    }

    /* Mengubah warna placeholder menjadi putih */
    .search-container .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7) !important; 
        opacity: 1; 
    }

    /* Untuk browser Edge/IE */
    .search-container .form-control:-ms-input-placeholder {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    /* Untuk browser Safari/Chrome lama */
    .search-container .form-control::-webkit-input-placeholder {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .search-container .form-control:focus {
        box-shadow: none;
        border-color: #00a8ff;
        background-color: #09121d;
    }

    .search-container .btn-search {
        border: 1px solid #1a2f4d;
        border-left: none;
        background-color: #1a2f4d;
        color: #00a8ff;
        border-radius: 0 8px 8px 0;
    }

    /* Badge & Dropdown */
    .nav-btn-custom .badge-custom {
        margin-left: 8px;
        font-size: 0.7rem;
        padding: 0.35em 0.65em;
    }

    .custom-navbar .dropdown-menu {
        background-color: #0d1626;
        border: 1px solid #1a2f4d;
        box-shadow: 0 10px 20px rgba(0,0,0,0.5);
    }
    .custom-navbar .dropdown-item { color: #d1e3ff; }
    .custom-navbar .dropdown-item:hover { background-color: #1a2f4d; color: #00a8ff; }
</style>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="bi bi-bag-heart-fill me-2" style="font-size: 1.5rem;"></i>
            <span>FASHION SMK</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search Form --}}
            <form class="d-flex mx-auto search-container mt-3 mt-lg-0" style="max-width: 350px; width: 100%;" action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari fashion..." value="{{ request('q') }}">
                    <button class="btn btn-search" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-lg-2 mt-2 mt-lg-0">
                    <a class="nav-btn-custom" href="{{ route('catalog.index') }}">
                        <i class="bi bi-grid me-2"></i> Katalog
                    </a>
                </li>

                @auth
                    <li class="nav-item me-lg-2 mt-2 mt-lg-0">
                        <a class="nav-btn-custom" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart me-2"></i> Wishlist
                            @if(auth()->user()->wishlists()->count() > 0)
                                <span class="badge rounded-pill bg-danger badge-custom">{{ auth()->user()->wishlists()->count() }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item me-lg-2 mt-2 mt-lg-0">
                        <a class="nav-btn-custom" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 me-2"></i> Keranjang
                            @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                            @if($cartCount > 0)
                                <span class="badge rounded-pill bg-primary badge-custom">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item dropdown mt-2 mt-lg-0">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="userDropdown" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle border border-primary ms-lg-2" width="36" height="36" alt="User">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profil</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i class="bi bi-bag me-2"></i> Pesanan</a></li>
                           <li><a class="dropdown-item py-2" href="{{ route('home') }}"><i class="bi bi-house me-2"></i> Home</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-primary py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Admin</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item me-lg-2 mt-2 mt-lg-0">
                        <a class="nav-btn-custom" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="nav-btn-custom" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-2"></i> Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>