<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'username' => 'dat',
                'password' => Hash::make('123'),
                'name' => 'Nguyễn Thành Đạt',
                'phone' => '0123456789',
                'email' => 'dat@gmail.com',
                'address' => 'Q. Bình Thạnh, TP. HCM',
            ],
            [
                'username' => 'dang',
                'password' => Hash::make('abc123'),
                'name' => 'Đào Hải Đăng',
                'phone' => '0987654321',
                'email' => 'dang@gmail.com',
                'address' => 'Q. 7, TP. HCM',
            ],
            [
                'username' => 'lien',
                'password' => Hash::make('abcXYZ123#'),
                'name' => 'Trần Thị Mai Liên',
                'phone' => '0123498765',
                'email' => 'lien@gmail.com',
                'address' => 'Q. 4, TP. HCM',
            ],
        ]);
    }
}
