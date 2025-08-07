<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cookie extends Model
{
    /**
     * The attributes that are mass assignable.
     * These fields can be filled when creating or updating a cookie.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image'
    ];

    /**
     * The attributes that should be cast to native types.
     * This ensures price is always treated as a decimal number.
     */
    protected $casts = [
        'price' => 'decimal:2'
    ];
}
