<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\ServiceSchedule;
use Illuminate\Http\Request;

class ServiceBookingController extends Controller
{
    /**
     * List all service bookings (order_items with item_type = 'service').
     * Joins the parent order so the frontend gets customer name + order number.
     */
    public function index()
    {
        $bookings = OrderItem::with('order')
            ->where('item_type', 'service')
            ->whereNotNull('scheduled_at')
            ->orderBy('scheduled_at')
            ->get()
            ->map(fn($item) => $this->format($item));

        return response()->json($bookings);
    }

    /**
     * Update the status of a booking.
     * We store booking status on the parent order for now since order_items
     * doesn't have its own status column. If you want per-item status,
     * add a `booking_status` column to order_items.
     *
     * For now this updates the order status only when all items are services
     * (service-only orders). For mixed orders it just logs an activity.
     */
    public function updateStatus(Request $request, OrderItem $orderItem)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        // If the order is service-only, advance the order status
        $order = $orderItem->order;
        $allServices = $order->items->every(fn($i) => $i->item_type === 'service');

        if ($allServices) {
            $statusMap = [
                'confirmed'  => 'to-ship',   // reuse existing statuses
                'completed'  => 'completed',
                'cancelled'  => 'cancelled',
                'pending'    => 'pending',
            ];
            $order->update(['status' => $statusMap[$data['status']] ?? $order->status]);
        }

        // We return the booking with the new status reflected
        return response()->json($this->format($orderItem->fresh()));
    }

    // ── Private helper ───────────────────────────────────────────────────────

    private function format(OrderItem $item): array
    {
        $order = $item->order;

        // Map order status back to a booking status label
        $bookingStatus = match($order?->status) {
            'pending'   => 'pending',
            'to-ship'   => 'confirmed',
            'completed' => 'completed',
            'cancelled' => 'cancelled',
            default     => 'pending',
        };

        return [
            'id'            => $item->id,
            'order_id'      => $item->order_id,
            'order_number'  => $order?->order_number,
            'customer_name' => $order?->customer_name,
            'service_id'    => $item->source_id,
            'service_name'  => $item->item_name,
            'scheduled_at'  => $item->scheduled_at?->toDateString(),
            'status'        => $bookingStatus,
            'price'         => $item->price,
        ];
    }
}