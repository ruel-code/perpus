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
                'type' => 'Buku',
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9789793062791',
                'publish_year' => 2005,
                'shelf_location' => 'Rak Fiksi-A1',
                'stock' => 10,
                'available_stock' => 10,
                'cover_image' => 'https://covers.openlibrary.org/b/id/7079796-L.jpg',
            ],
            [
                'category_id' => $fiksi->id,
                'type' => 'Buku',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'isbn' => '9789799731234',
                'publish_year' => 1980,
                'shelf_location' => 'Rak Fiksi-B2',
                'stock' => 5,
                'available_stock' => 5,
                'cover_image' => 'https://covers.openlibrary.org/b/id/14840998-L.jpg',
            ],
            [
                'category_id' => $akademik->id,
                'type' => 'Buku',
                'title' => 'Calculus: Early Transcendentals',
                'author' => 'James Stewart',
                'publisher' => 'Cengage Learning',
                'isbn' => '9781285741550',
                'publish_year' => 2015,
                'shelf_location' => 'Rak Sains-01',
                'stock' => 3,
                'available_stock' => 3,
                'cover_image' => 'https://covers.openlibrary.org/b/id/14809415-L.jpg',
            ],
            [
                'category_id' => $akademik->id,
                'type' => 'Buku',
                'title' => 'Modern Operating Systems',
                'author' => 'Andrew S. Tanenbaum',
                'publisher' => 'Pearson',
                'isbn' => '9780133591620',
                'publish_year' => 2014,
                'shelf_location' => 'Rak Komputer-C3',
                'stock' => 7,
                'available_stock' => 7,
                'cover_image' => 'https://covers.openlibrary.org/b/id/7294469-L.jpg',
            ],
            [
                'category_id' => $fiksi->id,
                'type' => 'Buku',
                'title' => 'Hujan',
                'author' => 'Tere Liye',
                'publisher' => 'Gramedia',
                'isbn' => '9786020324784',
                'publish_year' => 2016,
                'shelf_location' => 'Rak Fiksi-A2',
                'stock' => 12,
                'available_stock' => 12,
                'cover_image' => 'https://covers.openlibrary.org/b/id/10872657-L.jpg',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
