<?php

namespace App\Http\Controllers;

use App\Http\Resources\PatientResource;
use App\Models\Address;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $dbQuery = Patient::query();

        if ($request->query('search')) {
            $dbQuery->where('name', 'like', sprintf('%s%%', $request->query('search')));
            $dbQuery->orWhere('document', 'like', sprintf('%s%%', $request->query('search')));
            $dbQuery->orWhere('phone', 'like', sprintf('%s%%', $request->query('search')));
            $dbQuery->orWhere('email', 'like', sprintf('%s%%', $request->query('search')));
        }

        return PatientResource::collection($dbQuery->cursorPaginate(25)->withQueryString());
    }

    /**
     * @param Patient $patient
     * @return PatientResource
     */
    public function show(Patient $patient): PatientResource
    {
        return new PatientResource($patient);
    }

    /**
     * @param Request $request
     * @return PatientResource
     */
    public function store(Request $request): PatientResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'birthday' => ['nullable', 'string', 'date_format:Y-m-d'],
            'gender' => ['nullable', 'string', 'in:female,male'],
            'document' => ['required', 'string', 'max:255', 'unique:patients'],
            'address.street' => ['nullable', 'string', 'max:255'],
            'address.number' => ['nullable', 'string', 'max:255'],
            'address.complementary' => ['nullable', 'string', 'max:255'],
            'address.neighborhood' => ['nullable', 'string', 'max:255'],
            'address.city' => ['nullable', 'string', 'max:255'],
            'address.state' => ['nullable', 'string', 'max:255'],
            'address.zip_code' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255', 'email'],
        ]);

        $patient = Patient::create($input);
        $address = new Address($input['address']);

        $patient->address()->save($address);

        return new PatientResource($patient);
    }

    /**
     * @param Patient $patient
     * @param Request $request
     * @return PatientResource
     */
    public function update(Patient $patient, Request $request): PatientResource
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'birthday' => ['nullable', 'string', 'date_format:Y-m-d'],
            'gender' => ['nullable', 'string', 'in:female,male'],
            'document' => ['required', 'string', 'max:255', Rule::unique('patients')->ignore($patient->id)],
            'address.street' => ['nullable', 'string', 'max:255'],
            'address.number' => ['nullable', 'string', 'max:255'],
            'address.complementary' => ['nullable', 'string', 'max:255'],
            'address.neighborhood' => ['nullable', 'string', 'max:255'],
            'address.city' => ['nullable', 'string', 'max:255'],
            'address.state' => ['nullable', 'string', 'max:255'],
            'address.zip_code' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255', 'email'],
        ]);

        $patient->update($input);

        if ($patient->address()->exists()) {
            $patient->address->update($input['address']);
        } else {
            $address = new Address($input['address']);
            $patient->address()->save($address);
        }

        return new PatientResource($patient);
    }

    /**
     * @param Patient $patient
     * @return Response
     */
    public function destroy(Patient $patient): Response
    {
        $patient->delete();

        return response()->noContent();
    }
}
