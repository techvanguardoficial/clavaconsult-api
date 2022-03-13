<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportTabCollection;
use App\Models\Doctor;

class ReportConfigController extends Controller
{
    public function show(Doctor $doctor): ReportTabCollection
    {
        return new ReportTabCollection($doctor->reportTabs);
    }
}
