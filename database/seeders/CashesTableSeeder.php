<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('cashes')->insert([
        //     'cash' => 0,
        //     'today_commisoin' => 0,
        //     'pre_day_paikar_due' => 0,
        //     'today_amount' => 0,
        //     'total_amanot' => 0,
        //     'date' => Carbon::yesterday(), // yesterday date
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

           DB::table('cashes')->insert([
            'cash' => 0,
            'today_commisoin' => 0,
            'pre_day_paikar_due' => 0,
            'today_amount' => 0,
            'total_amanot' => 0,
            'date' => Carbon::today(), // today date
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
