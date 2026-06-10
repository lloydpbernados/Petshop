<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'icon', 'status', 'price', 'description',
        'image_path',                          
        'emoji', 'category', 'badge', 'badge_label', 'available',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'Active');
    }
}