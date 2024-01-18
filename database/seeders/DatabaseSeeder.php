<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            AuthorSeeder::class,
            PulisherSeeder::class,
            SupplierSeeder::class,
            BookSeeder::class,
            ImageSeeder::class,
            ComboSeeder::class,
            AuthorBookSeeder::class,
            BookComboSeeder::class,
            AdminSeeder::class,
            CustomerSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
