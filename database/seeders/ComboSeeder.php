<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('combos')->insert([
            [
                'name' => 'Bộ sách giáo khoa 10',
                'supplier_id' => 3,
                'price' => 550000,
                'quantity' => 50,
                'image' => 'bo-sach-giao-khoa-10.jpg',
                'description' => 'Bộ sách giáo khoa 10',
                'slug' => 'bo-sach-giao-khoa-10',
            ],
            [
                'name' => 'Combo bứt phá điểm thi THPT quốc gia',
                'supplier_id' => 2,
                'price' => 130000,
                'quantity' => 60,
                'image' => 'combo-but-pha-diem-thi-thpt-quoc-gia.jpg',
                'description' => 'Combo bứt phá điểm thi THPT quốc gia',
                'slug' => 'combo-but-pha-diem-thi-thpt-quoc-gia',
            ],
            [
                'name' => 'Combo Chú thuật hồi chiến',
                'supplier_id' => 1,
                'price' => 100000,
                'quantity' => 60,
                'image' => 'combo-chu-thuat-hoi-chien.jpg',
                'description' => 'Combo Chú thuật hồi chiến',
                'slug' => 'combo-chu-thuat-hoi-chien',
            ],
            [
                'name' => 'Combo Chainsaw man',
                'supplier_id' => 2,
                'price' => 150000,
                'quantity' => 50,
                'image' => 'combo-chainsaw-man.jpg',
                'description' => 'Combo Chainsaw-man',
                'slug' => 'combo-chainsaw-man',
            ],
        ]);
    }
}
