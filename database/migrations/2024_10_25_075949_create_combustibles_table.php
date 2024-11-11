<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('combustibles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_auto')->constrained('autos');
            $table->foreignId('id_solicitud')->constrained('solicitud_utjs');
            $table->integer('combustible_inicial')->nullable();
            $table->integer('combustible_salida')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combustibles');
    }
};
