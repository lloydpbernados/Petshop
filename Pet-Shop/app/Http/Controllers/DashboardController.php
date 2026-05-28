<?php
 
// ──────────────────────────────────────────────────────────
// app/Http/Controllers/DashboardController.php
// ──────────────────────────────────────────────────────────
namespace App\Http\Controllers;
 
use App\Models\Activity;
use App\Models\Order;
use App\Models\Conversation;
use App\Models\Pet;
 
class DashboardController extends Controller
{
    public function index()
    {
        $recentActivities = Activity::latest()
            ->take(10)
            ->get()
            ->map(fn($a) => [
                'type'   => $a->type,
                'user'   => $a->user,
                'detail' => $a->detail,
                'time'   => $a->time_ago,
                'status' => $a->status,
                'icon'   => $a->icon,
            ]);
 
        $stats = [
            'total_pets'     => Pet::sum('stock'),
            'new_inquiries'  => Conversation::whereHas(
                                    'messages',
                                    fn($q) => $q->where('type', 'received')
                                               ->where('created_at', '>=', now()->subDay())
                                )->count(),
        ];
 
        return view('admin.dashboard', compact('recentActivities', 'stats'));
    }
}