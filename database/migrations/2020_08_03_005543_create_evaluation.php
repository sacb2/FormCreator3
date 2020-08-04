<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inclusive_evaluation', function (Blueprint $table) {
            $table->id();
            $table->integer('evaluacion')->nullable();
            $table->integer('id_evaluador')->nullable();
            $table->integer('id_formulario')->nullable();
            $table->integer('id_respuesta')->nullable();
            $table->integer('id_pregunta')->nullable();
            $table->integer('value_respuesta')->nullable();
            $table->integer('id_requerimiento')->nullable();
            $table->integer('id_rubric')->nullable();
            $table->string('observacion')->nullable();
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
        Schema::dropIfExists('inclusive_evaluation');
    }
}
