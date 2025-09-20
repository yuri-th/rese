<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'shop_id' => '1',
            'user_id' => '1',
            'num_of_users' => '1',
            'date' => '2025-09-30',
            'start_at' => '18:00:00',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'shop_id' => '2',
            'user_id' => '1',
            'num_of_users' => '3',
            'date' => '2025-10-01',
            'start_at' => '18:00:00',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'shop_id' => '1',
            'user_id' => '2',
            'num_of_users' => '2',
            'date' => '2025-10-15',
            'start_at' => '18:00:00',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'shop_id' => '2',
            'user_id' => '2',
            'num_of_users' => '6',
            'date' => '2025-10-25',
            'start_at' => '18:00:00',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'shop_id' => '10',
            'user_id' => '3',
            'num_of_users' => '3',
            'date' => '2024-10-31',
            'start_at' => '19:00:00',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'shop_id' => '1',
            'user_id' => '3',
            'num_of_users' => '2',
            'date' => '2025-11-01',
            'start_at' => '18:00:00',
        ];
        DB::table('reservations')->insert($param);
    }
}
