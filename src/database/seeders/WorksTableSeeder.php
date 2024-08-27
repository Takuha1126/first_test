<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class WorksTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('works')->insert([
            [
                'user_id' => 1,
                'start_time' => Carbon::now()->subDays(5)->setTime(9, 0),
                'end_time' => Carbon::now()->subDays(5)->setTime(17, 0),
                'work_time' => 480,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'start_time' => Carbon::now()->subDays(4)->setTime(10, 0),
                'end_time' => Carbon::now()->subDays(4)->setTime(18, 0),
                'work_time' => 480,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'start_time' => Carbon::now()->subDays(3)->setTime(8, 30),
                'end_time' => Carbon::now()->subDays(3)->setTime(17, 30),
                'work_time' => 540,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'start_time' => Carbon::now()->subDays(2)->setTime(9, 0),
                'end_time' => Carbon::now()->subDays(2)->setTime(16, 0),
                'work_time' => 420,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'start_time' => Carbon::now()->subDays(1)->setTime(11, 0),
                'end_time' => Carbon::now()->subDays(1)->setTime(19, 0),
                'work_time' => 480,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
