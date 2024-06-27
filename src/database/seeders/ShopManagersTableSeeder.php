<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * 店舗代表者用管理システムログイン情報
     */
    public function run()
    {
        $param = [
            'name' => '西村忠司',
            'email' => 'tadashi_nishimura@example.org',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '平手裕行',
            'email' => 'hiroyukihirate@example.net',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '川嶋雄介',
            'email' => 'kawashimayuusuke@example.ne.jp',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '清水圭介',
            'email' => 'shimizukeisuke@example.ne.jp',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '龍佳緒里',
            'email' => 'ryuu_kaori@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '指田育子',
            'email' => 'sashidaikuko@example.net',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '中島輝美',
            'email' => 'nakajima111@example.co.jp',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '竹内圭',
            'email' => 'kei@example.ne.jp',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '篠崎智子',
            'email' => 'shinozaki_tomoko@example.org',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);

        $param = [
            'name' => '石垣賢',
            'email' => 'ken_ishigaki@example.net',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('shop_managers')->insert($param);
    }
}