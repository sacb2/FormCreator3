<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestrictions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inclusive_restrictions', function (Blueprint $table) {
            $table->id();
            $table->integer('id_type')->nullable();
            $table->integer('id_status')->nullable();
            $table->string('nombre')->nullable();
            $table->timestamps();
        });

        Schema::create('inclusive_restrictions_applied', function (Blueprint $table) {
            $table->id();
            $table->integer('id_restriccion')->nullable();
            $table->integer('id_status')->nullable();
            $table->string('id_persona')->nullable();
            $table->timestamps();
        });

        Schema::create('inclusive_form_restrictions', function (Blueprint $table) {
            $table->id();
            $table->integer('id_form')->nullable();
            $table->integer('id_restriction')->nullable();
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
        Schema::dropIfExists('inclusive_restrictions');
        Schema::dropIfExists('inclusive_form_restrictions');
        Schema::dropIfExists('inclusive_restrictions_applied');
    }
}
