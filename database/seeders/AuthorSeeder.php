<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            ['name' => 'Dale Carnegie'],
            ['name' => 'Nguyễn Nhật Ánh'],
            ['name' => 'Rosie Nguyễn'],
            ['name' => 'Tony Buổi Sáng'],
            ['name' => 'Aoyama Gosho'],
            ['name' => 'Gege Akutami'],
            ['name' => 'Tatsuki Fujimoto'],
        ]);
    }
}
