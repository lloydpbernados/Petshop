<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'name', 'sku', 'category',
        'stock', 'price', 'low_stock_threshold',
        'image_path', 'emoji', 'description',
        'badge', 'badge_label', 'available',
        'weight_options',  
    ];

    protected $casts = [
        'weight_options' => 'array',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('available', true);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) return 'out';
        if ($this->stock <= $this->low_stock_threshold) return 'low';
        return 'ok';
    }
}