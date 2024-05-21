<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;




class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user name: admin, password: 2024
        User::insert(
            [
                "id" => str::uuid(),
                "name" => "admin",
                "email" => "sauth.admin@localhost",
                "password" => bcrypt("2024"),
            ],
        );
    }
}
