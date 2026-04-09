<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Carousel;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Nampilin daftar katalog buku, ada filter kategori sama search juga.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $books = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        $mainCarousels = Carousel::where('type', 'main')->where('is_active', true)->orderBy('order')->latest()->get();
        $promoCarousels = Carousel::where('type', 'promo')->where('is_active', true)->orderBy('order')->latest()->get();

        return view('books.index', compact('books', 'categories', 'mainCarousels', 'promoCarousels'));
    }

    /**
     * Buat buka halaman detail buku, plus ngasih tau rekomendasi buku lain.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\View\View
     */
    public function show(Book $book)
    {
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        return view('books.show', compact('book', 'relatedBooks'));
    }
}
