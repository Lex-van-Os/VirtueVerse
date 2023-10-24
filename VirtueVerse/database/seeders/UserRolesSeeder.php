<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::create([
            "name"=> "Admin",
        ]);

        UserRole::create([
            "name"=> "Editor",
        ]);

        UserRole::create([
            "name"=> "User",
        ]);
    }
}
