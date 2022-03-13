<?php

namespace App\Http\Controllers;

use App\Jobs\ImportReports;
use App\Models\Doctor;
use App\Models\User;
use App\Notifications\ImportReportsCompleted;
use App\Notifications\ImportReportsFailed;
use Illuminate\Bus\Batch;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ImportReportController extends Controller
{
    /**
     * @throws Throwable
     */
    public function import(): Response
    {
        $doctors = Doctor::whereIn('id', explode(',', config('import.doctors')))->get();

        Bus::batch($doctors->map(fn($doctor) => new ImportReports($doctor)))
            ->then(function (Batch $batch) {
                $users = User::whereIn('id', [2, 10])->get();

                Notification::send($users, new ImportReportsCompleted($batch));
            })
            ->catch(function (Batch $batch) {
                $users = User::whereIn('id', [2, 10])->get();

                Notification::send($users, new ImportReportsFailed($batch));
            })
            ->dispatch();

        return response()->noContent();
    }
}
