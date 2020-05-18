<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('nombres',500)->nullable();
            $table->string('apellidos',500)->nullable();
            $table->string('rut',10)->unique();
            $table->string('email')->unique();
            $table->string('direccion',500)->nullable();
            $table->date('fechnac');
            $table->string('telefono1',12)->nullable();
            $table->string('telefono2',12)->nullable();
            $table->string('estado',25)->nullable();
            $table->string('tipo1',20)->nullable();
            $table->string('tipo2',20)->nullable();
            $table->string('tipo3',20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
