<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
           [
            'name' => 'Москва - Санкт-Петербург',
            'description' => 'Прямой рейс Москва - Санкт-Петербург',
            'price' => 4500.00,
           ],
                      [
            'name' => 'Москва - Сочи',
            'description' => 'Прямой рейс Москва - Сочи',
            'price' => 7200.00,
           ],
                      [
            'name' => 'Санкт-Петербург - Казань',
            'description' => 'Прямой рейс Санкт-Петербург - Казань',
            'price' => 6100.00,
           ],
                      [
            'name' => 'Москва - Новосибирск',
            'description' => 'Прямой рейс Москва - Новосибирск',
            'price' => 8900.00,
           ],
                      [
            'name' => 'Казань - Екатеринбург',
            'description' => 'Прямой рейс Казань - Екатеринбург',
            'price' => 5300.00,
           ]
        ]);
    }
}
