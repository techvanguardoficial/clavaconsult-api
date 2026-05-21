<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionColumnToCouncilsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('councils', function (Blueprint $table) {
            $table->string('description')->nullable()->after('council_name');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('councils', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
