<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
            [
                'book_id' => 1,
                'name' => 'nham-nhi-tet-giap-thin.jpg',
            ],
            [
                'book_id' => 2,
                'name' => 'ben-cua-ngam-xuan.jpg',
            ],
            [
                'book_id' => 3,
                'name' => 'ngon-ngu-yeu-thuong.jpg',
            ],
            [
                'book_id' => 4,
                'name' => 'hum-xam-qua-song.jpg',
            ],
            [
                'book_id' => 5,
                'name' => 'dai-so-10.jpg',
            ],
            [
                'book_id' => 6,
                'name' => 'hinh-hoc-10.jpg',
            ],
            [
                'book_id' => 7,
                'name' => 'ngu-van-10.png',
            ],
            [
                'book_id' => 8,
                'name' => 'tieng-anh-10.jpg',
            ],
            [
                'book_id' => 9,
                'name' => 'vat-li-10.jpg',
            ],
            [
                'book_id' => 10,
                'name' => 'hoa-hoc-10.jpg',
            ],
            [
                'book_id' => 11,
                'name' => 'but-pha-diem-thi-thpt-quoc-gia-mon-toan.jpg',
            ],
            [
                'book_id' => 12,
                'name' => 'but-pha-diem-thi-thpt-quoc-gia-mon-ngu-van.jpg',
            ],
            [
                'book_id' => 13,
                'name' => 'but-pha-diem-thi-thpt-quoc-gia-mon-tieng-anh.jpg',
            ],
            [
                'book_id' => 14,
                'name' => 'chu-thuat-hoi-chien-1.jpg',
            ],
            [
                'book_id' => 15,
                'name' => 'chu-thuat-hoi-chien-2.jpg',
            ],
            [
                'book_id' => 16,
                'name' => 'chu-thuat-hoi-chien-3.jpg',
            ],
            [
                'book_id' => 17,
                'name' => 'chu-thuat-hoi-chien-4.jpg',
            ],
            [
                'book_id' => 18,
                'name' => 'chainsaw-man-1.jpg',
            ],
            [
                'book_id' => 19,
                'name' => 'chainsaw-man-2.jpg',
            ],
            [
                'book_id' => 20,
                'name' => 'chainsaw-man-3.jpg',
            ],
            [
                'book_id' => 21,
                'name' => 'chainsaw-man-4.jpg',
            ],
            [
                'book_id' => 22,
                'name' => 'tham-tu-lung-danh-conan-100.jpg',
            ],
            [
                'book_id' => 23,
                'name' => 'dac-nhan-tam.jpg',
            ],
            [
                'book_id' => 24,
                'name' => 'quang-ganh-lo-di-va-vui-song.jpg',
            ],
            [
                'book_id' => 25,
                'name' => 'tuoi-tre-dang-gia-bao-nhieu.jpg',
            ],
            [
                'book_id' => 26,
                'name' => 'minh-noi-gi-khi-noi-ve-hanh-phuc.jpg',
            ],
            [
                'book_id' => 26,
                'name' => 'minh-noi-gi-khi-noi-ve-hanh-phuc-2.jpg',
            ],
            [
                'book_id' => 27,
                'name' => 'cho-toi-mot-ve-di-tuoi-tho.jpg',
            ],
            [
                'book_id' => 28,
                'name' => 'ca-phe-cung-tony.jpg',
            ],
        ]);
    }
}
