{{-- ================================================
     FILE: resources/views/cart/index.blade.php
     FUNGSI: Halaman keranjang belanja (Elegant Midnight V4 - Seamless Summary)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<style>
    /* 1. Global Reset */
    body {
        background-color: #02060c; 
        color: #d1e3ff;
        font-family: 'Inter', sans-serif;
    }

    /* 2. Card Glassmorphism - Tanpa Border Internal */
    .card-midnight {
        background: rgba(10, 20, 38, 0.8) !important;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(0, 168, 255, 0.15) !important;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }

    /* 3. Table Styling */
    .table-midnight {
        background-color: transparent !important;
        color: #d1e3ff;
        margin-bottom: 0;
    }

    .table-midnight thead th {
        background: rgba(0, 0, 0, 0.3); 
        color: #5c7fa3;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-size: 0.75rem;
        padding: 20px;
        border-bottom: 1px solid rgba(0, 168, 255, 0.1);
    }

    .table-midnight tbody td {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 25px 20px;
    }

    /* 4. Menghilangkan Kotak pada Total Harga (Seamless Summary) */
    .summary-section {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0;
    }

    /* 5. Secure Info Badge */
    .secure-info {
        background: rgba(25, 30, 40, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 50px;
        padding: 8px 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: #2ecc71;
        margin-top: 1.5rem;
    }

    /* 6. Buttons & Badges */
    .category-badge {
        background: rgba(0, 168, 255, 0.15);
        color: #00d2ff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
    }

    .qty-input-midnight {
        background: #050a14 !important;
        border: 1px solid #1a2f4d !important;
        color: #00d2ff !important;
        border-radius: 10px;
        text-align: center;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #00a8ff 0%, #0070ff 100%);
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 10px 20px rgba(0, 168, 255, 0.3);
        transition: 0.4s;
    }

    .btn-remove {
        background: rgba(255, 71, 87, 0.1);
        color: #ff4757;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
    }
</style>

<div class="container py-5">
    <h2 class="cart-header-title d-flex align-items-center mb-5">
        <i class="bi bi-cart3 text-info me-3"></i> 
        <span style="background: linear-gradient(to right, #fff, #5c7fa3); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Keranjang Belanja
        </span>
    </h2>

    @if($cart && $cart->items->count())
        <div class="row g-4">
            {{-- Tabel Produk --}}
            <div class="col-lg-8">
                <div class="card card-midnight">
                    <div class="table-responsive">
                        <table class="table table-midnight align-middle">
                            <thead>
                                <tr>
                                    <th>Detail Produk</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->image_url }}" class="me-3 rounded shadow-sm" width="70" height="70" style="object-fit: cover;">
                                                <div>
                                                    <a href="#" class="text-decoration-none text-white fw-bold d-block mb-1">
                                                        {{ Str::limit($item->product->name, 30) }}
                                                    </a>
                                                    <span class="category-badge">
                                                        <i class="bi bi-tag-fill me-1"></i>{{ $item->product->category->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-secondary">{{ $item->product->formatted_price }}</td>
                                        <td class="text-center">
                                            <input type="number" value="{{ $item->quantity }}" class="form-control form-control-sm qty-input-midnight mx-auto" style="width: 60px;">
                                        </td>
                                        <td class="text-end fw-bold text-info">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button class="btn-remove"><i class="bi bi-trash3-fill"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Summary (Tanpa Kotak/Border Internal) --}}
            <div class="col-lg-4">
                <div class="card card-midnight">
                    <div class="card-body p-4 summary-section">
                        <h5 class="text-white fw-bold mb-4">Ringkasan Pesanan</h5>
                        
                        <div class="d-flex justify-content-between mb-3 text-secondary">
                            <span>Total Barang</span>
                            <span>{{ $cart->items->sum('quantity') }} unit</span>
                        </div>

                        {{-- Garis Pemisah Halus --}}
                        <div class="py-3 border-top border-secondary" style="border-style: dashed !important; border-width: 1px 0 0 0 !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-white">Total Harga</span>
                                <span class="fs-4 fw-bold text-info">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-checkout">
                                CHECKOUT SEKARANG <i class="bi bi-shield-check ms-2"></i>
                            </a>
                        </div>

                        <div class="secure-info">
                            <i class="bi bi-shield-lock-fill"></i>
                            <span>Checkout Terenkripsi & 100% Aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection