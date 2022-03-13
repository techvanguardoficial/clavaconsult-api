<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $dbQuery = Employee::query();

        if ($request->query('search')) {
            $dbQuery->whereHas('user', function (Builder $dbQuery) use ($request) {
                $dbQuery->where('name', 'like', sprintf('%s%%', $request->query('search')));
                $dbQuery->orWhere('email', 'like', sprintf('%s%%', $request->query('search')));
            });
        }

        return EmployeeResource::collection($dbQuery->cursorPaginate(25)->withQueryString());
    }

    public function show(Employee $employee): EmployeeResource
    {
        return new EmployeeResource($employee);
    }

    public function store(Request $request): EmployeeResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'string', 'max:255'],
            'admin' => ['required', 'boolean'],
            'access_all_schedules' => ['required', 'boolean']
        ]);

        $employee = Employee::create($input);
        $user = new User($input);

        $employee->user()->save($user);

        return new EmployeeResource($employee);
    }

    public function update(Employee $employee, Request $request): EmployeeResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users')->ignore($employee->user->id)],
            'admin' => ['required', 'boolean'],
            'access_all_schedules' => ['required', 'boolean']
        ]);

        $employee->update($input);
        $employee->user->update($input);

        return new EmployeeResource($employee);
    }

    public function destroy(Employee $employee): Response
    {
        $employee->user->delete();
        $employee->delete();

        return response()->noContent();
    }
}
