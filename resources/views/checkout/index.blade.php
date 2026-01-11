{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<style>
    /* 1. Global Page Style */
    body {
        background-color: #02060c; 
        color: #d1e3ff;
        font-family: 'Inter', sans-serif;
    }

    /* 2. Card Style (Midnight Glassmorphism) */
    .card-midnight {
        background: rgba(10, 20, 38, 0.8) !important;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(0, 168, 255, 0.15) !important;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    /* 3. Form Styling */
    .form-label {
        color: #5c7fa3;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-midnight {
        background: rgba(0, 0, 0, 0.2) !important;
        border: 1px solid rgba(0, 168, 255, 0.1) !important;
        color: #fff !important;
        border-radius: 12px;
        padding: 12px 15px;
        transition: 0.3s;
    }

    .form-control-midnight:focus {
        background: rgba(0, 0, 0, 0.4) !important;
        border-color: #00a8ff !important;
        box-shadow: 0 0 15px rgba(0, 168, 255, 0.2);
    }

    /* 4. Checkout Button */
    .btn-checkout-final {
        background: linear-gradient(135deg, #00a8ff 0%, #0070ff 100%);
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 10px 20px rgba(0, 168, 255, 0.3);
        transition: 0.4s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-checkout-final:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 168, 255, 0.5);
        color: #fff;
    }

    /* 5. Item List Styling */
    .item-scroll {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .item-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .item-scroll::-webkit-scrollbar-thumb {
        background: rgba(0, 168, 255, 0.2);
        border-radius: 10px;
    }

    .text-info-midnight {
        color: #00d2ff;
    }

    /* 6. Secure Badge */
    .secure-badge-mini {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(46, 204, 113, 0.2);
    }
</style>

<div class="container py-5">
    <div class="d-flex align-items-center mb-5">
        <a href="{{ route('cart.index') }}" class="btn btn-outline-info btn-sm rounded-circle me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold mb-0">
            <span style="background: linear-gradient(to right, #fff, #5c7fa3); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Konfirmasi Pesanan
            </span>
        </h2>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Bagian Kiri: Form Pengiriman --}}
            <div class="col-lg-8">
                <div class="card card-midnight p-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold text-white mb-0">Informasi Pengiriman</h5>
                           
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control form-control-midnight" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control form-control-midnight" placeholder="Contoh: 08123456789" required>
                            </div>

                            <div class="col-12 mb-2">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address" rows="4" class="form-control form-control-midnight" placeholder="Nama jalan, nomor rumah, kec, kota, kode pos" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Ringkasan --}}
            <div class="col-lg-4">
                <div class="card card-midnight position-sticky" style="top: 30px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-white mb-4">Ringkasan Produk</h5>

                        <div class="item-scroll">
                            @foreach($cart->items as $item)
                                <div class="d-flex align-items-start mb-3 pb-3 border-bottom border-secondary border-opacity-10">
                                    <img src="{{ $item->product->image_url }}" class="rounded me-3" width="50" height="50" style="object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
                                    <div class="flex-grow-1">
                                        <p class="text-white small fw-bold mb-0">{{ Str::limit($item->product->name, 25) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-secondary" style="font-size: 0.75rem;">{{ $item->quantity }}x</span>
                                            <span class="text-info-midnight fw-bold small">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary small">Subtotal</span>
                                <span class="text-white small">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-secondary small">Biaya Pengiriman</span>
                                <span class="text-success small fw-bold">Gratis</span>
                            </div>
                            
                            <hr style="border-color: rgba(255,255,255,0.1); border-style: dashed;">
                            
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="text-white fw-bold">Total Tagihan</span>
                                <span class="fs-4 fw-bold text-info-midnight">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" class="btn btn-checkout-final w-100 mb-3">
                                Konfirmasi Pembayaran <i class="bi bi-arrow-right ms-2"></i>
                            </button>

                            <p class="text-center text-secondary mb-0" style="font-size: 0.7rem;">
                                Dengan klik tombol di atas, Anda menyetujui <br> Syarat & Ketentuan kami.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection