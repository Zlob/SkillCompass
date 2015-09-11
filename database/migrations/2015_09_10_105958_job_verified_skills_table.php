<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobVerifiedSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_verified_skill', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->integer('verified_skill_id')->unsigned();
            $table->foreign('verified_skill_id')->references('id')->on('verified_skills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_verified_skill', function (Blueprint $table) {
            Schema::drop('job_verified_skill');
        });
    }
}
