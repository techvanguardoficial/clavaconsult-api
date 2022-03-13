<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportFieldDataTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('report_field_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_field_id');
            $table->foreignId('report_id');
            $table->longText('value');
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_field_data');
    }
}
