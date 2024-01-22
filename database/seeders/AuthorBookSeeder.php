<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('author_book')->insert([
            [
                'author_id' => 1,
                'book_id' => 23,
            ],
            [
                'author_id' => 1,
                'book_id' => 24,
            ],
            [
                'author_id' => 2,
                'book_id' => 27,
            ],
            [
                'author_id' => 3,
                'book_id' => 25,
            ],
            [
                'author_id' => 3,
                'book_id' => 26,
            ],
            [
                'author_id' => 4,
                'book_id' => 28,
            ],
            [
                'author_id' => 5,
                'book_id' => 22,
            ],
            [
                'author_id' => 6,
                'book_id' => 14,
            ],
            [
                'author_id' => 6,
                'book_id' => 15,
            ],
            [
                'author_id' => 6,
                'book_id' => 16,
            ],
            [
                'author_id' => 6,
                'book_id' => 17,
            ],
            [
                'author_id' => 7,
                'book_id' => 18,
            ],
            [
                'author_id' => 7,
                'book_id' => 19,
            ],
            [
                'author_id' => 7,
                'book_id' => 20,
            ],
            [
                'author_id' => 7,
                'book_id' => 21,
            ],
        ]);
    }
}
