<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung statistik
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'user')->count(),
        ];

        // 2. Ambil pesanan terbaru
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Produk terlaris
        $topProducts = Product::withCount(['orderItems as sold_count' => function($query) {
            $query->select(DB::raw('COALESCE(SUM(quantity), 0)'))
                  ->whereHas('order', function($q) {
                      $q->where('payment_status', 'paid');
                  });
        }])
        ->orderBy('sold_count', 'desc')
        ->take(5)
        ->get();

        // 4. Data Grafik Pendapatan (7 Hari Terakhir)
        $revenueChart = Order::select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            ])
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'revenueChart'));
    }
}