<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Nampilin list keranjang belanja user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cartItems = Cart::with('book.category')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->book->price);

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Masukin buku ke keranjang atau nambahin jumlah kalau udah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'integer|min:1',
        ]);

        $book = Book::findOrFail($request->book_id);
        $quantity = $request->quantity ?? 1;

        if ($book->stock < $quantity) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $quantity;
            if ($book->stock < $newQty) {
                return back()->with('error', 'Stok buku tidak mencukupi.');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id'  => auth()->id(),
                'book_id'  => $book->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', '"' . $book->title . '" berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update jumlah barang di keranjang via POST request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);

        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($cart->book->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    /**
     * Buang item dari keranjang (permanen DELETE).
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    /**
     * Update Qty item pakai link GET biasa buat tombol +/-.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @param  string  $action  inc / dec
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGet(Request $request, Cart $cart, $action)
    {
        if ($cart->user_id !== auth()->id()) abort(403);

        $quantity = $cart->quantity;
        if ($action === 'inc') {
            $quantity++;
        } elseif ($action === 'dec') {
            $quantity--;
        }

        if ($quantity < 1) {
            $cart->delete();
            return back()->with('success', 'Item dihapus dari keranjang.');
        }

        if ($cart->book->stock < $quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart->update(['quantity' => $quantity]);
        return back();
    }

    /**
     * Hapus item dari keranjang cuma pake link doang (GET).
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyGet(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);
        
        $cart->delete();
        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
