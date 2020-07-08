<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegisterDataAndLogedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
    
            $table->date('birth_date')->nullable();

        });
        Schema::table('users', function (Blueprint $table) {
    
            $table->string('phone')->nullable();

		});


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('birth_date');
             
            });
            Schema::table('user', function (Blueprint $table) {
                $table->dropColumn('phone');
                 
                });
    }
}
