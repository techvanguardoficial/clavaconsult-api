<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitRoomIdToWorkTimesTable extends Migration
{
    public function up()
    {
        Schema::table('work_times', function (Blueprint $table) {
            $table->foreignId('unit_room_id')->nullable()->after('doctor_id')->constrained('unit_rooms')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('work_times', function (Blueprint $table) {
            $table->dropForeign(['unit_room_id']);
            $table->dropColumn('unit_room_id');
        });
    }
}
