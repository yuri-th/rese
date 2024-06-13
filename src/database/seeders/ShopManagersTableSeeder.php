<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '店舗代表者',
            'email' => 'shopmanager@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);
    }
}
