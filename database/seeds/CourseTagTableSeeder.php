<?php

use Illuminate\Database\Seeder;

class CourseTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1 ; $i < 100 ; $i++ ) {
            for ($j=1; $j <= 8; $j++) { 
                $course = \App\Course::find(rand(1,12));
                $course->tags()->attach($i);
            } 
        }
    }
}
