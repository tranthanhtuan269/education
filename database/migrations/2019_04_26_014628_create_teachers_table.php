<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_role_id')->default(0);
            $table->longText('cv', 2000)->nullable();
            $table->string('expert', 255);
            $table->integer('rating_count')->default(0);  //Total number of stars
            $table->integer('vote_count')->default(0);     //Total number of votes
            $table->double('rating_score')->default(0);    //Average star for each teacher.
            $table->integer('student_count')->default(0);
            $table->integer('course_count')->default(0);
            $table->string('video_intro', 255)->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('teachers');
    }
}
