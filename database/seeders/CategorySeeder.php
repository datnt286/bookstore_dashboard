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
                'image' => 'sach-tu-luc.jpg'
            ],
            [
                'name' => 'Truyện tranh',
                'image' => 'truyen-tranh.jpg'
            ],
            [
                'name' => 'Sách giáo khoa',
                'image' => 'sach-giao-khoa.jpg'
            ],
        ]);
    }
}
