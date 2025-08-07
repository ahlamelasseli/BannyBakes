<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'cookie_id',
        'cookie_name',
        'quantity',
        'price',
        'total'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    /**
     * Get the order that owns this order line.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the cookie for this order line.
     */
    public function cookie()
    {
        return $this->belongsTo(Cookie::class);
    }
}
