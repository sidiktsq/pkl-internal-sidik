{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Halaman utama website (Elegant Midnight Theme)
     ================================================ --}}

@extends('layouts.app')

@section('content')
<style>
    /* Global Background untuk seluruh halaman */
    body {
        background-color: #060b13;
        color: #d1e3ff;
    }

    /* Hero Section Styling */
    .hero-midnight {
        background: linear-gradient(135deg, #0d1626 0%, #060b13 100%);
        border-bottom: 1px solid #1a2f4d;
        position: relative;
        overflow: hidden;
    }

    .hero-midnight::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(0, 168, 255, 0.1) 0%, transparent 70%);
        z-index: 0;
    }

    /* Card Styling (Glassmorphism) */
    .card-midnight {
        background: rgba(26, 47, 77, 0.3) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(26, 47, 77, 0.5) !important;
        transition: all 0.3s ease;
    }

    .card-midnight:hover {
        transform: translateY(-10px);
        border-color: #00a8ff !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .section-title {
        font-weight: 700;
        letter-spacing: 1px;
        color: #ffffff;
        position: relative;
        display: inline-block;
        margin-bottom: 2rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #00a8ff;
    }

    /* Promo Banners */
    .banner-sale {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1000&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        border: 1px solid #3d2b00;
    }

    .banner-member {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1000&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        border: 1px solid #1a2f4d;
    }

    .btn-neon {
        background: transparent;
        border: 1px solid #00a8ff;
        color: #00a8ff;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-neon:hover {
        background: #00a8ff;
        color: #fff;
        box-shadow: 0 0 15px rgba(0, 168, 255, 0.4);
    }
</style>

{{-- Hero Section --}}
<section class="hero-midnight py-5 position-relative">
    <div class="container py-lg-5 position-relative" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-primary mb-3 px-3 py-2" style="border-radius: 20px;">Trend 2026</span>
                <h1 class="display-3 fw-bold mb-3 text-white">
                    Definisikan <span style="color: #00a8ff;">Gayamu</span> Sekarang
                </h1>
                <p class="lead mb-4 text-secondary">
                    Eksplorasi koleksi eksklusif dengan kualitas premium. Dapatkan pengalaman belanja masa kini dengan teknologi terbaik.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-bag me-2"></i>Mulai Belanja
                    </a>
                   
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center">
                {{-- Gunakan gambar yang lebih kontras untuk tema gelap --}}
                <img src="{{ asset('images/logo new.png') }}" 
                     alt="Shopping" class="img-fluid floating-animation" style="max-height: 450px; filter: drop-shadow(0 0 20px rgba(0,168,255,0.2));">
            </div>
        </div>
    </div>
</section>

{{-- Kategori --}}
<section class="py-5" id="kategori">
    <div class="container">
        <h2 class="section-title">Kategori Populer</h2>
        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="card card-midnight text-center h-100 p-3">
                            <div class="card-body p-2">
                                @if($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                     class="rounded-circle mb-3 border border-primary p-1"
                                     width="70" height="70" style="object-fit: cover;">
                                @endif
                                <h6 class="text-white mb-1">{{ $category->name }}</h6>
                                <p class="small text-secondary mb-0">{{ $category->active_products_count }} item</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Tidak ada kategori.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Produk Unggulan --}}
<section class="py-5" style="background: rgba(13, 22, 38, 0.5);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-0">Produk Unggulan</h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-primary text-decoration-none fw-bold">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4">
            @forelse($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada produk unggulan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Promo Banner --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card banner-sale border-0 h-100 shadow-lg" style="min-height: 250px; border-radius: 15px;">
                    <div class="card-body d-flex flex-column justify-content-center p-5 text-white">
                        <h2 class="fw-bold">Flash Sale!</h2>
                        <p class="mb-4 text-light opacity-75">Dapatkan potongan harga hingga 50% khusus minggu ini.</p>
                        <a href="#" class="btn btn-warning fw-bold px-4 py-2 w-fit-content" style="width: fit-content;">Ambil Promo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card banner-member border-0 h-100 shadow-lg" style="min-height: 250px; border-radius: 15px;">
                    <div class="card-body d-flex flex-column justify-content-center p-5 text-white">
                        <h2 class="fw-bold">Voucher Member</h2>
                        <p class="mb-4 text-light opacity-75">Baru bergabung? Nikmati voucher belanja Rp 50.000.</p>
                        <a href="{{ route('register') }}" class="btn btn-neon px-4 py-2 w-fit-content" style="width: fit-content;">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Produk Terbaru --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-0">Koleksi Terbaru</h2>
            </div>
            <a href="{{ route('catalog.index', ['sort' => 'newest']) }}" class="text-primary text-decoration-none fw-bold">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4">
            @forelse($latestProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Produk akan segera hadir.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efek smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endpush