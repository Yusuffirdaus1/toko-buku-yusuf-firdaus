<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.book', 'paymentProof.user');
        return view('admin.orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        $order->load('user', 'items.book');
        return view('admin.orders.invoice', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'           => 'required|in:pending,confirmed,shipped,completed,cancelled',
            'tracking_number'  => 'nullable|string|max:100',
            'shipping_courier' => 'nullable|string|max:50',
            'amount_paid'      => 'nullable|numeric|min:0',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'shipped') {
            $data['shipped_at'] = now();
            $data['tracking_number'] = $request->tracking_number;
            $data['shipping_courier'] = $request->shipping_courier;
        }

        // Handle cash payment for Kasir method
        if ($request->filled('amount_paid')) {
            $data['amount_paid'] = $request->amount_paid;
            $data['change_amount'] = max(0, $request->amount_paid - $order->total);
        }

        if ($request->status === 'completed') {
            $data['completed_at'] = now();
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $order, $data) {
            // Jika status lama bukan cancelled, tapi status baru adalah cancelled
            // Maka kita perlu mengembalikan stok buku
            if ($order->status !== 'cancelled' && $request->status === 'cancelled') {
                foreach ($order->items as $item) {
                    $item->book->increment('stock', $item->quantity);
                }
            }
            
            // Kebalikannya: jika status sebelumnya cancelled, lalu diubah kembali ke status aktif
            // Maka kita perlu mengurangi stok lagi (tapi ini jarang terjadi, tetap kita handle)
            if ($order->status === 'cancelled' && in_array($request->status, ['pending', 'confirmed', 'shipped', 'completed'])) {
                foreach ($order->items as $item) {
                    $item->book->decrement('stock', $item->quantity);
                }
            }

            $order->update($data);
        });

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
