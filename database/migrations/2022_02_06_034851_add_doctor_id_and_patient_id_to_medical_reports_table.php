<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoctorIdAndPatientIdToMedicalReportsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('medical_reports', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable();
            $table->foreignId('patient_id')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('medical_reports', function (Blueprint $table) {
            $table->dropColumn('doctor_id');
            $table->dropColumn('patient_id');
        });
    }
}
