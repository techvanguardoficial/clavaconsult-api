<?php

namespace App\Jobs;

use App\Models\Doctor;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\ReportFieldData;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportReportsFromJson implements ShouldQueue, ShouldBeUnique
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $id;
    private array $reports;
    private Doctor $doctor;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return void
     * @throws ModelNotFoundException
     */
    private function getDoctor(): void
    {
        $this->doctor = Doctor::findOrFail($this->id);
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    private function getReports(): void
    {
        $this->reports = json_decode(Storage::get(sprintf('imports/input/%s.json', $this->id)), true);
    }

    /**
     * @return void
     * @throws ModelNotFoundException
     */
    private function import(): void
    {
        $failed = [];

        foreach ($this->reports as $report) {
            $patient = Patient::where('old_id', $report['idpaciente'])->first();

            if (is_null($patient)) {
                $failed[] = $report;
                continue;
            }

            if (!array_key_exists('campos', $report)) {
                continue;
            }

            $fields = [];

            foreach ($report['campos'] as $field) {
                $matched = $this->doctor->reportFields()->where('report_fields.name', $field['nome'])->first();

                // Nenhuma correspondência para o campo, pular o registro médico.
                if (is_null($matched)) {
                    $failed[] = $report;
                    continue 2;
                }

                $fields[] = new ReportFieldData([
                    'report_field_id' => $matched->id,
                    'value' => $field['valor']
                ]);
            }

            $report1 = new MedicalReport([
                'doctor_id' => $this->doctor->id,
                'patient_id' => $patient->id,
                'status' => 'committed',

                'old_id' => $report['id'],
                'date' => $report['data'],
                'duration' => $report['tempo']
            ]);

            $report1->save();
            $report1->fieldData()->saveMany($fields);
        }

        if ($failed) {
            Storage::put(sprintf('imports/output/%s.json', $this->id), json_encode($failed, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * @return void
     * @throws ModelNotFoundException|FileNotFoundException
     */
    public function handle()
    {
        $this->getDoctor();
        $this->getReports();
        $this->import();
    }

    /**
     * @return int
     */
    public function uniqueId(): int
    {
        return $this->doctor->id;
    }
}
