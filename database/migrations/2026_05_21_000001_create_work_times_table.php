<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTimesTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('work_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day_of_week')->unsigned()->comment('0=Domingo, 1=Segunda, 2=Terça, 3=Quarta, 4=Quinta, 5=Sexta, 6=Sábado');
            $table->enum('period', ['Manhã', 'Tarde']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('observations')->nullable();
            $table->timestamps();

            $table->unique(['doctor_id', 'day_of_week', 'period']);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_times');
    }
}
