<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $specialties = [
            ['id' => 1, 'name' => 'Clínico Geral', 'actuation' => 'Clínico Geral'],
            ['id' => 2, 'name' => 'Acupuntura', 'actuation' => 'Acupunturista'],
            ['id' => 3, 'name' => 'Alergologia e Imunologia', 'actuation' => 'Alergista e Imunologista'],
            ['id' => 4, 'name' => 'Anestesiologia', 'actuation' => 'Anestesiologista'],
            ['id' => 5, 'name' => 'Angiologia', 'actuation' => 'Angiologista'],
            ['id' => 6, 'name' => 'Cancerologia (Oncologia)', 'actuation' => 'Oncologista'],
            ['id' => 7, 'name' => 'Cardiologia', 'actuation' => 'Cardiologista'],
            ['id' => 8, 'name' => 'Cirurgia Cardíaca', 'actuation' => 'Cirurgião Cardíaco'],
            ['id' => 9, 'name' => 'Cirurgia de Cabeça e Pescoço', 'actuation' => 'Cirurgião de Cabeça e Pescoço'],
            ['id' => 10, 'name' => 'Cirurgia do Aparelho Digestivo', 'actuation' => 'Cirurgião do Aparelho Digestivo'],
            ['id' => 11, 'name' => 'Cirurgia Geral', 'actuation' => 'Cirurgião Geral'],
            ['id' => 12, 'name' => 'Cirurgia Pediátrica', 'actuation' => 'Cirurgião Pediátrico'],
            ['id' => 13, 'name' => 'Cirurgia Plástica', 'actuation' => 'Cirurgião Plástico'],
            ['id' => 14, 'name' => 'Cirurgia Torácica', 'actuation' => 'Cirurgião Torácico'],
            ['id' => 15, 'name' => 'Cirurgia Vascular', 'actuation' => 'Cirurgião Vascular'],
            ['id' => 16, 'name' => 'Clínica Médica', 'actuation' => 'Clínico (Internista)'],
            ['id' => 17, 'name' => 'Coloproctologia', 'actuation' => 'Coloproctologista'],
            ['id' => 18, 'name' => 'Dermatologia', 'actuation' => 'Dermatologista'],
            ['id' => 19, 'name' => 'Endocrinologia', 'actuation' => 'Endocrinologista'],
            ['id' => 20, 'name' => 'Endoscopia', 'actuation' => 'Endoscopista'],
            ['id' => 21, 'name' => 'Gastroenterologia', 'actuation' => 'Gastroenterologista'],
            ['id' => 22, 'name' => 'Genética Médica', 'actuation' => 'Geneticista'],
            ['id' => 23, 'name' => 'Geriatria', 'actuation' => 'Geriatra'],
            ['id' => 24, 'name' => 'Ginecologia e Obstetrícia', 'actuation' => 'Ginecologista e Obstetra'],
            ['id' => 25, 'name' => 'Hematologia e Hemoterapia', 'actuation' => 'Hematologista'],
            ['id' => 26, 'name' => 'Homeopatia', 'actuation' => 'Homeopata'],
            ['id' => 27, 'name' => 'Infectologia', 'actuation' => 'Infectologista'],
            ['id' => 28, 'name' => 'Mastologia', 'actuation' => 'Mastologista'],
            ['id' => 29, 'name' => 'Medicina de Família e Comunidade', 'actuation' => 'Médico de Família e Comunidade'],
            ['id' => 30, 'name' => 'Medicina do Trabalho', 'actuation' => 'Médico do Trabalho'],
            ['id' => 31, 'name' => 'Medicina do Tráfego', 'actuation' => 'Médico de Tráfego'],
            ['id' => 32, 'name' => 'Medicina Esportiva', 'actuation' => 'Médico do Esporte'],
            ['id' => 33, 'name' => 'Medicina Física e Reabilitação', 'actuation' => 'Fisiatra'],
            ['id' => 34, 'name' => 'Medicina Intensiva', 'actuation' => 'Intensivista'],
            ['id' => 35, 'name' => 'Medicina Legal', 'actuation' => 'Médico Legista'],
            ['id' => 36, 'name' => 'Medicina Nuclear', 'actuation' => 'Médico Nuclear'],
            ['id' => 37, 'name' => 'Medicina Preventiva e Social', 'actuation' => 'Médico Preventivista'],
            ['id' => 38, 'name' => 'Nefrologia', 'actuation' => 'Nefrologista'],
            ['id' => 39, 'name' => 'Neurocirurgia', 'actuation' => 'Neurocirurgião'],
            ['id' => 40, 'name' => 'Neurologia', 'actuation' => 'Neurologista'],
            ['id' => 41, 'name' => 'Nutrologia', 'actuation' => 'Nutrólogo'],
            ['id' => 42, 'name' => 'Oftalmologia', 'actuation' => 'Oftalmologista'],
            ['id' => 43, 'name' => 'Ortopedia e Traumatologia', 'actuation' => 'Ortopedista'],
            ['id' => 44, 'name' => 'Otorrinolaringologia', 'actuation' => 'Otorrinolaringologista'],
            ['id' => 45, 'name' => 'Patologia', 'actuation' => 'Patologista'],
            ['id' => 46, 'name' => 'Patologia Clínica/Medicina Laboratorial', 'actuation' => 'Patologista Clínico'],
            ['id' => 47, 'name' => 'Pediatria', 'actuation' => 'Pediatra'],
            ['id' => 48, 'name' => 'Pneumologia', 'actuation' => 'Pneumologista'],
            ['id' => 49, 'name' => 'Psiquiatria', 'actuation' => 'Psiquiatra'],
            ['id' => 50, 'name' => 'Radiologia e Diagnóstico por Imagem', 'actuation' => 'Radiologista'],
            ['id' => 51, 'name' => 'Radioterapia', 'actuation' => 'Radioterapeuta'],
            ['id' => 52, 'name' => 'Reumatologia', 'actuation' => 'Reumatologista'],
            ['id' => 53, 'name' => 'Urologia', 'actuation' => 'Urologista'],
            ['id' => 54, 'name' => 'Acesso Vascular e Terapia Infusional', 'actuation' => 'Especialista em Terapia Infusional'],
            ['id' => 55, 'name' => 'Aeroespacial', 'actuation' => 'Médico Aeroespacial'],
            ['id' => 56, 'name' => 'Auditoria e Pesquisa', 'actuation' => 'Auditor Médico'],
            ['id' => 57, 'name' => 'Banco de Leite Humano', 'actuation' => 'Especialista em Banco de Leite Humano'],
            ['id' => 59, 'name' => 'Centro Cirúrgico', 'actuation' => 'Enfermeiro de Centro Cirúrgico'],
            ['id' => 60, 'name' => 'Central de Material e Esterilização', 'actuation' => 'Enfermeiro de CME'],
            ['id' => 61, 'name' => 'Diagnóstico por Imagens', 'actuation' => 'Especialista em Diagnóstico por Imagem'],
            ['id' => 62, 'name' => 'Doenças infecciosas e parasitárias', 'actuation' => 'Infectologista (Doenças Infecciosas e Parasitárias)'],
            ['id' => 63, 'name' => 'Educação em Enfermagem', 'actuation' => 'Enfermeiro Educador'],
            ['id' => 65, 'name' => 'Estomaterapia', 'actuation' => 'Estomaterapeuta'],
            ['id' => 66, 'name' => 'Farmacologia', 'actuation' => 'Farmacologista'],
            ['id' => 67, 'name' => 'Forense', 'actuation' => 'Médico Forense'],
            ['id' => 68, 'name' => 'Gerenciamento/Gestão', 'actuation' => 'Gestor em Saúde'],
            ['id' => 69, 'name' => 'Gerontologia', 'actuation' => 'Gerontólogo'],
            ['id' => 70, 'name' => 'Ginecologia', 'actuation' => 'Ginecologista'],
            ['id' => 71, 'name' => 'Hanseníase', 'actuation' => 'Especialista em Hanseníase'],
            ['id' => 73, 'name' => 'Infecção Hospitalar (CCIH)', 'actuation' => 'Especialista em Controle de Infecção Hospitalar'],
            ['id' => 74, 'name' => 'Informática em Saúde', 'actuation' => 'Especialista em Informática em Saúde'],
            ['id' => 75, 'name' => 'Legislação', 'actuation' => 'Especialista em Legislação em Saúde'],
            ['id' => 77, 'name' => 'Neonatologia', 'actuation' => 'Neonatologista'],
            ['id' => 79, 'name' => 'Obstetrícia', 'actuation' => 'Obstetra'],
            ['id' => 80, 'name' => 'Offshore e aquaviária', 'actuation' => 'Médico Offshore e Aquaviário'],
            ['id' => 82, 'name' => 'Oncologia', 'actuation' => 'Oncologista'],
            ['id' => 84, 'name' => 'Saúde Ambiental', 'actuation' => 'Especialista em Saúde Ambiental'],
            ['id' => 85, 'name' => 'Saúde da Família', 'actuation' => 'Especialista em Saúde da Família'],
            ['id' => 86, 'name' => 'Saúde do Adolescente', 'actuation' => 'Especialista em Saúde do Adolescente'],
            ['id' => 87, 'name' => 'Saúde do Adulto', 'actuation' => 'Especialista em Saúde do Adulto'],
            ['id' => 88, 'name' => 'Saúde do Homem', 'actuation' => 'Especialista em Saúde do Homem'],
            ['id' => 89, 'name' => 'Saúde do Trabalhador', 'actuation' => 'Médico do Trabalhador'],
            ['id' => 90, 'name' => 'Saúde Indígena', 'actuation' => 'Especialista em Saúde Indígena'],
            ['id' => 91, 'name' => 'Saúde Mental', 'actuation' => 'Especialista em Saúde Mental'],
            ['id' => 92, 'name' => 'Saúde Pública', 'actuation' => 'Especialista em Saúde Pública'],
            ['id' => 93, 'name' => 'Terapias Holísticas Complementares', 'actuation' => 'Terapeuta Holístico'],
            ['id' => 94, 'name' => 'Terapia Intensiva', 'actuation' => 'Intensivista'],
            ['id' => 95, 'name' => 'Transplantes', 'actuation' => 'Especialista em Transplantes'],
            ['id' => 96, 'name' => 'Traumato-Ortopedia', 'actuation' => 'Traumato-Ortopedista'],
            ['id' => 97, 'name' => 'Urgência e Emergência', 'actuation' => 'Médico de Urgência e Emergência'],
            ['id' => 98, 'name' => 'Vigilância Sanitária e Epidemiológica', 'actuation' => 'Especialista em Vigilância Sanitária e Epidemiológica'],
            ['id' => 99, 'name' => 'Não se aplica', 'actuation' => 'Não se aplica'],
            ['id' => 101, 'name' => 'Biomedicina', 'actuation' => 'Biomédico'],
        ];

        $now = now();

        foreach ($specialties as $specialty) {
            DB::table('specialties')->updateOrInsert(
                ['id' => $specialty['id']],
                [
                    'name' => $specialty['name'],
                    'actuation' => $specialty['actuation'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
