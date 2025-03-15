<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            ['name' => 'Advokat', 'short_description' => 'Huquqiy maslahatlar va xizmatlar'],
            ['name' => 'Huquqshunos', 'short_description' => 'Huquqiy maslahatchi'],
            ['name' => 'Yurist', 'short_description' => 'Yuridik maslahatchi'],
            ['name' => 'Soliq maslahatchisi', 'short_description' => 'Soliq sohasida xizmat ko‘rsatuvchi mutaxassis'],
            ['name' => 'Moliyaviy maslahatchi', 'short_description' => 'Moliyaviy xizmatlar bo‘yicha mutaxassis']
        ];

        foreach ($specializations as $specialization) {
            DB::table('specializations')->insert($specialization);
        }
    }
}
