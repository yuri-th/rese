<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * 管理者用管理システムログイン情報
     */
    public function run()
    {
        $param = [
            'name' => '管理者',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
        DB::table('admins')->insert($param);
    }
}
