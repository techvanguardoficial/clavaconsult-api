<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitAddressesIdColumnToDoctorsTable extends Migration
{
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('unit_addresses_id')->nullable()->after('old_id')->constrained('unit_addresses')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['unit_addresses_id']);
            $table->dropColumn('unit_addresses_id');
        });
    }
}
