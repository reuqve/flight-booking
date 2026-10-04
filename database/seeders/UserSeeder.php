<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "fio" => "Admin Flight",
            "email" => "admin@flight.ru",
            "password" => "QWEasd123",
            "role" => "admin",
        ]);

        User::create([
            "fio" => "User Flight",
            "email" => "user@flight.ru",
            "password" => "password",
            "role" => "client",
        ]);
    }
}
