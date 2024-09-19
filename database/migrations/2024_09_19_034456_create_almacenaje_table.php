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
        Schema::create('almacenaje', function (Blueprint $table) {
            $table->increments("idalm");
            $table->String("nombre");
            $table->String("descripcion");
            $table->int("cantidad");
            $table->date("feCad")->nullable();
            $table->int("disponibilidad");
            $table->String("categoria"); //Verificar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacenaje');
    }
};
