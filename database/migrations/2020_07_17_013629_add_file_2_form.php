<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFile2Form extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inclusive_questions', function (Blueprint $table) {
    
            $table->integer('document_id')->nullable();
            $table->string('document_name')->nullable();

        });
        Schema::table('inclusive_questions', function (Blueprint $table) {
            $table->renameColumn('edad', 'edad_max');
        });
        Schema::table('inclusive_questions', function (Blueprint $table) {
    
            $table->integer('edad_min')->nullable();

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
            $table->dropColumn('document_id');
            $table->dropColumn('document_name');
        });
        Schema::table('inclusive_questions', function (Blueprint $table) {
            $table->renameColumn('edad_max', 'edad');
        });
        Schema::table('inclusive_questions', function (Blueprint $table) {
            $table->dropColumn('edad_min');
        });
    }
}
