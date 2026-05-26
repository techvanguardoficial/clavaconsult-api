<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class DoctorPlanSeeder extends Seeder
{
    public function run()
    {
        $doctor = Doctor::findOrFail(55);

        $plans = [
            ['name' => 'Particular', 'consultation_value' => 200.00, 'observations' => null],
        ];

        foreach ($plans as $item) {
            $plan = Plan::where('name', $item['name'])->first();

            if (!$plan) {
                $this->command->warn("Plano '{$item['name']}' não encontrado, pulando.");
                continue;
            }

            $doctor->plans()->syncWithoutDetaching([
                $plan->id => [
                    'consultation_value' => $item['consultation_value'],
                    'observations' => $item['observations']
                ],
            ]);
        }
    }
}
