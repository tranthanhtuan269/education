<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'name', 'category_id', 'price', 'real_price', 'from_sale', 'to_sale', 'duration', 'downloadable_count', 'video_count', 'student_count', 'star_count', 'vote_count', 'sale_count', 'view_count', 'description', 'will_learn', 'requirement', 'level', 'apptox_time', 'featured', 'featured_index', 'promotion', 'promotion_index', 'five_stars', 'four_stars', 'three_stars', 'two_stars', 'one_stars', 'status'
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->integer('category_id');
            $table->integer('price')->default(0);
            $table->integer('real_price')->default(0);
            $table->date('from_sale')->nullable();
            $table->date('to_sale')->nullable();
            $table->integer('duration')->nullable();

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
            $table->integer('apptox_time')->nullable();

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
        Schema::dropIfExists('courses');
    }
}
