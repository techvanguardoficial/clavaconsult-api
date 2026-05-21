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
        $councils = [
            ['council_name' => 'CFM',     'description' => 'Conselho Federal de Medicina'],
            ['council_name' => 'CRM',     'description' => 'Conselho Regional de Medicina'],
            ['council_name' => 'CRO',     'description' => 'Conselho Regional de Odontologia'],
            ['council_name' => 'COREN',   'description' => 'Conselho Regional de Enfermagem'],
            ['council_name' => 'CRF',     'description' => 'Conselho Regional de Farmácia'],
            ['council_name' => 'CREFITO', 'description' => 'Conselho Regional de Fisioterapia e Terapia Ocupacional'],
            ['council_name' => 'CRMV',    'description' => 'Conselho Regional de Medicina Veterinária'],
            ['council_name' => 'CRN',     'description' => 'Conselho Regional de Nutrição'],
            ['council_name' => 'CRP',     'description' => 'Conselho Regional de Psicologia'],
            ['council_name' => 'CRQ',     'description' => 'Conselho Regional de Química'],
            ['council_name' => 'CRBio',   'description' => 'Conselho Regional de Biologia'],
            ['council_name' => 'CRBM',    'description' => 'Conselho Regional de Biomedicina'],
            ['council_name' => 'CREF',    'description' => 'Conselho Regional de Educação Física'],
            ['council_name' => 'CREFONO', 'description' => 'Conselho Regional de Fonoaudiologia'],
            ['council_name' => 'CRTR',    'description' => 'Conselho Regional de Técnicos em Radiologia'],
            ['council_name' => 'RMS',     'description' => 'Registro do Ministério da Saúde'],
            ['council_name' => 'CBO',     'description' => null],
            ['council_name' => 'CRFa',    'description' => null],
            ['council_name' => 'SPM',     'description' => null],
        ];

        DB::table('councils')->insert($councils);
    }
}
