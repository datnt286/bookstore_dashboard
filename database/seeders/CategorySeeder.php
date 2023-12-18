<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Sách tự lực',
                'image' => 'sach-tu-luc.jpg',
                'slug' => 'sach-tu-luc'
            ],
            [
                'name' => 'Truyện tranh',
                'image' => 'truyen-tranh.jpg',
                'slug' => 'truyen-tranh',
            ],
            [
                'name' => 'Sách giáo khoa',
                'image' => 'sach-giao-khoa.jpg',
                'slug' => 'sach-giao-khoa',
            ],
        ]);
    }
}
