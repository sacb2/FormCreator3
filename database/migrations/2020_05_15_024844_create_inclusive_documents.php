<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInclusiveDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inclusive_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',300)->nullable();
            $table->string('route',300)->nullable();
            $table->integer('estado')->nullable();
            $table->integer('tipo')->nullable();
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
        Schema::dropIfExists('inclusive_documents');
    }
}
