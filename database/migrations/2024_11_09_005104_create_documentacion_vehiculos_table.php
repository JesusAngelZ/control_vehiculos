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
        Schema::create('documentacion_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_auto')->constrained('autos');
            $table->string('tarjeta_circulacion')->nullable();
            $table->string('poliza_seguro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentacion_vehiculos');
    }
};
