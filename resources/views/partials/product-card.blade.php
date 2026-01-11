{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Komponen kartu produk elegan (Midnight Blue Theme)
     ================================================ --}}

<style>
    /* Custom Styling untuk Tema Hitam Kebiruan Elegan */
    .elegant-card {
        background: #0f172a; /* Midnight Blue Dark */
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 16px;
        overflow: hidden;
    }

    .elegant-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        border-color: rgba(56, 189, 248, 0.3); /* Soft blue border hover */
    }

    .image-container {
        overflow: hidden;
        position: relative;
        background: #1e293b;
    }

    .elegant-card img {
        transition: transform 0.6s ease;
    }

    .elegant-card:hover img {
        transform: scale(1.1);
        opacity: 0.8;
    }

    .badge-discount-elegant {
        background: #38bdf8; /* Sky Blue */
        color: #0f172a;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 0 0 0 12px;
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
    }

    .wishlist-float {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
    }

    .wishlist-btn-elegant {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .wishlist-btn-elegant:hover {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
    }

    .btn-cart-elegant {
        background: #38bdf8;
        color: #0f172a;
        border: none;
        font-weight: 600;
        border-radius: 10px;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .btn-cart-elegant:hover:not(:disabled) {
        background: #7dd3fc;
        transform: scale(1.02);
        color: #0f172a;
    }

    .btn-cart-elegant:disabled {
        background: #334155;
        color: #94a3b8;
    }

    .product-title-link {
        color: #f8fafc;
        transition: color 0.3s ease;
    }

    .elegant-card:hover .product-title-link {
        color: #38bdf8;
    }
</style>

<div class="card elegant-card h-100 shadow-lg">
    {{-- Product Image Section --}}
    <div class="image-container">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                 class="card-img-top"
                 alt="{{ $product->name }}"
                 style="height: 240px; object-fit: cover;">
        </a>

        {{-- Badge Diskon --}}
        @if($product->has_discount)
            <div class="badge-discount-elegant small">
                {{ $product->discount_percentage }}% OFF
            </div>
        @endif

        {{-- Wishlist Button --}}
        @auth
            <div class="wishlist-float">
                <button onclick="toggleWishlist({{ $product->id }})"
                        class="wishlist-btn-elegant wishlist-btn-{{ $product->id }}">
                    <i class="bi {{ Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                </button>
            </div>
        @endauth
    </div>

    {{-- Card Body --}}
    <div class="card-body d-flex flex-column px-3 pb-3">
        {{-- Category --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-info small fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">
                {{ $product->category->name }}
            </span>
            @if($product->stock > 0 && $product->stock <= 5)
                <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">Limit</span>
            @endif
        </div>

        {{-- Product Name --}}
        <h6 class="mb-3">
            <a href="{{ route('catalog.show', $product->slug) }}"
               class="product-title-link text-decoration-none fw-bold">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        {{-- Price & Stock --}}
        <div class="mt-auto">
            <div class="d-flex align-items-baseline gap-2">
                <span class="fs-5 fw-bold text-white">{{ $product->formatted_price }}</span>
                @if($product->has_discount)
                    <span class="text-muted text-decoration-line-through small" style="font-size: 0.8rem;">
                        {{ $product->formatted_original_price }}
                    </span>
                @endif
            </div>

            {{-- Stock Status --}}
            <div class="mt-2">
                @if($product->stock == 0)
                    <small class="text-danger small">
                        <i class="bi bi-x-circle me-1"></i>Out of Stock
                    </small>
                @else
                    <small class="text-secondary small">
                        <i class="bi bi-check2-circle me-1 text-info"></i>Tersedia
                    </small>
                @endif
            </div>
        </div>
    </div>

    {{-- Card Footer --}}
    <div class="card-footer bg-transparent border-0 px-3 pb-3 pt-0">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit"
                    class="btn-cart-elegant w-100 shadow-sm"
                    @if($product->stock == 0) disabled @endif>
                <i class="bi {{ $product->stock == 0 ? 'bi-dash-circle' : 'bi-bag-plus' }} me-2"></i>
                {{ $product->stock == 0 ? 'Habis' : 'Add to Cart' }}
            </button>
        </form>
    </div>
</div>