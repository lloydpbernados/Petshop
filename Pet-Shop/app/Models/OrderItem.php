<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_name',
        'icon',
        'item_type',
        'quantity',
        'price',
        'scheduled_at',
        'source_id',
    ];

    protected $casts = [
        'scheduled_at' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}