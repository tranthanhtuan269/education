<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'content', 'video_id', 'user_id', 'time_tick'
        Schema::create('notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content', 255);
            $table->integer('video_id');
            $table->integer('user_id');
            $table->integer('time_tick');
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
        Schema::dropIfExists('notes');
    }
}
