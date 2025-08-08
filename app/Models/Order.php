<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     * These are the fields we can fill when creating an order.
     */
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'shipping_address',
        'total_amount',
        'status',
        'estimated_delivery_date',
        'payment_intent_id',
        'order_notes'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'estimated_delivery_date' => 'date'
    ];

    /**
     * Get the user who placed this order.
     * This creates a relationship between Order and User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all order items for this order.
     * This creates a relationship between Order and OrderItem.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all tracking updates for this order.
     */
    public function trackingUpdates()
    {
        return $this->hasMany(OrderTracking::class)->orderBy('status_date', 'desc');
    }

    /**
     * Get the latest tracking update
     */
    public function latestTracking()
    {
        return $this->hasOne(OrderTracking::class)->latestOfMany('status_date');
    }

    /**
     * Calculate the total from order items.
     * This adds up all the subtotals from the order items.
     */
    public function calculateTotal()
    {
        return $this->orderItems()->sum('subtotal');
    }

    /**
     * Get the status steps for tracking.
     * This returns an array of possible order statuses.
     */
    public static function getStatusSteps()
    {
        return [
            'Ordered',
            'Packed',
            'Shipped',
            'Delivered'
        ];
    }

    /**
     * Check if order is delivered.
     */
    public function isDelivered()
    {
        return $this->status === 'Delivered';
    }
}
