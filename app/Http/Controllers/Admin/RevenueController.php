<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::whereIn('status', ['confirmed', 'shipped', 'completed']);

        // Filter by date range if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();
        
        // Calculate the total revenue for the displayed filtered orders
        // Note: sum() here applies the same filters to get the total
        $totalRevenue = (clone $query)->sum('total');

        return view('admin.revenue.index', compact('orders', 'totalRevenue'));
    }
}
