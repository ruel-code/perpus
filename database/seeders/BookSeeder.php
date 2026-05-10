<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $fiksi = Category::where('name', 'Fiksi')->first();
        $akademik = Category::where('name', 'Akademik')->first();

        $books = [
            [
                'category_id' => $fiksi->id,
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9789793062791',
                'stock' => 10,
                'available_stock' => 10,
            ],
            [
                'category_id' => $fiksi->id,
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'isbn' => '9789799731234',
                'stock' => 5,
                'available_stock' => 5,
            ],
            [
                'category_id' => $akademik->id,
                'title' => 'Calculus: Early Transcendentals',
                'author' => 'James Stewart',
                'publisher' => 'Cengage Learning',
                'isbn' => '9781285741550',
                'stock' => 3,
                'available_stock' => 3,
            ],
            [
                'category_id' => $akademik->id,
                'title' => 'Modern Operating Systems',
                'author' => 'Andrew S. Tanenbaum',
                'publisher' => 'Pearson',
                'isbn' => '9780133591620',
                'stock' => 7,
                'available_stock' => 7,
            ],
            [
                'category_id' => $fiksi->id,
                'title' => 'Hujan',
                'author' => 'Tere Liye',
                'publisher' => 'Gramedia',
                'isbn' => '9786020324784',
                'stock' => 12,
                'available_stock' => 12,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
