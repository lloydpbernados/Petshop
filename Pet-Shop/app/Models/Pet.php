<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name', 'sku', 'category', 'gender',
        'stock', 'price', 'low_stock_threshold',
        'image_path', 'emoji', 'description',
        'badge', 'badge_label', 'available',
    ];

    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) return 'out';
        if ($this->stock <= $this->low_stock_threshold) return 'low';
        return 'ok';
    }
}