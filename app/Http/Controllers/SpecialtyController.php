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

        $specialties->orderBy('name');

        return SpecialtyResource::collection($specialties->get());
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
            'name' => ['required', 'string', 'min:3', 'max:255']
        ]);

        $specialty = Specialty::create($input);

        return new SpecialtyResource($specialty);
    }

    public function update(Specialty $specialty, Request $request): SpecialtyResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255']
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
