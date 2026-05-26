<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueRoomScheduleToWorkTimesTable extends Migration
{
    public function up()
    {
        Schema::table('work_times', function (Blueprint $table) {
            $table->unique(['unit_room_id', 'day_of_week', 'period'], 'work_times_room_day_period_unique');
        });
    }

    public function down()
    {
        Schema::table('work_times', function (Blueprint $table) {
            $table->dropUnique('work_times_room_day_period_unique');
        });
    }
}
