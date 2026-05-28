<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'icon', 'status', 'price', 'description',
        'emoji', 'category', 'badge', 'badge_label', 'available',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}