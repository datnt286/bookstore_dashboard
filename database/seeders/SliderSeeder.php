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
                'name' => 'Slide Nhâm nhi Tết Giáp Thìn',
                'book_id' => 1,
                'image' => 'slide-nham-nhi-tet-giap-thin.jpg',
            ],
            [
                'name' => 'Slide Bên cửa ngắm xuân',
                'book_id' => 2,
                'image' => 'slide-ben-cua-ngam-xuan.jpg',
            ],
            [
                'name' => 'Slide Ngôn ngữ yêu thương',
                'book_id' => 3,
                'image' => 'slide-ngon-ngu-yeu-thuong.jpg',
            ],
            [
                'name' => 'Slide Hùm xám qua sông',
                'book_id' => 4,
                'image' => 'slide-hum-xam-qua-song.jpg',
            ],
        ]);
    }
}
