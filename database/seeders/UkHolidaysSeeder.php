<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UkHolidaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holidays = [
            ['date' => '2025-01-01', 'description' => 'New Year\'s Day', 'year' => 2025],
            ['date' => '2025-01-02', 'description' => '2nd January (Scotland)', 'year' => 2025],
            ['date' => '2025-03-17', 'description' => 'St. Patrick\'s Day (Northern Ireland)', 'year' => 2025],
            ['date' => '2025-04-18', 'description' => 'Good Friday', 'year' => 2025],
            ['date' => '2025-04-21', 'description' => 'Easter Monday', 'year' => 2025],
            ['date' => '2025-05-05', 'description' => 'Early May Bank Holiday', 'year' => 2025],
            ['date' => '2025-05-26', 'description' => 'Spring Bank Holiday', 'year' => 2025],
            ['date' => '2025-07-12', 'description' => 'Battle of the Boyne (Northern Ireland)', 'year' => 2025],
            ['date' => '2025-08-04', 'description' => 'August Bank Holiday (Scotland)', 'year' => 2025],
            ['date' => '2025-08-25', 'description' => 'Summer Bank Holiday', 'year' => 2025],
            ['date' => '2025-11-30', 'description' => 'St. Andrew\'s Day (Scotland)', 'year' => 2025],
            ['date' => '2025-12-25', 'description' => 'Christmas Day', 'year' => 2025],
            ['date' => '2025-12-26', 'description' => 'Boxing Day', 'year' => 2025],
        ];

        DB::table('holidays')->insert($holidays);
    }
}
