<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Expert;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::pluck('id')->toArray();
        $experts = Expert::pluck('id')->toArray();

        if (count($clients) < 4 || count($experts) < 3) {
            echo "❌ Yetarli klient yoki ekspert ma'lumotlari mavjud emas!";
            return;
        }

        DB::table('queues')->insert([
            [
                'client_id' => $clients[0] ?? null,
                'expert_id' => $experts[0] ?? null,
                'position' => 1,
                'status' => 'waiting',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[1] ?? null,
                'expert_id' => $experts[0] ?? null,
                'position' => 2,
                'status' => 'waiting',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[2] ?? null,
                'expert_id' => $experts[1] ?? null,
                'position' => 1,
                'status' => 'in_progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[3] ?? null,
                'expert_id' => $experts[2] ?? null,
                'position' => 1,
                'status' => 'completed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
