<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalReportsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->time('duration');
            $table->string('evaluation', 1000)->nullable();
            $table->string('impression', 1000)->nullable();
            $table->string('conduct', 1000)->nullable();
            $table->string('diagnostic', 1000)->nullable();
            $table->string('diagnostic_hypothesis', 1000)->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_reports');
    }
}
