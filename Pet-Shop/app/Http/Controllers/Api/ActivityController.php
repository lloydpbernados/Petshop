<?php
// ──────────────────────────────────────────────────────────
// app/Http/Controllers/Api/ActivityController.php
// ──────────────────────────────────────────────────────────
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\Activity;
 
class ActivityController extends Controller
{
    public function index()
    {
        return response()->json(
            Activity::latest()->take(20)->get()->map(fn($a) => [
                'id'     => $a->id,
                'type'   => $a->type,
                'user'   => $a->user,
                'detail' => $a->detail,
                'status' => $a->status,
                'icon'   => $a->icon,
                'time'   => $a->time_ago,
            ])
        );
    }
}