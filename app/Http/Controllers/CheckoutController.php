<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Models\Cart;  // Added this line

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['items' => function($query) {
            $query->with('product');
        }])->where('user_id', auth()->id())->firstOrFail();
        
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request, OrderService $orderService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        try {
            $order = $orderService->createOrder(auth()->user(), $request->only(['name', 'phone', 'address']));
            // Redirect ke halaman pembayaran (akan dibuat besok)
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}