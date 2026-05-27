<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnitBusinessHourResource;
use App\Models\UnitAddress;
use App\Models\UnitBusinessHour;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UnitBusinessHoursController extends Controller
{
    public function index(UnitAddress $unitAddress): AnonymousResourceCollection
    {
        return UnitBusinessHourResource::collection(
            $unitAddress->businessHours()->orderBy('day_of_week')->get()
        );
    }

    public function store(Request $request, UnitAddress $unitAddress): UnitBusinessHourResource
    {
        $input = $request->validate([
            'day_of_week' => ['required', 'integer', 'min:0', 'max:6'],
            'start_time'  => ['nullable', 'date_format:H:i:s'],
            'end_time'    => ['nullable', 'date_format:H:i:s', 'after:start_time'],
            'is_closed'   => ['boolean'],
        ]);

        $businessHour = $unitAddress->businessHours()->create($input);

        return new UnitBusinessHourResource($businessHour);
    }

    public function update(Request $request, UnitAddress $unitAddress, UnitBusinessHour $businessHour): UnitBusinessHourResource
    {
        $input = $request->validate([
            'start_time' => ['sometimes', 'nullable', 'date_format:H:i:s'],
            'end_time'   => ['sometimes', 'nullable', 'date_format:H:i:s', 'after:start_time'],
            'is_closed'  => ['sometimes', 'boolean'],
        ]);

        $businessHour->update($input);

        return new UnitBusinessHourResource($businessHour);
    }

    public function destroy(UnitAddress $unitAddress, UnitBusinessHour $businessHour): Response
    {
        $businessHour->delete();

        return response()->noContent();
    }
}
