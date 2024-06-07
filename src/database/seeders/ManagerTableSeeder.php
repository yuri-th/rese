<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'area_id' => '1',
            'shop_id' => '1',
            'name' => '西村忠司',
            'birthdate'=>'1978-05-20',
            'postcode' => '152-5236',
            'address' => '東京都渋谷区本町1-1-4',
            'tel' => '0327917292',
            'email'=>'tadashi_nishimura@example.org',
        ];
        DB::table('managers')->insert($param);

         $param = [
            'area_id' => '2',
            'shop_id' => '2',
            'name' => '平手裕行',
            'birthdate'=>'1969-01-24',
            'postcode' => '549-8798',
            'address' => '大阪府大東市三箇1-3-9',
            'tel' => '0615695782',
            'email'=>'hiroyukihirate@example.net',
        ];
        DB::table('managers')->insert($param);

         $param = [
            'area_id' => '3',
            'shop_id' => '3',
            'name' => '川嶋雄介',
            'birthdate'=>'1978-07-21',
            'postcode' => '837-6745',
            'address' => '福岡県福岡市中央区小笹2-2-6',
            'tel' => '0946392780',
            'email'=>'kawashimayuusuke@example.ne.jp',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '1',
            'shop_id' => '4',
            'name' => '清水圭介',
            'birthdate'=>'1982-06-28',
            'postcode' => '188-7027',
            'address' => '東京都新宿区西新宿2-1-4',
            'tel' => '0310631109',
            'email'=>'shimizukeisuke@example.ne.jp',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '3',
            'shop_id' => '5',
            'name' => '龍佳緒里',
            'birthdate'=>'1975-10-29',
            'postcode' => '810-0001',
            'address' => '福岡県福岡市中央区天神3-3',
            'tel' => '0946392728',
            'email'=>'ryuu_kaori@example.com',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '1',
            'shop_id' => '6',
            'name' => '指田育子',
            'birthdate'=>'1955-02-06',
            'postcode' => '344-1537',
            'address' => '埼玉県幸手市中3-1-8',
            'tel' => '0493582620',
            'email'=>'sashidaikuko@example.net',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '2',
            'shop_id' => '7',
            'name' => '中島輝美',
            'birthdate'=>'1952-11-01',
            'postcode' => '530-4508',
            'address' => '大阪府八尾市南亀井町2-3-8',
            'tel' => '0661012858',
            'email'=>'nakajima111@example.co.jp',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '1',
            'shop_id' => '8',
            'name' => '竹内圭',
            'birthdate'=>'1982-01-28',
            'postcode' => '179-6518',
            'address' => '東京都江戸川区東小岩1-3-1104',
            'tel' => '0328610511',
            'email'=>'kei@example.ne.jp',
        ];
        DB::table('managers')->insert($param);
        
        $param = [
            'area_id' => '2',
            'shop_id' => '9',
            'name' => '篠崎智子',
            'birthdate'=>'1945-10-30',
            'postcode' => '344-5616',
            'address' => '埼玉県さいたま市北区宮原町3-3-807',
            'tel' => '0494575224',
            'email'=>'shinozaki_tomoko@example.org',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '1',
            'shop_id' => '10',
            'name' => '石垣賢',
            'birthdate'=>'1962-10-18',
            'postcode' => '179-6518',
            'address' => '東京都江戸川区東小岩1-3-1104',
            'tel' => '0328610518',
            'email'=>'ken_ishigaki@example.net',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '2',
            'shop_id' => '11',
            'name' => '寺尾崇',
            'birthdate'=>'1971-01-27',
            'postcode' => '565-5861',
            'address' => '大阪府吹田市原町2-1-5',
            'tel' => '0632229783',
            'email'=>'takashiterao@example.org',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '3',
            'shop_id' => '12',
            'name' => '今村泰裕',
            'birthdate'=>'1971-02-27',
            'postcode' => '810-0001',
            'address' => '福岡県福岡市中央区天神1-1',
            'tel' => '0948514633',
            'email'=>'imamura@example.org',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '1',
            'shop_id' => '13',
            'name' => '中島春香',
            'birthdate'=>'1998-12-28',
            'postcode' => '358-3644',
            'address' => '埼玉県さいたま市浦和区針ヶ谷1-5-14',
            'tel' => '0422291691',
            'email'=>'harukanakajima@example.jp',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '2',
            'shop_id' => '14',
            'name' => '坂田智奈美',
            'birthdate'=>'1980-07-27',
            'postcode' => '561-2405',
            'address' => '大阪府大阪市浪速区日本橋3-3-12',
            'tel' => '0653586198',
            'email'=>'sakata_727@example.net',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '1',
            'shop_id' => '15',
            'name' => '南太郎',
            'birthdate'=>'1961-09-20',
            'postcode' => '175-1708',
            'address' => '東京都千代田区九段南1-1-10',
            'tel' => '0322459371',
            'email'=>'tarou_minami@example.net',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '2',
            'shop_id' => '16',
            'name' => '小西康治',
            'birthdate'=>'1967-02-14',
            'postcode' => '530-0041',
            'address' => '大阪府大阪市北区天神橋1-1',
            'tel' => '0668712321',
            'email'=>'konishikoji@example.ne.jp',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '1',
            'shop_id' => '17',
            'name' => '鈴木巌',
            'birthdate'=>'1945-10-19',
            'postcode' => '174-5534',
            'address' => '東京都港区芝3-1-5',
            'tel' => '0357281639',
            'email'=>'suzukiiwao@example.com',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '1',
            'shop_id' => '18',
            'name' => '榊原志津香',
            'birthdate'=>'1976-08-18',
            'postcode' => '135-7480',
            'address' => '東京都練馬区早宮3-4-607',
            'tel' => '0301953309',
            'email'=>'sakakibara_818@example.net',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '3',
            'shop_id' => '19',
            'name' => '野田真太郎',
            'birthdate'=>'2000-11-26',
            'postcode' => '836-7258',
            'address' => '福岡県春日市白水ヶ丘1-3-6',
            'tel' => '0948514930',
            'email'=>'makotogondou@example.co.jp',
        ];
        DB::table('managers')->insert($param);

        $param = [
            'area_id' => '2',
            'shop_id' => '20',
            'name' => '西村美優',
            'birthdate'=>'1961-10-10',
            'postcode' => '530-0042',
            'address' => '大阪府大阪市北区天満橋2-2-3',
            'tel' => '0662111344',
            'email'=>'nishimura_1010@example.jp',
        ];
        DB::table('managers')->insert($param);
    }
}
