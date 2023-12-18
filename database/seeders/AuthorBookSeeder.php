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
                'book_id' => 16,
            ],
            [
                'author_id' => 1,
                'book_id' => 17,
            ],
            [
                'author_id' => 6,
                'book_id' => 10,
            ],
            [
                'author_id' => 6,
                'book_id' => 11,
            ],
            [
                'author_id' => 6,
                'book_id' => 12,
            ],
            [
                'author_id' => 6,
                'book_id' => 13,
            ],
            [
                'author_id' => 5,
                'book_id' => 14,
            ],
            [
                'author_id' => 7,
                'book_id' => 15,
            ],
        ]);
    }
}
