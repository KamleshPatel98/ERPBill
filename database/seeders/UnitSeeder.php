<?php

namespace Database\Seeders;

use App\Models\Masters\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Unit::count() == 0){
            $units = [
                [
                    'name' => 'Kilogram',
                    'short_name' => 'kg',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Gram',
                    'short_name' => 'gm',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Litre',
                    'short_name' => 'ltr',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Millilitre',
                    'short_name' => 'ml',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Bag',
                    'short_name' => 'bag',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Packet',
                    'short_name' => 'pkt',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Piece',
                    'short_name' => 'pc',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Dozen',
                    'short_name' => 'doz',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            Unit::insert($units);
        }
    }
}
