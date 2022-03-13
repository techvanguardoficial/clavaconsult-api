<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $this->call([
            SpecialtySeeder::class,
            PlanSeeder::class,
            UserSeeder::class,
            // DoctorSeeder::class,
            // PatientSeeder::class
        ]);
    }
}
