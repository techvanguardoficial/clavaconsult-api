<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviouslyScheduledColumnToAppointmentsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->boolean('previously_scheduled')
                ->nullable()
                ->default(1);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('previously_scheduled');
        });
    }
}
