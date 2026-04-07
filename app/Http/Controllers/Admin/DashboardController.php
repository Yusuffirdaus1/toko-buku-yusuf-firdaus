<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\PaymentProof;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'              => User::where('role', 'user')->count(),
            'books'              => Book::count(),
            'categories'         => Category::count(),
            'orders'             => Order::count(),
            'pending_orders'     => Order::where('status', 'pending')->count(),
            'unread_messages'    => Message::where('is_read', false)->count(),
            'revenue'            => Order::whereIn('status', ['confirmed', 'shipped', 'completed'])->sum('total'),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentMessages = Message::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentMessages'));
    }
}
