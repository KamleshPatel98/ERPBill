<?php

namespace Database\Seeders;

use App\Models\Masters\Gst;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Gst::count() == 0){
            $data = [
                [
                    'name' => 'GST 0%',
                    'rate' => 0,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'GST 5%',
                    'rate' => 5,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'GST 12%',
                    'rate' => 12,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'GST 18%',
                    'rate' => 18,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'GST 28%',
                    'rate' => 28,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            Gst::insert($data);   
        }
    }
}
