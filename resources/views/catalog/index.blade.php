@extends('layouts.app')

@section('content')
<style>
    /* Custom Midnight Blue Theme */
    :root {
        --midnight-bg: #020617;     /* Hitam Kebiruan Sangat Gelap */
        --midnight-card: #0f172a;   /* Biru Gelap untuk Card */
        --midnight-border: #1e293b; /* Warna Border */
        --accent-blue: #38bdf8;     /* Biru Cerah untuk Aksen */
        --text-slate: #94a3b8;      /* Abu-abu Kebiruan untuk teks sekunder */
    }

    body {
        background-color: var(--midnight-bg);
        color: #f8fafc;
    }

    .card {
        background-color: var(--midnight-card);
        border: 1px solid var(--midnight-border);
        color: #f8fafc;
    }

    .card-header {
        background-color: rgba(30, 41, 59, 0.5) !important;
        border-bottom: 1px solid var(--midnight-border) !important;
        color: var(--accent-blue) !important;
    }

    /* Input & Select */
    .form-control, .form-select {
        background-color: var(--midnight-bg);
        border-color: var(--midnight-border);
        color: #f8fafc;
    }

    .form-control:focus, .form-select:focus {
        background-color: var(--midnight-bg);
        border-color: var(--accent-blue);
        color: #ffffff;
        box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25);
    }

    /* Form Check/Radio */
    .form-check-input {
        background-color: var(--midnight-bg);
        border-color: var(--midnight-border);
    }

    .form-check-input:checked {
        background-color: var(--accent-blue);
        border-color: var(--accent-blue);
    }

    /* Buttons */
    .btn-primary {
        background-color: var(--accent-blue);
        border-color: var(--accent-blue);
        color: var(--midnight-bg);
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #7dd3fc;
        border-color: #7dd3fc;
        color: var(--midnight-bg);
    }

    .btn-outline-secondary {
        border-color: var(--midnight-border);
        color: var(--text-slate);
    }

    .btn-outline-secondary:hover {
        background-color: var(--midnight-border);
        color: #ffffff;
    }

    .text-muted {
        color: var(--text-slate) !important;
    }

    h4, h5, h6 {
        color: #ffffff;
    }

    /* Pagination Adjustment */
    .pagination .page-link {
        background-color: var(--midnight-card);
        border-color: var(--midnight-border);
        color: var(--accent-blue);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--accent-blue);
        border-color: var(--accent-blue);
        color: var(--midnight-bg);
    }
</style>

<div class="container py-5">
    <div class="row">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3 mb-4">
            <div class="card shadow-lg">
                <div class="card-header fw-bold">
                    <i class="bi bi-filter-left me-2"></i>Filter Produk
                </div>
                <div class="card-body">
                    <form action="{{ route('catalog.index') }}" method="GET">
                        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

                        {{-- Filter Kategori --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Kategori</h6>
                            @foreach($categories as $cat)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category" id="cat-{{ $cat->slug }}" value="{{ $cat->slug }}" {{
                                    request('category')==$cat->slug ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <label class="form-check-label" for="cat-{{ $cat->slug }}">
                                    {{ $cat->name }} 
                                    <small class="text-muted ms-1">({{ $cat->products_count }})</small>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        {{-- Filter Harga --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Rentang Harga</h6>
                            <div class="d-flex gap-2">
                                <input type="number" name="min_price" class="form-control form-control-sm"
                                    placeholder="Min" value="{{ request('min_price') }}">
                                <input type="number" name="max_price" class="form-control form-control-sm"
                                    placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-sm py-2">Terapkan Filter</button>
                        <a href="{{ route('catalog.index') }}"
                            class="btn btn-outline-secondary w-100 btn-sm mt-2">Reset</a>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-bold">Katalog Produk</h4>
                {{-- Sorting --}}
                <form method="GET" class="d-inline-block">
                    @foreach(request()->except('sort') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse($products as $product)
                <div class="col">
                    {{-- Pastikan komponen product-card Anda juga menyesuaikan warna --}}
                    <x-product-card :product="$product" />
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <img src="{{ asset('images/empty-state.svg') }}" width="150" class="mb-3 opacity-25">
                    <h5 class="text-white">Produk tidak ditemukan</h5>
                    <p class="text-muted">Coba kurangi filter atau gunakan kata kunci lain.</p>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection