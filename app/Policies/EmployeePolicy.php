<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
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
     * @return false
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * @return false
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * @return false
     */
    public function create(): bool
    {
        return false;
    }

    /**
     * @return false
     */
    public function update(): bool
    {
        return false;
    }

    /**
     * @return false
     */
    public function delete(): bool
    {
        return false;
    }
}
