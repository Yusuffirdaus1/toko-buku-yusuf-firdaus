<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Carousel;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $mainCarousels = Carousel::where('type', 'main')->where('is_active', true)->orderBy('order')->get();
        $promoCarousels = Carousel::where('type', 'promo')->where('is_active', true)->orderBy('order')->get();
        $featuredBooks = Book::with('category')->where('stock', '>', 0)->latest()->take(8)->get();
        $categories = Category::withCount('books')->get();

        return view('home.index', compact('mainCarousels', 'promoCarousels', 'featuredBooks', 'categories'));
    }
}
