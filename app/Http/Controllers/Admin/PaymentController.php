<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentProof;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentProof::with('order.user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(PaymentProof $payment)
    {
        $payment->load('order.items.book', 'user');
        return view('admin.payments.show', compact('payment'));
    }

    public function confirm(PaymentProof $payment)
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($payment) {
            $payment->update([
                'status'       => 'confirmed',
                'confirmed_by' => auth()->id(),
            ]);

            $order = $payment->order;

            // Jika sebelumnya dibatalkan, kurangi stok lagi karena stok sudah dikembalikan saat batal
            if ($order->status === 'cancelled') {
                foreach ($order->items as $item) {
                    $item->book->decrement('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'confirmed']);
        });

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function reject(PaymentProof $payment)
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($payment) {
            $payment->update(['status' => 'rejected']);
            
            $order = $payment->order;
            
            // Jika status pesanan belum dibatalkan, kembalikan stok
            if ($order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    $item->book->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Pembayaran ditolak. Stok buku telah dikembalikan dan pesanan otomatis dibatalkan.');
    }
}
