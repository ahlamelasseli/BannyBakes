<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     * These are the fields we can fill when creating an order item.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'subtotal'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'product_price' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    /**
     * Get the order that owns this order item.
     * This creates a relationship between OrderItem and Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for this order item.
     * This creates a relationship between OrderItem and Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
