<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('unit_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_address_id')->constrained('unit_addresses')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unit_rooms');
    }
}
