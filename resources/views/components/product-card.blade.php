<style>
    .card-product {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        height: 100%;
    }

    .card-product:hover {
        transform: translateY(-10px);
        border-color: #38bdf8;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(56, 189, 248, 0.1);
    }

    .img-container {
        position: relative;
        background: #f8fafc; /* Latar gambar sedikit terang agar produk terlihat */
        padding: 15px;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .img-container img {
        max-height: 100%;
        transition: transform 0.5s;
    }

    .card-product:hover .img-container img {
        transform: scale(1.1);
    }

    .product-info {
        padding: 1.2rem;
    }

    .product-cat {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #38bdf8;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .product-name-link {
        text-decoration: none;
        color: #f1f5f9;
        font-size: 1rem;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.8rem;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: #ffffff;
        margin-top: 10px;
    }

    .btn-view {
        background: #0f172a;
        color: #38bdf8;
        border: 1px solid #334155;
        width: 100%;
        border-radius: 12px;
        font-weight: 600;
        padding: 8px;
        margin-top: 15px;
        transition: 0.3s;
    }

    .card-product:hover .btn-view {
        background: #38bdf8;
        color: #0f172a;
        border-color: #38bdf8;
    }
</style>

<div class="card-product shadow-sm">
    <div class="img-container">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid">
        @if($product->has_discount)
            <span class="badge bg-danger position-absolute top-0 start-0 m-3 shadow">
                -{{ $product->discount_percentage }}%
            </span>
        @endif
    </div>
    <div class="product-info">
        <div class="product-cat">{{ $product->category->name }}</div>
        <a href="{{ route('catalog.show', $product->slug) }}" class="product-name-link">
            {{ $product->name }}
        </a>
        <div class="product-price">
            {{ $product->formatted_price }}
        </div>
        
        <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-view">
            Lihat Detail
        </a>
    </div>
</div>