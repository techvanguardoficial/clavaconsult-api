<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MedicalReportPolicy
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
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->type == 'doctor';
    }

    /**
     * @param User $user
     * @param Appointment $appointment
     * @return bool
     */
    public function view(User $user, Appointment $appointment): bool
    {
        return $user->profile_id == $appointment->event->doctor_id;
    }

    /**
     * @param User $user
     * @param Appointment $appointment
     * @return bool
     */
    public function create(User $user, Appointment $appointment): bool
    {
        return $user->profile_id == $appointment->event->doctor_id && (!$appointment->medicalReport()->exists() || $appointment->medicalReport->status == 'draft');
    }

    /**
     * @param User $user
     * @param Appointment $appointment
     * @return bool
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        return ($user->profile_id == $appointment->event->doctor_id && (!$appointment->medicalReport()->exists() || $appointment->medicalReport->status == 'draft'));
    }
}
