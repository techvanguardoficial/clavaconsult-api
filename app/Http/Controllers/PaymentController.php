<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Doctor;
use App\Models\Event;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @param Doctor $doctor
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, Doctor $doctor): AnonymousResourceCollection
    {
        $dbQuery = Payment::query();

        $dbQuery->whereHas('appointment.event.doctor', function (Builder $dbQuery) use ($doctor) {
            $dbQuery->where('id', $doctor->id);
        });

        $dbQuery->whereHas('appointment.event', function (Builder $query) use ($request) {
            $query->where('date', $request->query('date'));
        });

        return PaymentResource::collection($dbQuery->cursorPaginate(25));
    }
}
