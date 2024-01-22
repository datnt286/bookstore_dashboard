<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookComboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('book_combo')->insert([
            [
                'book_id' => 5,
                'combo_id' => 1,
            ],
            [
                'book_id' => 6,
                'combo_id' => 1,
            ],
            [
                'book_id' => 7,
                'combo_id' => 1,
            ],
            [
                'book_id' => 8,
                'combo_id' => 1,
            ],
            [
                'book_id' => 9,
                'combo_id' => 1,
            ],
            [
                'book_id' => 10,
                'combo_id' => 1,
            ],
            [
                'book_id' => 11,
                'combo_id' => 2,
            ],
            [
                'book_id' => 12,
                'combo_id' => 2,
            ],
            [
                'book_id' => 13,
                'combo_id' => 2,
            ],
            [
                'book_id' => 14,
                'combo_id' => 3,
            ],
            [
                'book_id' => 15,
                'combo_id' => 3,
            ],
            [
                'book_id' => 16,
                'combo_id' => 3,
            ],
            [
                'book_id' => 17,
                'combo_id' => 3,
            ],
            [
                'book_id' => 18,
                'combo_id' => 4,
            ],
            [
                'book_id' => 19,
                'combo_id' => 4,
            ],
            [
                'book_id' => 20,
                'combo_id' => 4,
            ],
            [
                'book_id' => 21,
                'combo_id' => 4,
            ],
        ]);
    }
}
