<?php
// ──────────────────────────────────────────────────────────
// app/Http/Controllers/Api/OrderController.php
// ──────────────────────────────────────────────────────────
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Activity;
use Illuminate\Http\Request;
 
class OrderController extends Controller
{
    /** Advance order status */
    public function updateStatus(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
 
        $transitions = ['pending' => 'to-ship', 'to-ship' => 'completed'];
        $newStatus   = $transitions[$order->status] ?? null;
 
        if (!$newStatus) {
            return response()->json(['error' => 'No further transitions allowed.'], 422);
        }
 
        $order->update(['status' => $newStatus]);
 
        Activity::log(
            'Order',
            $order->customer_name,
            "Order #{$order->order_number} moved to {$newStatus}.",
            ucfirst(str_replace('-', ' ', $newStatus)),
            $newStatus === 'to-ship' ? '🛒' : '📦'
        );
 
        return response()->json(['success' => true, 'new_status' => $newStatus]);
    }
 
    /** Export CSV */
    public function exportCsv()
    {
        $orders = Order::with('items')->get();
        $rows   = [['Order #', 'Customer', 'Email', 'Status', 'Items', 'Total (PHP)', 'Date']];
 
        foreach ($orders as $o) {
            $itemList = $o->items->map(fn($i) => "{$i->item_name} x{$i->quantity}")->implode('; ');
            $rows[]   = [$o->order_number, $o->customer_name, $o->email, $o->status,
                         $itemList, $o->grand_total, $o->ordered_at->format('Y-m-d')];
        }
 
        $csv = implode("\n", array_map(
            fn($r) => implode(',', array_map(fn($v) => '"'.$v.'"', $r)),
            $rows
        ));
 
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders.csv"',
        ]);
    }
}