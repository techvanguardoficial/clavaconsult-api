<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        Specialty::create([
            'name' => 'Clínico geral'
        ]);
    }
}
