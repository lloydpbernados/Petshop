<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'email',
        'shipping_address',
        'total_amount',      // ✅ added — was missing, so total never saved
        'status',
        'payment_method',
        'gcash_reference',
        'tracking_notes',
        'ordered_at',
    ];

    protected $casts = [
        'ordered_at'   => 'datetime',
        'total_amount' => 'float',
    ];

    // ── Relationships ──────────────────────────────────
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Computed ───────────────────────────────────────
    // grand_total falls back to summing items if total_amount is 0 or null
    public function getGrandTotalAttribute(): float
    {
        if (!empty($this->total_amount) && $this->total_amount > 0) {
            return (float) $this->total_amount;
        }

        $this->loadMissing('items');
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