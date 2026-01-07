<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan katalog produk
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return view('catalog.index', compact('products'));
    }

    /**
     * Menampilkan detail produk
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'images'])
            ->where('is_active', true)
            ->firstOrFail();

        // Ambil produk terkait
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('primaryImage')
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}