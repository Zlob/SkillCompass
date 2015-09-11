<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobsAddBegdaEndda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function ($table) {
            $table->integer('vacancy_id');
            $table->date('begda');
            $table->date('endda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function ($table) {
            $table->dropColumn('vacancy_id');
            $table->dropColumn('begda');
            $table->dropColumn('endda');
        });
    }
}
