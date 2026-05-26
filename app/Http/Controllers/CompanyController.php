<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Company::orderBy('company_name')->get());
    }

    public function show(Company $company): JsonResponse
    {
        return response()->json($company);
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'cnpj'         => ['required', 'string', 'max:18', 'unique:companies'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'whatsapp'     => ['nullable', 'string', 'max:20'],
            'email'        => ['nullable', 'email', 'max:255'],
        ]);

        $company = Company::create($input);

        return response()->json($company, 201);
    }

    public function update(Request $request, Company $company): JsonResponse
    {
        $input = $request->validate([
            'company_name' => ['sometimes', 'string', 'max:255'],
            'cnpj'         => ['sometimes', 'string', 'max:18', Rule::unique('companies')->ignore($company->id)],
            'phone'        => ['sometimes', 'nullable', 'string', 'max:20'],
            'whatsapp'     => ['sometimes', 'nullable', 'string', 'max:20'],
            'email'        => ['sometimes', 'nullable', 'email', 'max:255'],
        ]);

        $company->update($input);

        return response()->json($company);
    }

    public function destroy(Company $company): Response
    {
        $company->delete();

        return response()->noContent();
    }
}
