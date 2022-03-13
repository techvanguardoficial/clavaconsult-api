<?php

namespace App\Http\Controllers;

use App\Events\ScheduleUpdated;
use App\Http\Resources\UnavailableTimeResource;
use App\Models\BlockedTime;
use App\Models\Doctor;
use App\Models\Event;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockedTimeController extends Controller
{
    /**
     * @return CursorPaginator
     */
    public function index(): CursorPaginator
    {
        $dbQuery = BlockedTime::query();

        return $dbQuery->cursorPaginate(25)->withQueryString();
    }

    /**
     * @param BlockedTime $unavailableTime
     * @return BlockedTime
     */
    public function show(BlockedTime $unavailableTime): BlockedTime
    {
        return $unavailableTime;
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
     * @return BlockedTime
     */
    public function update(BlockedTime $unavailableTime, Request $request): BlockedTime
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

        return $unavailableTime;
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
