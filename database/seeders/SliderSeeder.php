<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sliders')->insert([
            [
                'name' => 'Slide 1',
                'book_id' => 1,
                'image' => 'slide-1.jpg',
            ],
            [
                'name' => 'Slide 2',
                'book_id' => 2,
                'image' => 'slide-2.jpg',
            ],
            [
                'name' => 'Slide 3',
                'book_id' => 3,
                'image' => 'slide-3.jpg',
            ],
            [
                'name' => 'Slide 4',
                'book_id' => 4,
                'image' => 'slide-4.jpg',
            ],
        ]);
    }
}
