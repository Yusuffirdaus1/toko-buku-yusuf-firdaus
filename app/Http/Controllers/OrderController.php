<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Buka halaman checkout, tampilin barang apa aja yang mau dibeli.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function checkout(Request $request)
    {
        $cartIds = $request->cart_ids ?? [];
        if (empty($cartIds)) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu buku untuk dicheckout.');
        }

        $cartItems = Cart::with('book')
            ->where('user_id', auth()->id())
            ->whereIn('id', $cartIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->book->price);

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    /**
     * Proses simpannya orderan baru khusus format COD.
     * Pake DB transaction biara aman kalau ada error di tengah-tengah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'address'          => 'required|string|max:500',
            'phone'            => 'required|string|max:20',
            'shipping_courier' => 'nullable|string|max:50',
        ]);

        $cartIds = $request->cart_ids ?? [];
        if (empty($cartIds)) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu buku untuk dicheckout.');
        }

        $cartItems = Cart::with('book')
            ->where('user_id', auth()->id())
            ->whereIn('id', $cartIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Validate stock
        foreach ($cartItems as $item) {
            if ($item->book->stock < $item->quantity) {
                return back()->with('error', 'Stok "' . $item->book->title . '" tidak mencukupi.');
            }
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->book->price);

        $order = DB::transaction(function () use ($request, $cartItems, $total, $cartIds) {
            $createdOrder = Order::create([
                'user_id'          => auth()->id(),
                'total'            => $total,
                'status'           => 'pending',
                'address'          => $request->address,
                'phone'            => $request->phone,
                'payment_method'   => 'COD',
                'shipping_courier' => $request->shipping_courier,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $createdOrder->id,
                    'book_id'  => $item->book_id,
                    'quantity' => $item->quantity,
                    'price'    => $item->book->price,
                ]);

                // Reduce stock
                $item->book->decrement('stock', $item->quantity);
            }

            // Clear selected cart items
            Cart::where('user_id', auth()->id())->whereIn('id', $cartIds)->delete();

            return $createdOrder;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat! Barang akan dikirim dan Pembayaran (COD) dilakukan saat paket tiba.');
    }

    /**
     * Nampilin list order/pesanan milik si user yang lagi login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.book')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Liatin detail satu order/pesanan spesifik.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.book', 'paymentProof');

        return view('orders.show', compact('order'));
    }

    /**
     * Buka form upload bukti bayar (sekarang jarang dipake karena mainnya COD).
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function paymentForm(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        if ($order->paymentProof) {
            return redirect()->route('orders.show', $order)->with('info', 'Bukti pembayaran sudah dikirim.');
        }

        return view('orders.payment', compact('order'));
    }

    /**
     * Proses simpan foto bukti bayar yg dikirim user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadPayment(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('proof')->store('payment-proofs', 'public');

        PaymentProof::create([
            'order_id'  => $order->id,
            'user_id'   => auth()->id(),
            'file_path' => $path,
            'status'    => 'pending',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.');
    }

    /**
     * Action kalau user klik 'Pesanan Diterima'. Ganti status ke completed!
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        if ($order->status !== 'shipped') {
            return back()->with('error', 'Status pesanan tidak dapat diubah menjadi selesai pada tahap ini.');
        }

        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Terima kasih! Pesanan telah berhasil diselesaikan.');
    }
}
