<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        return response()->json(['data' => $this->formatProfile($request->user())]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
        ]);

        $user->fill(collect($data)->only(['name', 'email'])->toArray());
        $user->save();

        if (array_key_exists('phone', $data) && $user->profile && in_array('phone', $user->profile->getFillable())) {
            $user->profile->update(['phone' => $data['phone']]);
        }

        return response()->json(['data' => $this->formatProfile($user->fresh())]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['A senha atual informada está incorreta.'],
            ]);
        }

        $user->password = $data['password'];
        $user->save();

        return response()->noContent();
    }

    /**
     * @param User $user
     * @return array
     */
    private function formatProfile(User $user): array
    {
        $profile = $user->profile;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->type,
            'phone' => $profile->phone ?? null,
            'cpf' => $profile->cpf ?? null,
        ];
    }
}
