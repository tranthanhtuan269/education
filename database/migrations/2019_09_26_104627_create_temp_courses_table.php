<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('course_id');
            $table->string('name', 255);
            $table->string('short_description', 255);
            $table->string('slug', 500);
            $table->string('image', 255);
            $table->integer('category_id');
            $table->integer('price')->default(0);
            $table->integer('real_price')->default(0);
            $table->date('author')->nullable();

            $table->longText('description', 2000)->nullable();
            $table->longText('will_learn', 2000)->nullable();
            $table->longText('requirement', 2000)->nullable();
            $table->integer('level')->nullable();
            $table->integer('approx_time')->nullable();
            $table->string('link_intro', 255)->nullable();

            $table->integer('status')->default(0);
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
        Schema::dropIfExists('temp_courses');
    }
}
