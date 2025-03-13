<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', 4)->get(); // 4 - Client roli deb faraz qilamiz
        if ($users->isEmpty()) {
            echo "❌ Hech qanday Client topilmadi! Avval users seederini ishga tushiring!\n";
            return;
        }
        foreach ($users as $user) {
            Client::create([
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
