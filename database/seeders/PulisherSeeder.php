<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PulisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('publishers')->insert([
            [
                'name' => 'NXB Kim Đồng',
            ],
            [
                'name' => 'NXB Trẻ',
            ],
            [
                'name' => 'NXB Giáo dục',
            ],
        ]);
    }
}
