<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsMaker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inclusive_form', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('nombre',500)->nullable();
			$table->string('descripcion',500)->nullable();
			$table->date('inicio_vigencia')->nullable();
			$table->date('fin_vigencia')->nullable();
			$table->integer('estado')->nullable();
			$table->integer('tipo')->nullable();
			$table->timestamps();
        });
		
		
			Schema::create('inclusive_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('nombre',1000)->nullable();
			$table->string('pregunta',3000)->nullable();
			$table->integer('estado')->nullable();
			$table->integer('tipo')->nullable();
            $table->timestamps();
        });
		
		
			Schema::create('inclusive_form_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('id_formulario')->nullable();
			$table->integer('id_pregunta')->nullable();
			$table->integer('estado')->nullable();
            $table->timestamps();
        });
		
		
			Schema::create('inclusive_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('id_pregunta')->nullable();
			$table->integer('id_formulario')->nullable();
			$table->integer('id_requerimiento')->nullable();
			$table->integer('id_persona')->nullable();
			$table->string('texto_respuesta',7000)->nullable();
            $table->integer('valor_respuesta')->nullable();
            $table->integer('tipo')->nullable();
            $table->string('rut_persona',11)->nullable();
			$table->timestamps();
        });
        Schema::create('inclusive_multiple_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('id_pregunta')->nullable();
			$table->integer('id_respuesta')->nullable();
			$table->string('texto_respuesta',3000)->nullable();
			$table->integer('estado')->nullable();
			$table->integer('tipo')->nullable();
           		 $table->timestamps();
        });
        Schema::create('inclusive_questions_multiple_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('id_pregunta')->nullable();
			$table->integer('id_respuesta')->nullable();
            $table->integer('valor_respuesta')->nullable();
            $table->string('texto_respuesta',3000)->nullable();
            $table->integer('estado')->nullable();
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
        Schema::dropIfExists('inclusive_form');
		Schema::dropIfExists('inclusive_questions');
		Schema::dropIfExists('inclusive_form_questions');
        Schema::dropIfExists('inclusive_answers');
        Schema::dropIfExists('inclusive_multiple_answers');
        Schema::dropIfExists('inclusive_questions_multiple_answers');

    }
}
