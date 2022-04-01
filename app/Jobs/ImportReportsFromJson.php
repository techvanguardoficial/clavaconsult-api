<?php

namespace App\Jobs;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class ImportReportsFromJson implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Collection $patients;
    private LoggerInterface $logger;

    /**
     * @return void
     */
    public function handle()
    {
        //
    }

    public function prepare()
    {
        $this->logger = Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/jobs/import_reports_from_json.log')
        ]);

        $this->patients = Patient::all();
    }
}
