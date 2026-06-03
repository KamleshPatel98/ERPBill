<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([

            [
                'name' => 'Fertilizer',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Pesticide',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Seeds',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Bio Products',
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Khad',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
