<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // semua akun memakai password: password
        User::factory()->create([
            'name' => 'Admin Toko', 'email' => 'admin@toko.test', 'role' => 'admin',
        ]);
        User::factory()->create(['name' => 'Budi', 'email' => 'budi@toko.test']);
        User::factory()->create(['name' => 'Sari', 'email' => 'sari@toko.test']);

        $novel = Category::create(['name' => 'Novel']);
        $diri  = Category::create(['name' => 'Pengembangan Diri']);
        $tekno = Category::create(['name' => 'Teknologi']);

        $books = [
            [$novel, 'Laskar Pelangi', 'Andrea Hirata', 89000, 12],
            [$novel, 'Bumi Manusia', 'Pramoedya Ananta Toer', 135000, 5],
            [$diri, 'Filosofi Teras', 'Henry Manampiring', 98000, 20],
            [$diri, 'Atomic Habits', 'James Clear', 108000, 3],
            [$tekno, 'Clean Code', 'Robert C. Martin', 450000, 2],
        ];

        foreach ($books as [$category, $title, $author, $price, $stock]) {
            Book::create([
                'category_id' => $category->id,
                'title'       => $title,
                'author'      => $author,
                'price'       => $price,
                'stock'       => $stock,
            ]);
        }
    }
}