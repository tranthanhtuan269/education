<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'content', 'course_id', 'parent_id', 'state'
        Schema::create('comment_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content', 255);
            $table->integer('course_id');
            $table->integer('parent_id')->default(0);
            $table->integer('score')->default(0);
            $table->integer('state')->default(0);
            $table->integer('user_role_id');
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
        Schema::dropIfExists('comments');
    }
}
