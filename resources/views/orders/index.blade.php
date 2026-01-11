{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<style>
    /* 1. Global Reset & Theme */
    body {
        background-color: #02060c; 
        color: #d1e3ff;
        font-family: 'Inter', sans-serif;
    }

    /* 2. Card Glassmorphism */
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
        background: transparent !important;
        color: #d1e3ff;
    }

    .table-midnight thead th {
        background: rgba(0, 168, 255, 0.05) !important;
        color: #5c7fa3;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
        padding: 20px;
        border-bottom: 2px solid rgba(0, 168, 255, 0.1);
    }

    .table-midnight tbody td {
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 20px;
        color: #d1e3ff;
    }

    .table-midnight tbody tr:hover {
        background: rgba(0, 168, 255, 0.03) !important;
    }

    /* 4. Badge Customization */
    .badge-midnight {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    .status-pending { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.2); }
    .status-processing { background: rgba(13, 202, 240, 0.1); color: #0dcaf0; border: 1px solid rgba(13, 202, 240, 0.2); }
    .status-shipped { background: rgba(13, 110, 253, 0.1); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.2); }
    .status-delivered { background: rgba(25, 135, 84, 0.1); color: #198754; border: 1px solid rgba(25, 135, 84, 0.2); }
    .status-cancelled { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.2); }

    /* 5. Typography & Buttons */
    .order-number {
        color: #00d2ff;
        text-shadow: 0 0 10px rgba(0, 210, 255, 0.3);
    }

    .btn-detail {
        background: rgba(0, 168, 255, 0.1);
        border: 1px solid rgba(0, 168, 255, 0.3);
        color: #00d2ff;
        border-radius: 10px;
        padding: 5px 15px;
        transition: 0.3s;
    }

    .btn-detail:hover {
        background: #0070ff;
        color: #fff;
        box-shadow: 0 5px 15px rgba(0, 112, 255, 0.4);
    }

    .pagination-container {
        padding: 20px;
        background: rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container py-5">
    <div class="d-flex align-items-center mb-5">
        <div class="p-2 rounded-3 bg-primary bg-opacity-10 me-3">
            <i class="bi bi-receipt text-info fs-3"></i>
        </div>
        <h2 class="fw-bold mb-0">
            <span style="background: linear-gradient(to right, #fff, #5c7fa3); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Daftar Pesanan Saya
            </span>
        </h2>
    </div>

    <div class="card card-midnight">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-midnight align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Tanggal Transaksi</th>
                            <th>Status Pesanan</th>
                            <th class="text-center">Total Tagihan</th>
                            <th class="text-end">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <span class="order-number fw-bold">#{{ $order->order_number }}</span>
                            </td>
                            <td class="small text-secondary">
                                <i class="bi bi-calendar3 me-2"></i>{{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td>
                                <span class="badge badge-midnight 
                                    @if($order->status == 'pending') status-pending
                                    @elseif($order->status == 'processing') status-processing
                                    @elseif($order->status == 'shipped') status-shipped
                                    @elseif($order->status == 'delivered') status-delivered
                                    @elseif($order->status == 'cancelled') status-cancelled
                                    @endif">
                                    <i class="bi bi-dot"></i>
                                    @if($order->status == 'pending') Menunggu Pembayaran
                                    @elseif($order->status == 'processing') Diproses
                                    @elseif($order->status == 'shipped') Dalam Pengiriman
                                    @elseif($order->status == 'delivered') Selesai
                                    @elseif($order->status == 'cancelled') Dibatalkan
                                    @else {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="text-center fw-bold text-white">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-detail">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="opacity-50">
                                    <i class="bi bi-box2 mb-3 d-block fs-1"></i>
                                    <p class="mb-0">Belum ada riwayat pesanan.</p>
                                    <a href="{{ route('catalog.index') }}" class="btn btn-link text-info text-decoration-none small">Mulai Belanja Sekarang</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
       
    </div>
</div>
@endsection