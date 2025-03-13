<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Expert;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::pluck('id')->toArray(); // Mavjud klient ID`larini olish
        $experts = Expert::pluck('id')->toArray(); // Mavjud ekspert ID`larini olish

        if (count($clients) < 4 || count($experts) < 3) {
            echo "❌ Yetarli klient yoki ekspert ma'lumotlari mavjud emas!";
            return;
        }

        Review::insert([
            [
                'client_id' => $clients[0],
                'expert_id' => $experts[0],
                'rating' => 5,
                'comment' => 'Juda foydali maslahat oldim!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[1],
                'expert_id' => $experts[1],
                'rating' => 4,
                'comment' => 'Yaxshi maslahat berdi, lekin batafsil bo‘lsa, yaxshi bo‘lar edi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[2],
                'expert_id' => $experts[2],
                'rating' => 3,
                'comment' => 'O‘rtacha maslahat, juda ham aniq emas edi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[3],
                'expert_id' => $experts[0],
                'rating' => 5,
                'comment' => 'Mutaxassis juda bilimli, tavsiya qilaman!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);    }
}
