{{-- resources/views/wishlist/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<style>
    /* 1. Global Reset */
    body {
        background-color: #02060c; 
        color: #d1e3ff;
        font-family: 'Inter', sans-serif;
    }

    /* 2. Heading Style */
    .wishlist-title {
        background: linear-gradient(to right, #ffffff, #5c7fa3);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -0.5px;
    }

    /* 3. Card & Empty State Wrapper */
    .card-midnight {
        background: rgba(10, 20, 38, 0.8) !important;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(0, 168, 255, 0.15) !important;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    /* 4. Custom Button */
    .btn-midnight {
        background: linear-gradient(135deg, #00a8ff 0%, #0070ff 100%);
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 12px;
        padding: 12px 30px;
        transition: 0.4s;
        box-shadow: 0 10px 20px rgba(0, 168, 255, 0.2);
    }

    .btn-midnight:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 168, 255, 0.4);
        color: #fff;
    }

    /* 5. Pagination Styling */
    .pagination .page-link {
        background-color: rgba(10, 20, 38, 0.8);
        border-color: rgba(0, 168, 255, 0.2);
        color: #00d2ff;
    }

    .pagination .page-item.active .page-link {
        background-color: #0070ff;
        border-color: #00a8ff;
    }

    /* 6. Heart Icon Glow */
    .heart-glow {
        color: rgba(255, 46, 99, 0.2);
        filter: drop-shadow(0 0 15px rgba(255, 46, 99, 0.4));
        animation: pulse-heart 2s infinite;
    }

    @keyframes pulse-heart {
        0% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); opacity: 0.5; }
    }
</style>

<div class="container py-5">
    <div class="d-flex align-items-center mb-5">
        <div class="p-2 rounded-3 bg-info bg-opacity-10 me-3">
            <i class="bi bi-heart-fill text-info fs-4"></i>
        </div>
        <h2 class="wishlist-title fw-bold mb-0">Wishlist Saya</h2>
    </div>

    @if($products->count())
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($products as $product)
                <div class="col">
                    {{-- Pastikan komponen x-product-card Anda sudah mendukung tema gelap --}}
                    <div class="card-midnight h-100 transition-up">
                        <x-product-card :product="$product" />
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
   @else
    <div class="text-center py-5">
        {{-- Card Wrapper --}}
        <div class="card card-midnight p-5 d-inline-block w-100" style="max-width: 600px; position: relative; overflow: hidden; min-height: 400px;">
            
            {{-- Logo Keranjang Tengah (Watermark) --}}
            <div class="d-flex align-items-center justify-content-center" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0; pointer-events: none;">
                <i class="bi bi-cart3" style="font-size: 15rem; color: rgba(0, 168, 255, 0.1); line-height: 1;"></i>
            </div>

            {{-- Konten Utama --}}
            <div style="position: relative; z-index: 1;">
                <div class="mb-4 mt-3">
                    <div class="position-relative d-inline-block">
                        <i class="bi bi-heart-break heart-glow" style="font-size: 5rem; color: #ff2e63;"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info p-2 shadow-sm">
                            <i class="bi bi-cart-x text-white fs-5"></i>
                        </span>
                    </div>
                </div>
                
                <h3 class="text-white fw-bold">Wishlist Anda Masih Kosong</h3>
                <p class="text-secondary mx-auto mb-5" style="max-width: 400px;">
                    Simpan produk favorit Anda di sini agar lebih mudah menemukannya saat Anda siap untuk checkout.
                </p>
                
                <div class="d-grid d-md-block">
                    <a href="{{ route('catalog.index') }}" class="btn btn-midnight">
                         <i class="bi bi-cart-plus me-2"></i> Jelajahi Produk <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
@endsection