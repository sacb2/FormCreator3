<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEvaluationForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inclusive_form', function (Blueprint $table) {
    
            $table->integer('evaluacion')->nullable();
            $table->integer('id_restriccion')->nullable();
            $table->integer('id_rubrica')->nullable();

        });
        Schema::table('inclusive_answers', function (Blueprint $table) {
    
            $table->integer('evaluacion')->nullable();
            

        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inclusive_form', function (Blueprint $table) {
            $table->dropColumn('evaluacion');
            $table->dropColumn('id_restriccion');
        });
        Schema::table('inclusive_answers', function (Blueprint $table) {
            $table->dropColumn('evaluacion');
          
        });
    }
}
