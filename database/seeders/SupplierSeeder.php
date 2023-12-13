<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'name' => 'NXB Kim Đồng',
                'phone' => '0987654321',
                'email' => 'nxbkimdong@gmail.com',
                'address' => '248 Cống Quỳnh, Q. 1, TP. HCM',
            ],
            [
                'name' => 'NXB Trẻ',
                'phone' => '0123498765',
                'email' => 'nxbtre@gmail.com',
                'address' => '161B Lý Chính Thắng, P. Võ Thị Sáu, Q. 3 , TP. HCM',
            ],
            [
                'name' => 'NXB Giáo dục',
                'phone' => '0123456789',
                'email' => 'nxbgd@gmail.com',
                'address' => '231 Nguyễn Văn Cừ, Q. 5, TP. HCM',
            ],
        ]);
    }
}
