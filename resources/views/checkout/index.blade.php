{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Form Alamat --}}
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Informasi Pengiriman</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ auth()->user()->name }}"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea
                                name="address"
                                rows="3"
                                class="form-control"
                                required
                            ></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Pesanan --}}
            <div class="col-lg-4">
                <div class="card shadow-sm position-sticky" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ringkasan Pesanan</h5>

                        <div class="mb-3" style="max-height: 240px; overflow-y: auto;">
                            @foreach($cart->items as $item)
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span>
                                        {{ $item->product->name }} x {{ $item->quantity }}
                                        <br>
                                        <small class="text-muted">
                                            @if($item->product->discount_price)
                                                <s>Rp {{ number_format($item->product->price, 0, ',', '.') }}</s>
                                                Rp {{ number_format($item->product->discount_price, 0, ',', '.') }}
                                            @else
                                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            @endif
                                            x {{ $item->quantity }}
                                        </small>
                                    </span>
                                    <span class="fw-semibold">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                            <span>Total</span>
                            <span>
                                Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100 py-2 fw-semibold"
                        >
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection