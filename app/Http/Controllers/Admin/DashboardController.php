<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\PaymentProof;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::where('role', 'user')->count(),
            'books' => Book::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'pending_kasir' => Order::where('status', 'pending')->where('payment_method', 'Kasir')->count(),
            'revenue' => Order::whereIn('status', ['confirmed', 'shipped', 'completed'])->sum('total'),
            'pos_revenue_today' => Order::pos()->where('status', 'completed')->whereDate('created_at', now())->sum('total'),
        ];

        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
