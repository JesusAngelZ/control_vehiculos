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
        Schema::create('solicitud_utjs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_salida')->nullable();
            $table->dateTime('fecha_regreso')->nullable();
            $table->string('motivo');
            $table->string('oficio_comision')->nullable();
            $table->string('estado_vehiculo');
            $table->longText('estado_vehiculo_foto')->nullable();
            $table->foreignId('id_usuario')->constrained('users');
            $table->foreignId('id_auto')->constrained('autos');

            // Las marcas de tiempo de creación y actualización automáticas
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_utjs');
    }
};
