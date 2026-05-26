<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservationsToWorkTimesTable extends Migration
{
    public function up()
    {
        Schema::table('work_times', function (Blueprint $table) {
            $table->text('observations')->nullable()->after('end_time');
        });
    }

    public function down()
    {
        Schema::table('work_times', function (Blueprint $table) {
            $table->dropColumn('observations');
        });
    }
}
