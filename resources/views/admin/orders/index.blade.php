@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<style>
    /* Custom Styling untuk tampilan Elegan */
    .breadcrumb-text { font-size: 0.85rem; color: #6c757d; }
    
    .card-order {
        border: none;
        border-radius: 12px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .nav-tabs-custom {
        border-bottom: 2px solid #f8f9fa;
    }

    .nav-tabs-custom .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 1rem 1.5rem;
        position: relative;
    }

    .nav-tabs-custom .nav-link.active {
        color: #4e73df;
        background: none;
    }

    .nav-tabs-custom .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #4e73df;
    }

    /* Soft Badge Colors */
    .badge-soft-warning { background-color: #fff4e5; color: #ff9800; }
    .badge-soft-info { background-color: #e5f6fd; color: #03a9f4; }
    .badge-soft-success { background-color: #edf7ed; color: #4caf50; }
    .badge-soft-danger { background-color: #fdeded; color: #ef5350; }
    
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #5a5c69;
        border-top: none;
    }

    .avatar-circle {
        width: 35px;
        height: 35px;
        background-color: #4e73df;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.8rem;
        font-weight: bold;
    }
</style>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-text mb-1 p-0 bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Pesanan</li>
                </ol>
            </nav>
            <h2 class="h4 fw-bold mb-0 text-gray-800">Manajemen Pesanan</h2>
        </div>
        <div class="text-muted small">
            Total: <strong>{{ $orders->total() }}</strong> Pesanan
        </div>
    </div>

    <div class="card card-order shadow-sm">
        <div class="card-header bg-white p-0">
            {{-- Filter Status Minimalis --}}
            <ul class="nav nav-tabs-custom">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'processing' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'processing']) }}">Diproses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'completed']) }}">Selesai</a>
                </li>
            </ul>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No. Order</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $order->user->name }}</div>
                                            <div class="text-muted small">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted small">
                                    {{ $order->created_at->translatedFormat('d M Y') }}<br>
                                    <span class="text-opacity-50">{{ $order->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'badge-soft-warning',
                                            'processing' => 'badge-soft-info',
                                            'completed' => 'badge-soft-success',
                                            'cancelled' => 'badge-soft-danger',
                                        ];
                                        $currentClass = $statusClasses[$order->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $currentClass }} rounded-pill px-3 py-2">
                                        <i class="fas fa-circle me-1" style="font-size: 0.4rem;"></i>
                                        {{ ucfirst($order->status == 'processing' ? 'diproses' : ($order->status == 'pending' ? 'menunggu' : $order->status)) }}
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light border-0 px-3 py-2" style="border-radius: 8px;">
                                        <i class="fas fa-eye text-primary me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80" class="mb-3 opacity-25">
                                    <p class="text-muted">Tidak ada pesanan untuk saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Menampilkan {{ $orders->firstItem() }} sampai {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                </div>
                <div>
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection