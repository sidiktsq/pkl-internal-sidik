@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    :root {
        --primary: #6366f1;
        --success: #10b981;
        --warning: #f59e0b;
        --info: #0ea5e9;
        --dark: #1e293b;
        --bg-main: #f8fafc;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--dark);
    }

    .card-dashboard {
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .card-dashboard:hover {
        transform: translateY(-3px);
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .badge-soft {
        font-weight: 600;
        padding: 0.4em 0.8em;
        border-radius: 8px;
    }

    .bg-soft-success { background: #d1fae5; color: #065f46; }
    .bg-soft-warning { background: #fef3c7; color: #92400e; }
    .bg-soft-info { background: #e0f2fe; color: #075985; }
    .bg-soft-secondary { background: #f1f5f9; color: #475569; }
</style>

<div class="container-fluid p-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-1">Analytics Overview</h3>
            <p class="text-muted mb-0">Lacak performa toko Anda secara real-time.</p>
        </div>
        <div class="col-auto">
            <div class="bg-white border shadow-sm rounded-3 px-3 py-2 small fw-bold">
                <i class="far fa-calendar-alt me-2 text-primary"></i> {{ now()->format('d M, Y') }}
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-4 mb-4">
        @php
            $stats_data = [
                ['label' => 'Total Pendapatan', 'val' => 'Rp ' . number_format($stats['total_revenue'] ?? 0, 0, ',', '.'), 'icon' => 'fa-wallet', 'color' => 'var(--primary)', 'bg' => '#eef2ff'],
                ['label' => 'Tertunda', 'val' => $stats['pending_orders'] ?? 0, 'icon' => 'fa-shopping-bag', 'color' => 'var(--warning)', 'bg' => '#fffbeb'],
                ['label' => 'Produk Aktif', 'val' => $stats['total_products'] ?? 0, 'icon' => 'fa-box-open', 'color' => 'var(--success)', 'bg' => '#ecfdf5'],
                ['label' => 'Total Pelanggan', 'val' => $stats['total_customers'] ?? 0, 'icon' => 'fa-user-friends', 'color' => 'var(--info)', 'bg' => '#f0f9ff'],
            ];
        @endphp

        @foreach($stats_data as $s)
        <div class="col-md-3">
            <div class="card card-dashboard p-3 border-0">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="background-color: {{ $s['bg'] }}; color: {{ $s['color'] }};">
                        <i class="fas {{ $s['icon'] }}"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">{{ $s['label'] }}</span>
                        <h4 class="fw-bold mb-0 mt-1">{{ $s['val'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        {{-- Revenue Chart --}}
        <div class="col-lg-8 mb-4">
            <div class="card card-dashboard p-4 h-100">
                <h5 class="fw-bold mb-4">Revenue Trend</h5>
                <div style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Top Selling Products --}}
        <div class="col-lg-4 mb-4">
            <div class="card card-dashboard p-4 h-100">
                <h5 class="fw-bold mb-4">Top Selling</h5>
                @forelse($topProducts as $product)
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-2 text-center fw-bold text-primary" style="width: 45px; height: 45px;">
                        {{ substr($product->name, 0, 1) }}
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">{{ Str::limit($product->name, 20) }}</h6>
                        <span class="text-muted small">{{ $product->sold_count ?? 0 }} sold</span>
                    </div>
                    <div class="text-end fw-bold text-success">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-5">Belum ada data produk terjual.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Transactions Table --}}
    <div class="card card-dashboard overflow-hidden">
        <div class="p-4 border-bottom bg-white">
            <h5 class="fw-bold mb-0">Recent Transactions</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr class="table-light">
                        <th class="ps-4">Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="ps-4 fw-bold">#{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="fw-bold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @php
                                $status = strtolower($order->status);
                                $badge = match($status) {
                                    'completed', 'success' => 'bg-soft-success',
                                    'pending' => 'bg-soft-warning',
                                    'processing' => 'bg-soft-info',
                                    default => 'bg-soft-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badge }} px-3">{{ strtoupper($order->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const rawData = @json($revenueChart);
        
        const labels = rawData.map(item => item.date);
        const dataValues = rawData.map(item => item.total);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: dataValues,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { callback: val => 'Rp' + val.toLocaleString('id-ID') }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection