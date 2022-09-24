<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CouncilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('councils')->insert([
            'council_name' => 'CRM',
        ]);
        DB::table('councils')->insert([
            'council_name' => 'CRN',
        ]);
        DB::table('councils')->insert([
            'council_name' => 'CRFa',
        ]);
        DB::table('councils')->insert([
            'council_name' => 'CBO',
        ]);
    }
}
