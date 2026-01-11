{{-- ================================================
FILE: resources/views/catalog/show.blade.php
FUNGSI: Halaman detail produk (Tema Hitam Kebiruan)
================================================ --}}

@extends('layouts.app')

@section('title', $product->name)

@section('content')
<style>
    /* Custom Theme Variables */
    :root {
        --midnight-bg: #0f172a; /* Hitam Kebiruan Utama */
        --darker-bg: #020617;   /* Hitam Lebih Gelap untuk Background */
        --card-bg: #1e293b;     /* Biru Gelap untuk Kartu */
        --accent-blue: #38bdf8; /* Biru Cerah untuk Aksen */
        --text-slate: #94a3b8;  /* Abu-abu Kebiruan untuk Teks Muted */
    }

    body {
        background-color: var(--darker-bg);
        color: #f1f5f9;
    }

    /* Breadcrumb Adjustment */
    .breadcrumb-item a { color: var(--accent-blue); text-decoration: none; }
    .breadcrumb-item.active { color: var(--text-slate); }
    .breadcrumb-item + .breadcrumb-item::before { color: var(--text-slate); }

    /* Card Customization */
    .custom-card {
        background-color: var(--card-bg);
        border: 1px solid #334155;
        color: #f1f5f9;
        border-radius: 15px;
    }

    .image-wrapper {
        background: #f8f9fa; /* Tetap terang agar produk terlihat jelas, atau ubah ke var(--midnight-bg) */
        border-radius: 12px;
        overflow: hidden;
    }

    /* Form & Input */
    .qty-input-group .btn {
        border-color: #334155;
        color: white;
    }
    .qty-input-group input {
        background-color: var(--midnight-bg) !important;
        border-color: #334155 !important;
        color: white !important;
    }

    /* Buttons */
    .btn-primary {
        background-color: var(--accent-blue);
        border-color: var(--accent-blue);
        color: var(--darker-bg);
        font-weight: 700;
    }
    .btn-primary:hover {
        background-color: #7dd3fc;
        border-color: #7dd3fc;
        color: var(--darker-bg);
    }
    .btn-outline-danger {
        color: #fb7185;
        border-color: #fb7185;
    }
    .btn-outline-danger:hover {
        background-color: #fb7185;
        color: white;
    }

    .text-primary { color: var(--accent-blue) !important; }
    .text-muted { color: var(--text-slate) !important; }
    hr { border-top-color: #334155; opacity: 0.5; }
</style>

<div class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">
                    {{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 30) }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Product Images --}}
        <div class="col-lg-6 mb-4">
            <div class="card custom-card shadow-lg">
                <div class="position-relative image-wrapper m-3">
                    <img src="{{ $product->image_url }}" id="main-image" class="card-img-top" alt="{{ $product->name }}"
                        style="height: 400px; object-fit: contain; background: #ffffff;">

                    @if($product->has_discount)
                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 fs-6 shadow">
                        -{{ $product->discount_percentage }}%
                    </span>
                    @endif
                </div>

                @if($product->images->count() > 1)
                <div class="card-body pt-0">
                    <div class="d-flex gap-2 overflow-auto pb-2">
                        @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="rounded border-secondary"
                            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid #334155;"
                            onclick="document.getElementById('main-image').src = this.src">
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Product Info --}}
        <div class="col-lg-6">
            <div class="card custom-card shadow-lg">
                <div class="card-body p-4">
                    {{-- Category --}}
                    <span class="badge bg-secondary mb-2 opacity-75">
                        {{ $product->category->name }}
                    </span>

                    {{-- Title --}}
                    <h2 class="mb-3 fw-bold">{{ $product->name }}</h2>

                    {{-- Price --}}
                    <div class="mb-4">
                        @if($product->has_discount)
                        <div class="text-muted text-decoration-line-through small">
                            {{ $product->formatted_original_price }}
                        </div>
                        @endif
                        <div class="h2 text-primary fw-bold mb-0">
                            {{ $product->formatted_price }}
                        </div>
                    </div>

                    {{-- Stock Status --}}
                    <div class="mb-4">
                        @if($product->stock > 10)
                        <span class="text-success small fw-bold">
                            <i class="bi bi-check-circle-fill me-1"></i> Stok Tersedia
                        </span>
                        @elseif($product->stock > 0)
                        <span class="text-warning small fw-bold">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Stok Terbatas ({{ $product->stock }})
                        </span>
                        @else
                        <span class="text-danger small fw-bold">
                            <i class="bi bi-x-circle-fill me-1"></i> Stok Habis
                        </span>
                        @endif
                    </div>

                    {{-- Add to Cart Form --}}
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row g-3 align-items-end">
                            <div class="col-auto">
                                <label class="form-label small text-slate">Jumlah</label>
                                <div class="input-group qty-input-group" style="width: 140px;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decrementQty()">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1"
                                        max="{{ $product->stock }}" class="form-control text-center">
                                    <button type="button" class="btn btn-outline-secondary" onclick="incrementQty()">+</button>
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-lg w-100" @if($product->stock == 0) disabled @endif>
                                    <i class="bi bi-cart-plus me-2"></i> Tambah Keranjang
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Wishlist --}}
                    @auth
                    <button type="button" onclick="toggleWishlist({{ $product->id }})"
                        class="btn btn-outline-danger w-100 mb-4 wishlist-btn-{{ $product->id }}">
                        <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                        {{ auth()->user()->hasInWishlist($product) ? 'Hapus dari Wishlist' : 'Simpan ke Wishlist' }}
                    </button>
                    @endauth

                    <hr>

                    {{-- Product Details --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-white">Deskripsi Produk</h6>
                        <div class="text-slate" style="line-height: 1.6;">{!! $product->description !!}</div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 rounded bg-dark bg-opacity-25 border border-secondary border-opacity-25">
                                <small class="text-slate d-block">Berat</small>
                                <span class="small fw-bold">{{ $product->weight }} gr</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded bg-dark bg-opacity-25 border border-secondary border-opacity-25">
                                <small class="text-slate d-block">SKU</small>
                                <span class="small fw-bold">PROD-{{ $product->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    function decrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
@endpush
@endsection