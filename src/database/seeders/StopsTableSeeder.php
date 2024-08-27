<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class StopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('stops')->insert([
            [
                'user_id' => 1,
                'work_id' => 1,
                'break_in' => '09:00:00',
                'break_out' => '09:30:00',
                'rest_time' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'work_id' => 1,
                'break_in' => '12:00:00',
                'break_out' => '12:45:00',
                'rest_time' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'work_id' => 2,
                'break_in' => '10:00:00',
                'break_out' => '10:20:00',
                'rest_time' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'work_id' => 2,
                'break_in' => '14:00:00',
                'break_out' => '14:30:00',
                'rest_time' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'work_id' => 3,
                'break_in' => '11:00:00',
                'break_out' => '11:15:00',
                'rest_time' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
