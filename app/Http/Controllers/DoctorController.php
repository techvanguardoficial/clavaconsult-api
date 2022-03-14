<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\ReportTab;
use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $dbQuery = Doctor::query();

        if ($request->query('search')) {
            $dbQuery->whereHas('user', function (Builder $dbQuery) use ($request) {
                $dbQuery->where('name', 'like', sprintf('%s%%', $request->query('search')));
                $dbQuery->orWhere('email', 'like', sprintf('%s%%', $request->query('search')));
            });
        }

        return DoctorResource::collection($dbQuery->cursorPaginate(25)->withQueryString());
    }

    /**
     * @param Doctor $doctor
     * @return DoctorResource
     */
    public function show(Doctor $doctor): DoctorResource
    {
        return new DoctorResource($doctor);
    }

    /**
     * @param Request $request
     * @return DoctorResource
     * @throws FileNotFoundException
     */
    public function store(Request $request): DoctorResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'string', 'max:255'],
            'admin' => ['required', 'boolean'],
            'cpf' => ['required', 'string', 'max:255', 'unique:doctors'],
            'council_number' => ['required', 'string', 'max:255', 'unique:doctors'],
            'specialty_id' => ['required', 'exists:specialties,id']
        ]);

        $doctor = Doctor::create($input);
        $user = new User($input);

        $doctor->user()->save($user);

        $config = json_decode(Storage::get('doctor_report_config.json'), true);

        foreach ($config['tabs'] as $tabConfig) {
            $tab = new ReportTab($tabConfig);

            $tab->doctor()->associate($doctor);
            $tab->save();

            $tab->reportFields()->createMany($tabConfig['fields']);
        }

        return new DoctorResource($doctor);
    }

    /**
     * @param Doctor $doctor
     * @param Request $request
     * @return DoctorResource
     */
    public function update(Doctor $doctor, Request $request): DoctorResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users')->ignore($doctor->user->id)],
            'admin' => ['required', 'boolean'],
            'cpf' => ['required', 'string', 'max:255', 'unique:doctors'],
            'council_number' => ['required', 'string', 'max:255', 'unique:doctors'],
            'specialty_id' => ['required', 'exists:specialties,id']
        ]);

        $doctor->update($input);
        $doctor->user->update($input);

        return new DoctorResource($doctor);
    }

    /**
     * @param Doctor $doctor
     * @return Response
     */
    public function destroy(Doctor $doctor): Response
    {
        $doctor->user->delete();
        $doctor->delete();

        return response()->noContent();
    }
}
