<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     * These are the fields we can fill when creating or updating a cart item.
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity'
    ];

    /**
     * Get the user that owns this cart item.
     * This creates a relationship between Cart and User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for this cart item.
     * This creates a relationship between Cart and Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the subtotal for this cart item.
     * This calculates quantity * product price.
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }
}
