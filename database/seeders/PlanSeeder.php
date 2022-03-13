<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Particular'
        ]);
    }
}
