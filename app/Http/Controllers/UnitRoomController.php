<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnitRoomResource;
use App\Models\UnitAddress;
use App\Models\UnitRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UnitRoomController extends Controller
{
    public function index(UnitAddress $unitAddress): AnonymousResourceCollection
    {
        return UnitRoomResource::collection(
            $unitAddress->rooms()->orderBy('name')->get()
        );
    }

    public function store(Request $request, UnitAddress $unitAddress): UnitRoomResource
    {
        $input = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $room = $unitAddress->rooms()->create($input);

        return new UnitRoomResource($room);
    }

    public function show(UnitAddress $unitAddress, UnitRoom $unitRoom): UnitRoomResource
    {
        return new UnitRoomResource($unitRoom);
    }

    public function update(Request $request, UnitAddress $unitAddress, UnitRoom $unitRoom): UnitRoomResource
    {
        $input = $request->validate([
            'name'        => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        $unitRoom->update($input);

        return new UnitRoomResource($unitRoom);
    }

    public function destroy(UnitAddress $unitAddress, UnitRoom $unitRoom): Response
    {
        $unitRoom->delete();

        return response()->noContent();
    }
}
