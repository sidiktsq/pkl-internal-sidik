{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Komponen kartu produk elegan (Modern Wishlist & White Text)
     ================================================ --}}

<style>
    .elegant-card {
        background: #0f172a; 
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 16px;
        overflow: hidden;
        color: #ffffff;
    }

    .elegant-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        border-color: rgba(56, 189, 248, 0.3);
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
        opacity: 0.9;
    }

    /* Badge Diskon - Dibuat lebih rapi */
    .badge-discount-elegant {
        background: #38bdf8;
        color: #0f172a;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 12px 0 12px 0;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 3;
        font-size: 0.75rem;
        box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
    }

    /* PENEMPATAN WISHLIST YANG BARU (Top Right) */
    .wishlist-float {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 3;
    }

    .wishlist-btn-elegant {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .wishlist-btn-elegant:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: #ef4444;
        transform: scale(1.1);
    }

    .wishlist-btn-elegant i {
        font-size: 1.1rem;
        line-height: 0;
    }

    .product-title-link {
        color: #ffffff !important;
        transition: color 0.3s ease;
    }

    .elegant-card:hover .product-title-link {
        color: #38bdf8 !important;
    }

    .price-strike {
        color: rgba(255, 255, 255, 0.5) !important;
        text-decoration: line-through;
        font-size: 0.8rem;
    }

    .btn-cart-elegant {
        background: #38bdf8;
        color: #0f172a;
        border: none;
        font-weight: 700;
        border-radius: 10px;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .btn-cart-elegant:hover:not(:disabled) {
        background: #7dd3fc;
        box-shadow: 0 0 15px rgba(56, 189, 248, 0.4);
    }
</style>

<div class="card elegant-card h-100 shadow-lg">
    <div class="image-container">
        {{-- Badge Diskon di Kiri Atas --}}
        @if($product->has_discount)
            <div class="badge-discount-elegant">
                {{ $product->discount_percentage }}% OFF
            </div>
        @endif

        {{-- Wishlist Button di Kanan Atas --}}
        @auth
            <div class="wishlist-float">
                <button onclick="toggleWishlist({{ $product->id }})"
                        class="wishlist-btn-elegant wishlist-btn-{{ $product->id }}"
                        title="Tambah ke Wishlist">
                    <i class="bi {{ Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                </button>
            </div>
        @endauth

        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                 class="card-img-top"
                 alt="{{ $product->name }}"
                 style="height: 240px; object-fit: cover;">
        </a>
    </div>

    <div class="card-body d-flex flex-column px-3 pb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-white small fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem; opacity: 0.7;">
                {{ $product->category->name }}
            </span>
            @if($product->stock > 0 && $product->stock <= 5)
                <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">Limit Stock</span>
            @endif
        </div>

        <h6 class="mb-3">
            <a href="{{ route('catalog.show', $product->slug) }}"
               class="product-title-link text-decoration-none fw-bold">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        <div class="mt-auto">
            <div class="d-flex align-items-baseline gap-2">
                <span class="fs-5 fw-bold text-white">{{ $product->formatted_price }}</span>
                @if($product->has_discount)
                    <span class="price-strike">
                        {{ $product->formatted_original_price }}
                    </span>
                @endif
            </div>

            <div class="mt-2">
                @if($product->stock == 0)
                    <small class="text-white small" style="opacity: 0.6;">
                        <i class="bi bi-x-circle me-1 text-danger"></i>Out of Stock
                    </small>
                @else
                    <small class="text-white small" style="opacity: 0.6;">
                        <i class="bi bi-check2-circle me-1 text-info"></i>Tersedia di Gudang
                    </small>
                @endif
            </div>
        </div>
    </div>

    <div class="card-footer bg-transparent border-0 px-3 pb-3 pt-0">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit"
                    class="btn-cart-elegant w-100"
                    @if($product->stock == 0) disabled @endif>
                <i class="bi {{ $product->stock == 0 ? 'bi-dash-circle' : 'bi-bag-plus' }} me-2"></i>
                {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
            </button>
        </form>
    </div>
</div>