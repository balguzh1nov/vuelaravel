<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Заполнение таблицы shops
        DB::table('shops')->insert([
            ['name' => 'Amazon'],
            ['name' => 'Spotify'],
            ['name' => 'Sony Music'],
        ]);

        // Получение ID магазинов
        $amazon = DB::table('shops')->where('name', 'Amazon')->first();
        $spotify = DB::table('shops')->where('name', 'Spotify')->first();
        $sonyMusic = DB::table('shops')->where('name', 'Sony Music')->first();

        // Заполнение таблицы purchases
        DB::table('purchases')->insert([
            [
                'shop_id' => $amazon->id,
                'date' => '2024-01-01',
                'amount' => 201.34,
                'currency' => 'USD',
                'document' => 'document.pdf',
            ],
            [
                'shop_id' => $spotify->id,
                'date' => '2023-12-03',
                'amount' => 77.07,
                'currency' => 'EUR',
                'document' => 'screenshot_1.jpg',
            ],
            [
                'shop_id' => $sonyMusic->id,
                'date' => '2023-11-25',
                'amount' => 23045.44,
                'currency' => 'RUB',
                'document' => 'screenshot_2.jpg',
            ],
        ]);
    }
}
