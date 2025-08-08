<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'message',
        'location',
        'status_date',
        'updated_by'
    ];

    protected $casts = [
        'status_date' => 'datetime'
    ];

    /**
     * Get the order this tracking belongs to
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the admin who updated this status
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'pending' => ['name' => 'Order Received'],
            'processing' => ['name' => 'Preparing Your Order'],
            'packed' => ['name' => 'Packed & Ready'],
            'shipped' => ['name' => 'On the Way'],
            'delivered' => ['name' => 'Delivered']
        ];

        return $statuses[$this->status] ?? ['name' => ucfirst($this->status)];
    }
}
