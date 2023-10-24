<?php

namespace Database\Seeders;

use App\Models\BookEdition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookEditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookEdition::create([
            'title' => 'The "Summa theologica" of St. Thomas Aquinas',
            'isbn' => '',
            'language' => 'English',
            'publication_year' => 1912,
            'book_id' => 8, 
            'pages' => 683,
        ]);

        BookEdition::create([
            'title' => 'The Screwtape Letters',
            'isbn' => '9780020867401',
            'language' => 'English',
            'publication_year' => 1982,
            'book_id' => 1, 
            'pages' => 172,
        ]);

        BookEdition::create([
            'title' => 'The Screwtape Letters',
            'isbn' => '9780060652937',
            'language' => 'English',
            'publication_year' => 2023,
            'book_id' => 1, 
            'pages' => 175,
        ]);
    }
}
