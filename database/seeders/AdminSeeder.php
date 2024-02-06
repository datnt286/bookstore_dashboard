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
            ]
        ]);
    }
}
