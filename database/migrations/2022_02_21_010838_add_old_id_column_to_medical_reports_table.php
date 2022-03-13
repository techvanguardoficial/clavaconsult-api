<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldIdColumnToMedicalReportsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('medical_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('old_id')->nullable()->after('id');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('medical_reports', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });
    }
}
