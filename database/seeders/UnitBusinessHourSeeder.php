<?php

namespace Database\Seeders;

use App\Models\UnitAddress;
use App\Models\UnitBusinessHour;
use Illuminate\Database\Seeder;

class UnitBusinessHourSeeder extends Seeder
{
    public function run()
    {
        // 0=Domingo, 1=Segunda, 2=Terça, 3=Quarta, 4=Quinta, 5=Sexta, 6=Sábado
        $schedule = [
            ['day_of_week' => 0, 'is_closed' => true,  'start_time' => null,    'end_time' => null],
            ['day_of_week' => 1, 'is_closed' => false, 'start_time' => '08:00', 'end_time' => '20:00'],
            ['day_of_week' => 2, 'is_closed' => false, 'start_time' => '08:00', 'end_time' => '20:00'],
            ['day_of_week' => 3, 'is_closed' => false, 'start_time' => '08:00', 'end_time' => '20:00'],
            ['day_of_week' => 4, 'is_closed' => false, 'start_time' => '08:00', 'end_time' => '20:00'],
            ['day_of_week' => 5, 'is_closed' => false, 'start_time' => '08:00', 'end_time' => '20:00'],
            ['day_of_week' => 6, 'is_closed' => false, 'start_time' => '08:00', 'end_time' => '14:00'],
        ];

        UnitAddress::all()->each(function (UnitAddress $unit) use ($schedule) {
            foreach ($schedule as $hours) {
                UnitBusinessHour::updateOrCreate(
                    [
                        'unit_address_id' => $unit->id,
                        'day_of_week'     => $hours['day_of_week'],
                    ],
                    [
                        'start_time' => $hours['start_time'],
                        'end_time'   => $hours['end_time'],
                        'is_closed'  => $hours['is_closed'],
                    ]
                );
            }
        });
    }
}
