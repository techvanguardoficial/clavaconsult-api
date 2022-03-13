<?php

namespace App\Jobs;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psr\Log\LoggerInterface;

class SaveReports implements ShouldQueue, ShouldBeUnique
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Doctor $doctor;
    private LoggerInterface $logger;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    private function prepare(): void
    {
        $this->logger = Log::build([
            'driver' => 'single',
            'path' => storage_path(sprintf('logs/save_reports/%s/%s.log', $this->batch()->id, $this->doctor->id))
        ]);
    }

    private function getPatientReports(Patient $patient): array
    {
        $request = Http::onmed()->retry(3, 5000)->withOptions([
            'query' => [
                'classe' => 'dinamico',
                'funcao' => 'dados_consulta_resumo',
                'conta' => config('import.api_account'),
                'idclinica' => config('import.api_clinic_id'),
                'idmedico' => $this->doctor->old_id,
                'idpaciente' => $patient->old_id,
                'idusuario' => config('import.api_user_id'),
                'idsessao' => config('import.api_session_id'),
                'timezone' => config('import.api_timezone')
            ]
        ]);

        $response = $request->post('/', [
            'inicio' => true
        ]);

        $response1 = $request->post('/', [
            'inicio' => false
        ]);

        if ($response->failed() || $response1->failed()) {
            $this->logger->error('Ocorreu uma falha ao tentar obter dados do OnMed.');
            $this->fail();
        }

        $data = $response->json();
        $data1 = $response1->json();

        $reports = array_merge(
            array_key_exists('consultas', $data) ? $data['consultas'] : [],
            array_key_exists('consultas', $data1) ? $data1['consultas'] : []
        );

        return array_map(fn(array $report) => $this->getPatientReport($patient, $report['id']), $reports);
    }

    private function getPatientReport(Patient $patient, int $id): array
    {
        $request = Http::onmed()->retry(3, 5000)->withOptions([
            'query' => [
                'classe' => 'dinamico',
                'funcao' => 'dadosConsulta',
                'conta' => config('import.api_account'),
                'idclinica' => config('import.api_clinic_id'),
                'idmedico' => $this->doctor->old_id,
                'idpaciente' => $patient->old_id,
                'idusuario' => config('import.api_user_id'),
                'idsessao' => config('import.api_session_id'),
                'timezone' => config('import.api_timezone')
            ]
        ]);

        $response = $request->post('/', ['id' => $id]);

        if ($response->failed()) {
            $this->logger->debug('Ocorreu uma falha ao tentar obter dados do OnMed.');
            $this->fail();
        }

        $data = $response->json();
        $reports = array_key_exists('consultas', $data) ? $data['consultas'] : [];

        if (count($reports) != 1) {
            $this->logger->error(sprintf('Um número incompatível de consultas foi retornado ao tentar obter a consulta com o ID #%s.', $id), $data);
            $this->fail();
        }

        return $reports[0];
    }

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $this->prepare();
        $this->save();
    }

    private function save(): void
    {
        $reports = [];
        $patients = Patient::all();

        $this->logger->info(__('save_reports.started'));

        foreach ($patients as $i => $patient) {
            $patientReports = $this->getPatientReports($patient);

            if (!empty($patientReports)) {
                $reports = array_merge($reports, $patientReports);

                $this->logger->info(__('save_reports.patient_reports_merged', [
                    'index' => $i + 1,
                    'total' => $patients->count()
                ]));
            } else {
                $this->logger->info(__('save_reports.no_patient_reports', [
                    'index' => $i + 1,
                    'total' => $patients->count()
                ]));
            }
        }

        Storage::put(sprintf('reports/%s.json', $this->doctor->id), json_encode($reports, JSON_UNESCAPED_UNICODE));

        $this->logger->info(__('save_reports.saved', [
            'name' => $this->doctor->user->name
        ]));

        $this->logger->info(__('save_reports.completed'));
    }

    public function uniqueId(): int
    {
        return $this->doctor->id;
    }
}
