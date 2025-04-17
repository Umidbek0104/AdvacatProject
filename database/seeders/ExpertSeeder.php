<?php

namespace Database\Seeders;

use App\Models\Expert;
use App\Models\Specialization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'User 1', 'email' => 'user1@example.com', 'password' => bcrypt('password'), 'role_id' => 4, 'phone' => '998901234561'],
            ['name' => 'User 2', 'email' => 'user2@example.com', 'password' => bcrypt('password'), 'role_id' => 4, 'phone' => '998901234562'],
            ['name' => 'User 3', 'email' => 'user3@example.com', 'password' => bcrypt('password'), 'role_id' => 4, 'phone' => '998901234563'],
            ['name' => 'User 4', 'email' => 'user4@example.com', 'password' => bcrypt('password'), 'role_id' => 4, 'phone' => '998901234564'],
        ];
        foreach ($users as $userData) {
            $user = User::create($userData);

            // Har bir user uchun ekspert qo‘shamiz
            Expert::create([
                'user_id' => $user->id,
                'specialization' => 3,
                'experience' => '10 yil',
                'rating' => 4.5,
                'bio' => 'Advokat sifatida 10 yillik tajribam bor.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            Expert::create([
                'user_id' => $user->id,
                'specialization' => 2,
                'experience' => '10 yil',
                'rating' => 4.5,
                'bio' => 'Natarius sifatida 10 yillik tajribam bor.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
