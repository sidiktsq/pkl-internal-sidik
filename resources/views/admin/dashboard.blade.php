@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    :root {
        --sidebar-bg: #1e293b;
        --sidebar-active: rgba(255, 255, 255, 0.1);
        --bg-main: #f1f5f9;
        --text-main: #334155;
        --text-muted: #64748b;
        --accent: #6366f1;
    }

    body {
        background-color: var(--bg-main);
        color: var(--text-main);
        font-family: 'Inter', -apple-system, sans-serif;
    }

    /* --- Dashboard Cards --- */
    .card-dashboard {
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        background: #fff;
    }

    .icon-shape {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    /* --- Pagination --- */
    .custom-pagination {
        display: flex;
        align-items: center;
        gap: 0;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .page-link-custom {
        padding: 6px 14px;
        background: white;
        border-right: 1px solid #e2e8f0;
        color: #4f46e5;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .page-link-custom:last-child { border-right: none; }

    .page-link-custom.active {
        background: #1e293b;
        color: white;
        border-color: #1e293b;
    }

    .page-link-custom.next-prev {
        color: #4f46e5;
        font-weight: 500;
    }

    /* --- Table & Chart --- */
    .table-responsive {
        border-radius: 8px;
        border: 1px solid #eef2f7;
    }

    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.7rem;        letter-spacing: 0.025em;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .chart-container {
        height: 300px;
        position: relative;
    }
</style>

<div class="container-fluid p-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0">Overview Dashboard</h4>
            <p class="text-muted small mb-0">Selamat datang kembali, Admin.</p>
        </div>
        <div class="col-auto">
            <div class="bg-white border rounded-3 px-3 py-2 small fw-medium">
                <i class="far fa-calendar me-2 text-primary"></i> {{ now()->format('d M Y') }}
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @php
            $stats_data = [
                ['label' => 'Total Pendapatan', 'val' => 'Rp ' . number_format($stats['total_revenue'] ?? 0, 0, ',', '.'), 'icon' => 'fa-wallet', 'color' => '#4f46e5'],
                ['label' => 'Pesanan Baru', 'val' => ($stats['pending_orders'] ?? 0) . ' Pesanan', 'icon' => 'fa-shopping-cart', 'color' => '#f59e0b'],
                ['label' => 'Produk Aktif', 'val' => $stats['total_products'] ?? 58, 'icon' => 'fa-box', 'color' => '#10b981'],
                ['label' => 'Pelanggan', 'val' => $stats['total_customers'] ?? 0, 'icon' => 'fa-users', 'color' => '#06b6d4'],
            ];
        @endphp

        @foreach($stats_data as $s)
        <div class="col-md-3">
            <div class="card card-dashboard p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape me-3" style="background-color: {{ $s['color'] }}15; color: {{ $s['color'] }};">
                        <i class="fas {{ $s['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium text-uppercase mb-0" style="font-size: 0.65rem;">{{ $s['label'] }}</div>
                        <div class="h6 fw-bold mb-0">{{ $s['val'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card card-dashboard p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0">Grafik Penjualan 7 Hari Terakhir</h6>
                    <button class="btn btn-sm btn-light border text-muted px-3" style="font-size: 0.75rem;">Laporan Mingguan</button>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card card-dashboard h-100 p-4">
                <h6 class="fw-bold mb-4">Produk Terlaris</h6>
                @forelse($topProducts ?? [] as $product)
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-light rounded-2 p-2 text-center" style="width: 40px;">
                        <span class="small fw-bold text-primary">{{ substr($product->name, 0, 1) }}</span>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="small fw-bold text-dark">{{ $product->name }}</div>
                        <div class="text-muted" style="font-size: 0.7rem;">{{ $product->sold_count ?? 0 }} Terjual</div>
                    </div>
                    <div class="text-end small fw-bold">Rp{{ number_format($product->price ?? 0, 0, ',', '.') }}</div>
                </div>
                @empty
                <div class="text-center py-5 text-muted small">Data tidak tersedia.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card card-dashboard">
        <div class="p-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Transaksi Terakhir</h6>
            <div class="small text-muted">Showing {{ count($recentOrders ?? []) }} results</div>
        </div>
        <div class="table-responsive px-4">
            <table class="table align-middle mb-3">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Pembayaran</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders ?? [] as $order)
                    <tr>
                        <td class="fw-bold text-primary small">#{{ $order->order_number }}</td>
                        <td class="small">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="small fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @php
                                $status = strtolower($order->status);
                                $badgeClass = 'bg-secondary';
                                if($status == 'completed') $badgeClass = 'bg-success';
                                elseif($status == 'processing') $badgeClass = 'bg-warning text-dark';
                                elseif($status == 'pending') $badgeClass = 'bg-info text-dark';
                            @endphp
                            <span class="badge rounded-pill {{ $badgeClass }} px-3" style="font-size: 0.65rem;">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4">Belum ada pesanan masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 pt-0 d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted">Halaman 1 dari 1</div>
            <div class="custom-pagination">
                <a href="#" class="page-link-custom next-prev">Next &raquo;</a>
                <a href="#" class="page-link-custom active">1</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const rawData = @json($revenueChart ?? []);
        
        // Data dummy jika database kosong agar grafik tetap muncul garisnya
        const labels = rawData.length > 0 ? rawData.map(item => item.date) : ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        const dataValues = rawData.length > 0 ? rawData.map(item => item.total) : [0, 50000, 30000, 100000, 80000, 150000, 120000];

        // Membuat gradient untuk area di bawah garis
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.4)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        new Chart(ctx, {
            type: 'line', // Mengubah menjadi Line Chart
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: dataValues,
                    borderColor: '#6366f1', // Warna garis ungu terang
                    backgroundColor: gradient, // Warna isi di bawah garis
                    fill: true, // Mengaktifkan pengisian area
                    tension: 0.4, // Membuat garis melengkung (smooth)
                    borderWidth: 4, // Ketebalan garis
                    pointRadius: 4, // Ukuran titik
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', drawBorder: false },
                        ticks: { 
                            font: { size: 11 },
                            callback: val => 'Rp ' + val.toLocaleString('id-ID')
                        }
                    },
                    x: { 
                        grid: { display: false }, 
                        ticks: { font: { size: 11 } } 
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection