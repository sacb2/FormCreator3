<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupFormQiestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inclusive_form_questions', function (Blueprint $table) {
    
            $table->integer('group')->nullable();

        });
        Schema::table('inclusive_form', function (Blueprint $table) {
    
            $table->integer('grouped')->nullable();

        });

        Schema::table('inclusive_questions', function (Blueprint $table) {
    
            $table->integer('group')->nullable();

        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inclusive_form_questions', function (Blueprint $table) {
            $table->dropColumn('group');
             
            });
            Schema::table('inclusive_questions', function (Blueprint $table) {
                $table->dropColumn('group');
                 
                });
            Schema::table('inclusive_form', function (Blueprint $table) {
                $table->dropColumn('grouped');
                 
                });
    }
}
