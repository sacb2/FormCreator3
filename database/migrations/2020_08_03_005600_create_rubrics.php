<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubrics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inclusive_rubrics', function (Blueprint $table) {
            $table->id();
            $table->integer('id_formulario')->nullable();
            $table->integer('id_pregunta')->nullable();
            $table->integer('id_respuesta')->nullable();
            $table->integer('id_tipo')->nullable();//rango, top, limit, exact
            $table->integer('id_evaluacion')->nullable();
            $table->integer('ponderacion')->nullable();
            $table->integer('rango_minimo')->nullable();
            $table->integer('rango_final')->nullable();
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
        Schema::dropIfExists('inclusive_rubrics');
    }
}
