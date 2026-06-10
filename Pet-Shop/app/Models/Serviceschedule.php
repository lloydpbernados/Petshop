<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSchedule extends Model
{
    protected $fillable = [
        'service_id',
        'date',
        'slot_limit',
        'booked_count',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Computed: is this date fully booked?
    public function getIsFullAttribute(): bool
    {
        return $this->booked_count >= $this->slot_limit;
    }
}