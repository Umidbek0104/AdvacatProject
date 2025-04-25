<?php

namespace Database\Seeders;

use App\Models\Expert;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'User 1', 'email' => 'user1@example.com', 'password' => bcrypt('password'), 'role_id' => 2, 'phone' => '998901234561'], // Advokat
            ['name' => 'User 2', 'email' => 'user2@example.com', 'password' => bcrypt('password'), 'role_id' => 3, 'phone' => '998901234562'], // Notarius
            ['name' => 'User 3', 'email' => 'user3@example.com', 'password' => bcrypt('password'), 'role_id' => 2, 'phone' => '998901234563'], // Advokat
            ['name' => 'User 4', 'email' => 'user4@example.com', 'password' => bcrypt('password'), 'role_id' => 3, 'phone' => '998901234564'], // Notarius
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            // Role_id'ga qarab, tegishli ekspertlarni yaratamiz
            if ($user->role_id == 2) { // Agar role_id 2 (Advokat) bo'lsa
                Expert::create([
                    'user_id' => $user->id,
                    'specialization' => 3, // Advokat uchun spesializatsiya
                    'experience' => '10 yil',
                    'rating' => 4.5,
                    'bio' => 'Advokat sifatida 10 yillik tajribam bor.',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } elseif ($user->role_id == 3) { // Agar role_id 3 (Notarius) bo'lsa
                Expert::create([
                    'user_id' => $user->id,
                    'specialization' => 2, // Natarius uchun spesializatsiya
                    'experience' => '10 yil',
                    'rating' => 4.8,
                    'bio' => 'Natarius sifatida 10 yillik tajribam bor.',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
