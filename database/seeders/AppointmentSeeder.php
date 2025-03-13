<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Expert;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::pluck('id')->toArray(); // Mavjud klientlarni olish
        $experts = Expert::pluck('id')->toArray(); // Mavjud ekspertlarni olish

        if (count($clients) < 4 || count($experts) < 3) {
            echo "❌ Yetarli klient yoki ekspert ma'lumotlari mavjud emas!";
            return;
        }

        Appointment::insert([
            [
                'client_id' => $clients[0],
                'expert_id' => $experts[0],
                'date' => '2024-03-20',
                'time' => '10:00:00',
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[1],
                'expert_id' => $experts[1],
                'date' => '2024-03-21',
                'time' => '14:30:00',
                'status' => 'confirmed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[2],
                'expert_id' => $experts[2],
                'date' => '2024-03-22',
                'time' => '09:15:00',
                'status' => 'completed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[3],
                'expert_id' => $experts[0],
                'date' => '2024-03-23',
                'time' => '16:45:00',
                'status' => 'cancelled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
