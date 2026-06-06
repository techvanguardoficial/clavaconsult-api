<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedule_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->unique()->constrained('doctors')->cascadeOnDelete();
            $table->string('slot_duration', 8)->default('00:20:00');
            $table->string('slot_label_interval', 8)->default('00:20:00');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedule_configs');
    }
};
