<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'event_date',
        'description',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}