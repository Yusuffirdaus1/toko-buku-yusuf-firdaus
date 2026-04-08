<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::orderBy('order')->paginate(10);
        return view('admin.carousels.index', compact('carousels'));
    }

    public function create()
    {
        return view('admin.carousels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'image_path'  => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'type'        => 'required|in:main,promo',
            'link'        => 'nullable|url',
            'order'       => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $data = $request->except('image_path');
        $data['image_path'] = $request->file('image_path')->store('carousels', 'public');
        $data['is_active'] = $request->boolean('is_active');

        Carousel::create($data);

        return redirect()->route('admin.carousels.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Carousel $carousel)
    {
        return view('admin.carousels.edit', compact('carousel'));
    }

    public function update(Request $request, Carousel $carousel)
    {
        $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'image_path'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'type'        => 'required|in:main,promo',
            'link'        => 'nullable|url',
            'order'       => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $data = $request->except('image_path');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image_path')) {
            Storage::disk('public')->delete($carousel->image_path);
            $data['image_path'] = $request->file('image_path')->store('carousels', 'public');
        }

        $carousel->update($data);

        return redirect()->route('admin.carousels.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Carousel $carousel)
    {
        Storage::disk('public')->delete($carousel->image_path);
        $carousel->delete();

        return back()->with('success', 'Banner berhasil dihapus.');
    }
}
