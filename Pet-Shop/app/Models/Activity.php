<?php
// ──────────────────────────────────────────────────────────
// app/Models/Activity.php
// ──────────────────────────────────────────────────────────
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Activity extends Model
{
    protected $fillable = ['type', 'user', 'detail', 'status', 'icon'];
 
    /**
     * Log a new activity entry (call from Observers or controllers).
     */
    public static function log(
        string $type,
        string $user,
        string $detail,
        string $status,
        string $icon = '📝'
    ): self {
        return self::create(compact('type', 'user', 'detail', 'status', 'icon'));
    }
 
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}