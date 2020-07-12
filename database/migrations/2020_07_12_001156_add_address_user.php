<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        Schema::table('users', function (Blueprint $table) {
    
            $table->string('address',1000)->nullable();

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     
         
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('address');
                 
                });
    }
}
