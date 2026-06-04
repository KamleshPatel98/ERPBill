<?php

namespace Database\Seeders;

use App\Models\Masters\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(State::count() == 0)
        {
            $activeStates = [
                'Chhattisgarh',
                'Madhya Pradesh',
                'Odisha',
                'Maharashtra',
                'Jharkhand',
                'Uttar Pradesh',
            ];

            $states = [
                ['name' => 'Chhattisgarh', 'code' => 'CG'],
                ['name' => 'Madhya Pradesh', 'code' => 'MP'],
                ['name' => 'Odisha', 'code' => 'OD'],
                ['name' => 'Maharashtra', 'code' => 'MH'],
                ['name' => 'Jharkhand', 'code' => 'JH'],
                ['name' => 'Uttar Pradesh', 'code' => 'UP'],

                // Other states (inactive)
                ['name' => 'Bihar', 'code' => 'BR'],
                ['name' => 'Rajasthan', 'code' => 'RJ'],
                ['name' => 'Gujarat', 'code' => 'GJ'],
                ['name' => 'West Bengal', 'code' => 'WB'],
                ['name' => 'Karnataka', 'code' => 'KA'],
                ['name' => 'Tamil Nadu', 'code' => 'TN'],
                ['name' => 'Kerala', 'code' => 'KL'],
                ['name' => 'Punjab', 'code' => 'PB'],
                ['name' => 'Haryana', 'code' => 'HR'],
                ['name' => 'Delhi', 'code' => 'DL'],
            ];

            $data = [];

            foreach ($states as $state) {

                $data[] = [
                    'name' => $state['name'],
                    'code' => $state['code'],
                    'is_active' => in_array($state['name'], $activeStates) ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            State::insert($data);
        }
    }
}
