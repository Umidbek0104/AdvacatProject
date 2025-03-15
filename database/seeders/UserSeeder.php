<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // Admin roli
                'phone' => '0123456789',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Client User',
                'email' => 'client@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Client roli
                'phone' => '1234567890',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Expert User',
                'email' => 'expert@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // Expert roli
                'phone' => '2345678901',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Moderator User',
                'email' => 'moderator@example.com',
                'password' => Hash::make('password'),
                'role_id' => 4, // Moderator roli
                'phone' => '3456789012',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        User::factory(50)->create();
    }
}
