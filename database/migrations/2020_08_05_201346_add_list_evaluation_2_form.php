<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListEvaluation2Form extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   

        Schema::create('inclusive_form_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('id_formulario')->nullable();
            $table->integer('id_lista')->nullable();
            $table->integer('id_tipo')->nullable();//allowed, restrict
            $table->integer('id_status')->nullable();
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
   
        Schema::dropIfExists('inclusive_form_lists');
    }
}
