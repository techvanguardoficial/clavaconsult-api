<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SpecialtyController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $specialties = Specialty::query();

        if ($request->query('search')) {
            $specialties->where('name', 'like', sprintf('%s%%', $request->query('search')));
        }

        if ($request->boolean('with_doctors')) {
            $specialties->whereHas('doctors');
        }

        if ($unitAddressId = $request->query('unit_addresses_id')) {
            $specialties->whereHas('doctors', fn($q) => $q->where('unit_addresses_id', $unitAddressId));
        }

        $specialties->orderBy('name')->orderBy('id');

        return SpecialtyResource::collection($specialties->cursorPaginate(25)->withQueryString());
    }

    /**
     * @param Specialty $specialty
     * @return SpecialtyResource
     */
    public function show(Specialty $specialty): SpecialtyResource
    {
        return new SpecialtyResource($specialty);
    }

    /**
     * @param Request $request
     * @return SpecialtyResource
     */
    public function store(Request $request): SpecialtyResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'actuation' => ['nullable', 'string', 'max:255']
        ]);

        $specialty = Specialty::create($input);

        return new SpecialtyResource($specialty);
    }

    public function update(Specialty $specialty, Request $request): SpecialtyResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'actuation' => ['nullable', 'string', 'max:255']
        ]);

        $specialty->update($input);

        return new SpecialtyResource($specialty);
    }

    /**
     * @param Specialty $specialty
     * @return Response
     */
    public function destroy(Specialty $specialty): Response
    {
        $specialty->delete();

        return response()->noContent();
    }
}
