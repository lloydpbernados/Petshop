<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesMonitoringController extends Controller
{
    /**
     * Show the sales monitoring page.
     */
    public function index()
    {
        return view('admin.sales-monitoring');
    }

    /**
     * Return sales data as JSON for the Alpine.js frontend.
     *
     * Revenue is derived from order_items (quantity × price) because the
     * orders table has no total_amount column.
     *
     * Only orders with status NOT IN ('cancelled') are counted so refunded /
     * voided orders don't inflate the numbers. Adjust the exclusion list to
     * match your workflow.
     */
    public function getData(Request $request)
    {
        $request->validate([
            'view'  => 'required|in:monthly,yearly',
            'year'  => 'required|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        $view  = $request->input('view');
        $year  = (int) $request->input('year');
        $month = (int) $request->input('month', 1);

        // Statuses that should be excluded from revenue calculations
        $excludedStatuses = ['cancelled', 'pending', 'to-ship', 'shipped'];


        // ------------------------------------------------------------------
        // Base query
        // Revenue  = SUM(order_items.quantity * order_items.price)
        // Orders   = COUNT(DISTINCT orders.id)
        // ------------------------------------------------------------------
        $base = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->whereNotIn('orders.status', $excludedStatuses)
            ->whereYear('orders.created_at', $year);

        if ($view === 'monthly') {
            // ---- Daily breakdown for a specific month --------------------
            $request->validate(['month' => 'required|integer|min:1|max:12']);

            $rows = (clone $base)
                ->whereMonth('orders.created_at', $month)
                ->selectRaw("DATE(orders.created_at) as period")
                ->selectRaw("COUNT(DISTINCT orders.id) as orders")
                ->selectRaw("COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_sales")
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            $data = $rows->map(function ($row) {
                return [
                    'label'       => Carbon::parse($row->period)->format('M d, Y'),  // e.g. "Jun 01, 2026"
                    'orders'      => (int)   $row->orders,
                    'total_sales' => (float) $row->total_sales,
                ];
            })->values()->toArray();

        } else {
            // ---- Monthly breakdown for a full year -----------------------
            $rows = (clone $base)
                ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m') as period")
                ->selectRaw("COUNT(DISTINCT orders.id) as orders")
                ->selectRaw("COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_sales")
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            $data = $rows->map(function ($row) {
                return [
                    'label'       => Carbon::createFromFormat('Y-m', $row->period)->format('F Y'), // e.g. "June 2026"
                    'orders'      => (int)   $row->orders,
                    'total_sales' => (float) $row->total_sales,
                ];
            })->values()->toArray();
        }

        // ------------------------------------------------------------------
        // Totals
        // ------------------------------------------------------------------
        $totals = array_reduce($data, function ($carry, $item) {
            $carry['orders']      += $item['orders'];
            $carry['total_sales'] += $item['total_sales'];
            return $carry;
        }, ['orders' => 0, 'total_sales' => 0.0]);

        return response()->json([
            'data'   => $data,
            'totals' => $totals,
        ]);
    }
}