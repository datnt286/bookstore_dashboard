<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('123'),
                'name' => 'Nguyễn Văn Admin',
                'phone' => '0123456789',
                'email' => 'ntdz2003@gmail.com',
                'address' => 'TP. HCM',
                'avatar' => 'dat.jpg',
            ],
            [
                'username' => 'lien',
                'password' => Hash::make('123456'),
                'name' => 'Trần Thị Mai Liên',
                'phone' => '0987654321',
                'email' => 'havy1772003@gmail.com',
                'address' => 'TP. HCM',
                'avatar' => 'default-avatar.jpg',
            ],
            [
                'username' => 'dang',
                'password' => Hash::make('123abc'),
                'name' => 'Đào Hải Đăng',
                'phone' => '0987612345',
                'email' => 'seadark0104@gmail.com',
                'address' => 'TP. HCM',
                'avatar' => 'default-avatar.jpg',
            ],
        ]);
    }
}
