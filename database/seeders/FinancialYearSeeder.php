<?php

namespace Database\Seeders;

use App\Models\Masters\FinancialYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(FinancialYear::count() == 0){
            for ($year = 2025; $year <= 2030; $year++) {
                FinancialYear::create([
                    'name'       => $year . '-' . substr($year + 1, -2),
                    'start_date' => '01-04-' . $year,
                    'end_date'   => '31-03-' . ($year + 1),
                    'is_active'  => $year == 2025,
                ]);
            }   
        }
    }
}
