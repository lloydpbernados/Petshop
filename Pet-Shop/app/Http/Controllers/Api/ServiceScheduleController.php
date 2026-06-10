<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceSchedule;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ServiceScheduleController extends Controller
{
    /**
     * List all schedules, annotated with live booked_count
     * pulled from order_items so it's always accurate.
     */
    public function index(Request $request)
    {
        $query = ServiceSchedule::with('service')->orderBy('date');

        // Apply backend filtering if the frontend passed a service_id
        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }

        $schedules = $query->get();

        return response()->json($schedules->map(fn($s) => $this->format($s)));
    }
    /**
     * Create one or MORE schedules at once.
     *
     * The frontend sends an array of dates so the admin can pick
     * multiple dates in one go. Each date creates a separate row.
     *
     * Body: { service_id, dates: ['2026-06-10', '2026-06-11', ...],
     *         slot_limit, notes, status }
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'dates'      => 'required|array|min:1',
            'dates.*'    => 'required|date|after:today',
            'slot_limit' => 'required|integer|min:1|max:500',
            'notes'      => 'nullable|string|max:500',
            'status'     => 'required|in:open,closed',
        ]);

        $created = [];
        $skipped = []; // dates that already have a schedule for this service

        foreach ($data['dates'] as $date) {
            $exists = ServiceSchedule::where('service_id', $data['service_id'])
                                     ->where('date', $date)
                                     ->exists();
            if ($exists) {
                $skipped[] = $date;
                continue;
            }

            $schedule = ServiceSchedule::create([
                'service_id'   => $data['service_id'],
                'date'         => $date,
                'slot_limit'   => $data['slot_limit'],
                'booked_count' => 0,
                'notes'        => $data['notes'] ?? null,
                'status'       => $data['status'],
            ]);

            $created[] = $this->format($schedule);
        }

        return response()->json([
            'created' => $created,
            'skipped' => $skipped, // so the frontend can warn the admin
        ], 201);
    }

    /**
     * Update a single schedule (slot limit, status, notes).
     */
    public function update(Request $request, ServiceSchedule $serviceSchedule)
    {
        $data = $request->validate([
            'slot_limit' => 'sometimes|integer|min:1|max:500',
            'notes'      => 'nullable|string|max:500',
            'status'     => 'sometimes|in:open,closed',
        ]);

        $serviceSchedule->update($data);

        return response()->json($this->format($serviceSchedule->fresh()));
    }

    /**
     * Delete a schedule (only if no confirmed bookings on that date).
     */
    public function destroy(ServiceSchedule $serviceSchedule)
    {
        // Prevent deletion if there are confirmed/pending order_items on this date
        $hasBookings = OrderItem::where('item_type', 'service')
            ->where('source_id', $serviceSchedule->service_id)
            ->where('scheduled_at', $serviceSchedule->date)
            ->exists();

        if ($hasBookings) {
            return response()->json([
                'error' => 'Cannot delete a date that already has bookings. Close it instead.'
            ], 422);
        }

        $serviceSchedule->delete();

        return response()->json(['deleted' => true]);
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    /**
     * Returns a consistent shape for the frontend.
     * booked_count is computed live from order_items so it never drifts.
     */
    private function format(ServiceSchedule $s): array
    {
        // Count actual confirmed/pending bookings from order_items
        $bookedCount = OrderItem::where('item_type', 'service')
            ->where('source_id', $s->service_id)
            ->where('scheduled_at', $s->date->toDateString())
            ->count();

        // Sync the stored count while we're here (keeps the table accurate)
        if ($bookedCount !== $s->booked_count) {
            $s->update(['booked_count' => $bookedCount]);
        }

        return [
            'id'           => $s->id,
            'service_id'   => $s->service_id,
            'date'         => $s->date->toDateString(),
            'slot_limit'   => $s->slot_limit,
            'booked_count' => $bookedCount,
            'status'       => $s->status,
            'notes'        => $s->notes,
        ];
    }
}