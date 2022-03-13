<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTabsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('report_tabs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('old_id')->nullable();
            $table->string('name');
            $table->foreignId('doctor_id');
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_tabs');
    }
}
