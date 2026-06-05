<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('customers')->count() == 0) {

            DB::table('customers')->insert([
                [
                    'name' => 'Rahul Sharma',
                    'mobile' => '9876543210',
                    'address' => 'Raipur',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Amit Verma',
                    'mobile' => '9876543211',
                    'address' => 'Durg',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Priya Gupta',
                    'mobile' => '9876543212',
                    'address' => 'Bhilai',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Neha Singh',
                    'mobile' => '9876543213',
                    'address' => 'Bilaspur',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Rohit Patel',
                    'mobile' => '9876543214',
                    'address' => 'Korba',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Anjali Jain',
                    'mobile' => '9876543215',
                    'address' => 'Raigarh',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Vikas Yadav',
                    'mobile' => '9876543216',
                    'address' => 'Jagdalpur',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pooja Mishra',
                    'mobile' => '9876543217',
                    'address' => 'Ambikapur',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sandeep Kumar',
                    'mobile' => '9876543218',
                    'address' => 'Rajnandgaon',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kavita Sahu',
                    'mobile' => '9876543219',
                    'address' => 'Mahasamund',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
