<?php
// app/Models/Conversation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'initials',
        'status', 'category', 'reply_token'
    ];

    // Auto-generate reply token for guest conversations
    protected static function booted(): void
    {
        static::creating(function ($convo) {
            if (is_null($convo->user_id) && empty($convo->reply_token)) {
                $convo->reply_token = Str::uuid();
            }
        });
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}