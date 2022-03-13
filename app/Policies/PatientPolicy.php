<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
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
        if ($user->admin) {
            return true;
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return false;
    }
}
