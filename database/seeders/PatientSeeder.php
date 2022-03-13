<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $patient = Patient::create([
            'name' => 'Paciente 1',
            'birthday' => '1990-02-01',
            'gender' => 'male',
            'document' => '99999999999',
            'phone' => '99999999999',
            'email' => 'paciente1@gmail.com'
        ]);

        $address = new Address([
            'street' => 'Rua de Exemplo',
            'number' => '100',
            'neighborhood' => 'Ilha do Governador',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ',
            'zip_code' => '99999999'
        ]);

        $patient->address()->save($address);
    }
}
