<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'email',
        'shipping_address',
        'status',
        'payment_method',
        'gcash_reference',
        'tracking_notes',
        'ordered_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Computed ───────────────────────────────────────
    public function getGrandTotalAttribute(): float
    {
        return $this->items->sum(fn($i) => $i->price * $i->quantity);
    }

    // ── Helpers ────────────────────────────────────────
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'PH-' . strtoupper(Str::random(8)) . '-' . rand(1000, 9999);
        } while (static::where('order_number', $number)->exists());

        return $number;
    }
}