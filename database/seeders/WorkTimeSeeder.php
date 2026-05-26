<?php

namespace Database\Seeders;

use App\Models\WorkTime;
use Illuminate\Database\Seeder;

class WorkTimeSeeder extends Seeder
{
    public function run()
    {
        $doctorId = 55;

        // 1 = segunda, 2 = terça, 3 = quarta, 4 = quinta, 5 = sexta
        $days = [1, 2, 3, 4, 5];

        $periods = [
            ['period' => 'Manhã', 'start_time' => '08:00', 'end_time' => '12:00'],
            ['period' => 'Tarde', 'start_time' => '13:00', 'end_time' => '18:00'],
        ];

        foreach ($days as $day) {
            foreach ($periods as $period) {
                WorkTime::create([
                    'doctor_id'  => $doctorId,
                    'unit_room_id' => 2, // Adicione o campo unit_room_id com um valor válido
                    'day_of_week' => $day,
                    'period'     => $period['period'],
                    'start_time' => $period['start_time'],
                    'end_time'   => $period['end_time'],
                    'observations' => null,
                ]);
            }
        }
    }
}
