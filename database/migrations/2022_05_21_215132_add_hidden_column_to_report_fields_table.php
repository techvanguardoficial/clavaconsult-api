<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHiddenColumnToReportFieldsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('report_fields', function (Blueprint $table) {
            $table->boolean('hidden')->after('report_tab_id')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('report_fields', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
    }
}
