<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $doctor = Doctor::create([
            'specialty_id' => 1,
        ]);

        $user = new User([
            'name' => 'Médico 1',
            'email' => 'medico1@clavaconsult.com.br',
            'password' => '12345678',
            'admin' => false
        ]);

        $doctor->user()->save($user);
    }
}
