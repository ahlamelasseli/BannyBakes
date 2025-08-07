<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     * These are the fields we can fill when creating or updating a product.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_active',
        'stock_quantity'
    ];

    /**
     * The attributes that should be cast to native types.
     * This ensures price is always treated as a decimal number.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Get all order items for this product.
     * This creates a relationship between Product and OrderItem.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all cart items for this product.
     * This creates a relationship between Product and Cart.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Check if product is available for purchase.
     * Returns true if product is active and has stock.
     */
    public function isAvailable()
    {
        return $this->is_active && $this->stock_quantity > 0;
    }

    /**
     * Get only active products.
     * This is a scope that we can use in queries.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
