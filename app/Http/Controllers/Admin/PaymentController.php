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
        $payment->update([
            'status'       => 'confirmed',
            'confirmed_by' => auth()->id(),
        ]);

        $payment->order->update(['status' => 'confirmed']);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function reject(PaymentProof $payment)
    {
        $payment->update(['status' => 'rejected']);
        $payment->order->update(['status' => 'pending']);

        return back()->with('success', 'Pembayaran ditolak. Pesanan kembali ke status pending.');
    }
}
