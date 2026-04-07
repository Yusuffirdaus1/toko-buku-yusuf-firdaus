<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Carousel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin & Test User
        User::create([
            'name'     => 'Admin Toko Buku',
            'email'    => 'admin@tokobuku.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'user@tokobuku.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // Categories
        $fiksi = Category::create(['name' => 'Fiksi', 'slug' => 'fiksi', 'description' => 'Novel, cerpen, dan karya fiksi lainnya']);
        $nonfiksi = Category::create(['name' => 'Non-Fiksi', 'slug' => 'non-fiksi', 'description' => 'Biografi, sejarah, dan buku informatif']);
        $teknologi = Category::create(['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Pemrograman, IT, dan teknologi terkini']);
        $bisnis = Category::create(['name' => 'Bisnis', 'slug' => 'bisnis', 'description' => 'Manajemen, keuangan, dan enterpreneur']);
        $edukasi = Category::create(['name' => 'Edukasi', 'slug' => 'edukasi', 'description' => 'Buku pelajaran dan pendidikan']);

        // Books
        $books = [
            ['category_id' => $fiksi->id, 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'price' => 85000, 'stock' => 25, 'year' => 2005, 'publisher' => 'Bentang Pustaka', 'description' => 'Kisah inspiratif tentang perjuangan anak-anak Belitung dalam menggapai pendidikan.'],
            ['category_id' => $fiksi->id, 'title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'price' => 95000, 'stock' => 18, 'year' => 1980, 'publisher' => 'Hasta Mitra', 'description' => 'Tetralogi Buru yang menceritakan kehidupan kolonial Belanda di Indonesia.'],
            ['category_id' => $teknologi->id, 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'price' => 180000, 'stock' => 12, 'year' => 2008, 'publisher' => 'Prentice Hall', 'description' => 'Panduan menulis kode program yang bersih, mudah dibaca, dan maintainable.'],
            ['category_id' => $teknologi->id, 'title' => 'Laravel: Up & Running', 'author' => 'Matt Stauffer', 'price' => 215000, 'stock' => 8, 'year' => 2022, 'publisher' => "O'Reilly", 'description' => 'Panduan lengkap membangun aplikasi web modern dengan framework Laravel.'],
            ['category_id' => $bisnis->id, 'title' => 'Rich Dad Poor Dad', 'author' => 'Robert Kiyosaki', 'price' => 79000, 'stock' => 30, 'year' => 1997, 'publisher' => 'Warner Books', 'description' => 'Pelajaran tentang uang dan investasi dari dua perspektif berbeda.'],
            ['category_id' => $nonfiksi->id, 'title' => 'Sapiens: Riwayat Singkat Umat Manusia', 'author' => 'Yuval Noah Harari', 'price' => 125000, 'stock' => 15, 'year' => 2011, 'publisher' => 'Kepustakaan Populer Gramedia', 'description' => 'Perjalanan spesies Homo sapiens dari savana Afrika hingga mendominasi bumi.'],
            ['category_id' => $edukasi->id, 'title' => 'Matematika untuk SMA Kelas 12', 'author' => 'Tim Penulis', 'price' => 55000, 'stock' => 40, 'year' => 2023, 'publisher' => 'Erlangga', 'description' => 'Buku pelajaran matematika kurikulum Merdeka untuk SMA kelas 12.'],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Carousels
        Carousel::create(['title' => 'Selamat Datang di Toko Buku Kami', 'description' => 'Temukan buku favorit Anda dengan harga terbaik', 'image_path' => 'placeholder-main.jpg', 'type' => 'main', 'order' => 1, 'is_active' => true]);
        Carousel::create(['title' => 'Promo Akhir Tahun', 'description' => 'Diskon hingga 30% untuk buku pilihan', 'image_path' => 'placeholder-promo1.jpg', 'type' => 'promo', 'order' => 1, 'is_active' => true]);
        Carousel::create(['title' => 'Buku Teknologi Terbaru', 'description' => 'Update skill programming Anda', 'image_path' => 'placeholder-promo2.jpg', 'type' => 'promo', 'order' => 2, 'is_active' => true]);
    }
}
