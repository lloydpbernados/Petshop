<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Message extends Model
{
    protected $fillable = ['conversation_id', 'type', 'text'];
 
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
 
    // Format time for display (e.g., "9:30 AM" or "Yesterday")
    public function getFormattedTimeAttribute(): string
    {
        $now   = now();
        $msgAt = $this->created_at;
 
        if ($msgAt->isToday())     return $msgAt->format('g:i A');
        if ($msgAt->isYesterday()) return 'Yesterday';
        return $msgAt->format('M j');
    }
}