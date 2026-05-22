<?php

use App\Models\Doctor;
use Illuminate\Database\Migrations\Migration;

class SoftDeleteInactiveDoctors extends Migration
{
    /**
     * IDs dos médicos que não atendem mais — substitui o whereNotIn hardcoded
     * que existia em DoctorController::index.
     */
    private array $inactiveDoctorIds = [4, 32, 89, 90, 91, 6, 7, 10, 12, 13, 15, 16, 17, 18, 19, 20, 21, 23, 24, 25, 27, 28, 29, 30, 31, 33, 34, 38, 39, 40, 41, 43, 42, 44, 45, 46, 48, 49, 50, 51, 52, 54, 56, 57, 58, 59, 62, 63, 65, 67, 69, 71, 72, 73, 74, 77, 80];

    /**
     * @return void
     */
    public function up()
    {
        Doctor::whereIn('id', $this->inactiveDoctorIds)->delete();
    }

    /**
     * @return void
     */
    public function down()
    {
        Doctor::withTrashed()
            ->whereIn('id', $this->inactiveDoctorIds)
            ->restore();
    }
}
