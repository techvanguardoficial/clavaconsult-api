<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitBusinessHoursTable extends Migration
{
    public function up()
    {
        Schema::create('unit_business_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_address_id')->constrained('unit_addresses')->onDelete('cascade');
            $table->tinyInteger('day_of_week')->unsigned()->comment('0=Domingo, 1=Segunda, 2=Terça, 3=Quarta, 4=Quinta, 5=Sexta, 6=Sábado');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();

            $table->unique(['unit_address_id', 'day_of_week']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('unit_business_hours');
    }
}
