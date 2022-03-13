<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    /**
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @return bool|null
     */
    public function before(User $user): ?bool
    {
        return $user->admin ?: null;
    }

    /**
     * @param User $user
     * @param Doctor $doctor
     * @return bool
     */
    public function viewAny(User $user, Doctor $doctor): bool
    {
        if ($user->type == 'doctor') {
            return $user->profile_id == $doctor->id;
        } else {
            return $user->profile->access_all_schedules;
        }
    }
}
