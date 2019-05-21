<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'content', 'video_id', 'parent_id', 'state'
        Schema::create('comment_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content');
            $table->integer('user_role_id');
            $table->integer('video_id');
            $table->integer('parent_id')->default(0);
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
        Schema::dropIfExists('comment_videos');
    }
}
