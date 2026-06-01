<?php
// app/Models/OrderItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_name',
        'icon',
        'item_type',    // 'pet' | 'supply' | 'service'
        'quantity',
        'price',
        'scheduled_at', // date string for service bookings
        'source_id',    // FK to pets.id / supplies.id / services.id
    ];

    protected $casts = [
        'scheduled_at' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}