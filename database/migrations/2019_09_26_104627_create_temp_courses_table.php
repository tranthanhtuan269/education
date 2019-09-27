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
            $table->string('name', 255);
            $table->string('short_description', 255);
            $table->string('slug', 500);
            $table->string('image', 255);
            $table->integer('category_id');
            $table->integer('price')->default(0);
            $table->integer('real_price')->default(0);
            $table->date('from_sale')->nullable();
            $table->date('to_sale')->nullable();
            $table->time('duration')->nullable();

            $table->integer('downloadable_count')->default(0);
            $table->integer('video_count')->default(0);
            $table->integer('student_count')->default(0);
            $table->integer('star_count')->default(0);
            $table->integer('vote_count')->default(0);
            $table->integer('sale_count')->default(0);
            $table->integer('view_count')->default(0);
            
            $table->longText('description', 2000)->nullable();
            $table->longText('will_learn', 2000)->nullable();
            $table->longText('requirement', 2000)->nullable();
            $table->integer('level')->nullable();
            $table->integer('approx_time')->nullable();

            $table->integer('featured')->default(0);
            $table->integer('featured_index')->default(0);
            $table->integer('promotion')->default(0);
            $table->integer('promotion_index')->default(0);
            $table->integer('five_stars')->default(0);
            $table->integer('four_stars')->default(0);
            $table->integer('three_stars')->default(0);
            $table->integer('two_stars')->default(0);
            $table->integer('one_stars')->default(0);
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
