<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('step')->default('idle');
            // bot | human
            $table->string('mode')->default('bot');
            // dados coletados durante o fluxo (specialty_id, doctor_id, patient_id, date, time…)
            $table->json('data')->nullable();
            // histórico de mensagens para o LLM (array de {role, content})
            $table->json('history')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_sessions');
    }
};
