<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'content', 'lecturer_id', 'parent_id', 'state'
        Schema::create('comment_lecturers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content', 255);
            $table->integer('lecture_id');
            $table->integer('parent_id');
            $table->integer('state')->default(0);
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
