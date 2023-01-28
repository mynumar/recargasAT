<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medio_id')->constrained();
            $table->foreignId('cliente_id')->constrained();
            // $table->dateTime('fecha');
            // $table->foreignId('promotore_id')->constrained();
            $table->unsignedBigInteger('atentido_por');
            $table->foreign('atentido_por')->references('id')->on('users');
            $table->boolean('editado')->default('0');
            $table->unsignedBigInteger('editado_por')->nullable();
            $table->foreign('editado_por')->references('id')->on('users');
            $table->foreignId('motivo_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atenciones');
    }
};
