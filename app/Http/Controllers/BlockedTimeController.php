<?php

namespace App\Http\Controllers;

use App\Events\ScheduleUpdated;
use App\Http\Resources\UnavailableTimeResource;
use App\Models\BlockedTime;
use App\Models\Doctor;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlockedTimeController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $dbQuery = BlockedTime::with('event.doctor')->orderByDesc('id');

        return UnavailableTimeResource::collection($dbQuery->cursorPaginate(25)->withQueryString());
    }

    /**
     * @param BlockedTime $unavailableTime
     * @return UnavailableTimeResource
     */
    public function show(BlockedTime $unavailableTime): UnavailableTimeResource
    {
        return new UnavailableTimeResource($unavailableTime->load('event.doctor'));
    }

    /**
     * @param Request $request
     * @param Doctor $doctor
     * @return UnavailableTimeResource
     */
    public function store(Request $request, Doctor $doctor): UnavailableTimeResource
    {
        $input = $request->validate([
            'date' => ['required', 'string', 'date_format:Y-m-d'],
            'time' => ['required', 'string', 'date_format:H:i'],
            'duration' => ['required', 'string', 'date_format:H:i'],
            'reason' => ['required', 'string', 'max:255']
        ]);

        $blockedTime = new BlockedTime($input);
        $blockedTime->save();
        $event = new Event(array_merge($input, ['doctor_id' => $doctor->id]));

        $blockedTime->event()->save($event);

        ScheduleUpdated::dispatch($doctor);

        return new UnavailableTimeResource($blockedTime);
    }

    /**
     * @param BlockedTime $unavailableTime
     * @param Request $request
     * @return UnavailableTimeResource
     */
    public function update(BlockedTime $unavailableTime, Request $request): UnavailableTimeResource
    {
        $input = $request->validate([
            'date' => ['required', 'string', 'date_format:Y-m-d'],
            'time' => ['required', 'string', 'date_format:H:i'],
            'duration' => ['nullable', 'string', 'date_format:H:i'],
            'reason' => ['nullable', 'string', 'max:255']
        ]);

        $unavailableTime->update($input);
        $unavailableTime->event->update($input);

        ScheduleUpdated::dispatch($unavailableTime->event->doctor);

        return new UnavailableTimeResource($unavailableTime->fresh('event.doctor'));
    }

    /**
     * @param BlockedTime $unavailableTime
     * @return Response
     */
    public function destroy(BlockedTime $unavailableTime): Response
    {
        $unavailableTime->event->delete();
        $unavailableTime->delete();

        ScheduleUpdated::dispatch($unavailableTime->event->doctor);

        return response()->noContent();
    }
}
