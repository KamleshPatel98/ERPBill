<?php

namespace Database\Seeders;

use App\Models\Masters\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Supplier::count() == 0){
            $data = [
                [
                    'name' => 'Krishi Agro Traders',
                    'mobile' => '9876543210',
                    'email' => 'krishi@agro.com',
                    'gst_no' => '22ABCDE1234F1Z5',
                    'address' => 'Main Market Road',
                    'city' => 'Raipur',
                    'state_id' => 1,
                    'zip' => '492001',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Bharat Fertilizers',
                    'mobile' => '9123456780',
                    'email' => 'bharat@fertilizer.com',
                    'gst_no' => '22ABCDE5678F1Z2',
                    'address' => 'Station Road',
                    'city' => 'Bilaspur',
                    'state_id' => 1,
                    'zip' => '495001',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Green Crop Suppliers',
                    'mobile' => '9988776655',
                    'email' => 'green@crop.com',
                    'gst_no' => null,
                    'address' => 'Agriculture Market',
                    'city' => 'Bhopal',
                    'state_id' => 2,
                    'zip' => '462001',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kisan Beej Bhandar',
                    'mobile' => '9090909090',
                    'email' => null,
                    'gst_no' => '22ABCDE9999F1Z8',
                    'address' => 'Bus Stand Area',
                    'city' => 'Raipur',
                    'state_id' => 1,
                    'zip' => '492002',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Agro Life Suppliers',
                    'mobile' => '8888888888',
                    'email' => 'info@agrolife.com',
                    'gst_no' => '22ABCDE2222F1Z3',
                    'address' => 'Industrial Area',
                    'city' => 'Indore',
                    'state_id' => 2,
                    'zip' => '452001',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Shree Ram Fertilizer',
                    'mobile' => '7777777777',
                    'email' => 'shreeram@fertilizer.com',
                    'gst_no' => null,
                    'address' => 'Old Market',
                    'city' => 'Durg',
                    'state_id' => 1,
                    'zip' => '491001',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Maa Agro Agency',
                    'mobile' => '6666666666',
                    'email' => 'maa@agro.com',
                    'gst_no' => '22ABCDE3333F1Z7',
                    'address' => 'Naya Bazar',
                    'city' => 'Nagpur',
                    'state_id' => 3,
                    'zip' => '440001',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kisan Mitra Suppliers',
                    'mobile' => '9999999999',
                    'email' => 'kisan@mitra.com',
                    'gst_no' => '22ABCDE4444F1Z6',
                    'address' => 'Main Road',
                    'city' => 'Raigarh',
                    'state_id' => 1,
                    'zip' => '496001',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Om Fertilizer Store',
                    'mobile' => '9555555555',
                    'email' => null,
                    'gst_no' => null,
                    'address' => 'Village Road',
                    'city' => 'Ambikapur',
                    'state_id' => 1,
                    'zip' => '497001',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sai Krishi Traders',
                    'mobile' => '9444444444',
                    'email' => 'sai@krishi.com',
                    'gst_no' => '22ABCDE5555F1Z1',
                    'address' => 'Market Yard',
                    'city' => 'Raipur',
                    'state_id' => 1,
                    'zip' => '492003',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            Supplier::insert($data);
        }
    }
}
