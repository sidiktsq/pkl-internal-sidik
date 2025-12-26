<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }



public function getSubtotalAttribute()
{
    if ($this->product->discount_price) {
        return $this->quantity * $this->product->discount_price;
    }
    return $this->quantity * $this->product->price;
}

  
}
