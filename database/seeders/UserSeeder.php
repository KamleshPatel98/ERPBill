<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(User::count() == 0){
            User::create([
                'name' => 'Admin',
                'mobile' => '1234567891',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password1@'),
            ]);
        }
    }
}
