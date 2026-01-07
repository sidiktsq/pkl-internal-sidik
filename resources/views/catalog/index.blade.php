@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Katalog Produk</h1>
    </div>
    
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('partials.product-card', ['product' => $product])
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada produk yang tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection