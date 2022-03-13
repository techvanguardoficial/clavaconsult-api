<?php

namespace App\Jobs;

use App\Models\Doctor;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\ReportFieldData;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psr\Log\LoggerInterface;

class ImportReports implements ShouldQueue, ShouldBeUnique
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Doctor $doctor;
    private Collection $fields;
    private Collection $patients;
    private LoggerInterface $logger;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    private function getPatientReports(Patient $patient): array
    {
        $request = Http::onmed()->retry(3, 5000)->withOptions([
            'query' => [
                'classe' => 'dinamico',
                'funcao' => 'dados_consulta_resumo',
                'conta' => config('import.api_account'),
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

        return array_map(fn($report) => $this->getPatientReport($patient, $report['id']), $reports);
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
        $this->import();
    }

    private function import(): void
    {
        $this->logger->info(__('import_reports.started'));

        $failedReports = [];

        foreach ($this->patients as $i => $patient) {
            if (is_null($patient->old_id)) {
                continue;
            }

            $reports = $this->getPatientReports($patient);

            foreach ($reports as $report) {
                if (!array_key_exists('campos', $report)) {
                    $failedReports[] = array_merge($report, ['idpaciente' => $patient->old_id]);

                    continue;
                }

                $fieldsData = [];

                foreach ($report['campos'] as $fieldData) {
                    $field = $this->fields->where('old_id', '=', $fieldData['idtipo'])->first();

                    if (is_null($field)) {
                        $failedReports[] = array_merge($report, ['idpaciente' => $patient->old_id]);

                        continue 2;
                    }

                    $fieldsData[] = new ReportFieldData([
                        'report_field_id' => $field->id,
                        'value' => $fieldData['valor']
                    ]);
                }

                $report = new MedicalReport([
                    'doctor_id' => $this->doctor->id,
                    'patient_id' => $patient->id,
                    'status' => 'committed',

                    'old_id' => $report['id'],
                    'date' => $report['data'],
                    'duration' => $report['tempo']
                ]);

                $report->save();
                $report->fieldData()->saveMany($fieldsData);
            }

            $this->logger->info(__('import_reports.patient_processed', [
                'index' => $i + 1,
                'total' => $this->patients->count()
            ]));
        }

        if (!empty($failedReports)) {
            Storage::put(sprintf('reports/%s.json', $this->doctor->id), json_encode($failedReports, JSON_UNESCAPED_UNICODE));
        }

        $this->logger->info(__('import_reports.completed'));
    }

    private function prepare(): void
    {
        $this->logger = Log::build([
            'driver' => 'single',
            'path' => storage_path(sprintf('logs/import_reports/%s/%s.log', $this->batch()->id, $this->doctor->id))
        ]);

        // $this->patients = Patient::all();
        $this->patients = Patient::query()->whereIn('id', explode(',', config('import.patients')))->get();
        $this->fields = $this->doctor->reportFields;
    }

    public function uniqueId(): int
    {
        return $this->doctor->id;
    }
}
