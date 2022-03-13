<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $dbQuery = Plan::query();

        if ($request->query('search')) {
            $dbQuery->where('name', 'like', sprintf('%s%%', $request->query('search')));
        }

        return PlanResource::collection($dbQuery->cursorPaginate(25)->withQueryString());
    }

    /**
     * @param Plan $plan
     * @return PlanResource
     */
    public function show(Plan $plan): PlanResource
    {
        return new PlanResource($plan);
    }

    /**
     * @param Request $request
     * @return PlanResource
     */
    public function store(Request $request): PlanResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255']
        ]);

        $plan = Plan::create($input);

        return new PlanResource($plan);
    }

    /**
     * @param Plan $plan
     * @param Request $request
     * @return PlanResource
     */
    public function update(Plan $plan, Request $request): PlanResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255']
        ]);

        $plan->update($input);

        return new PlanResource($plan);
    }

    /**
     * @param Plan $plan
     * @return Response
     */
    public function destroy(Plan $plan): Response
    {
        $plan->delete();

        return response()->noContent();
    }
}
