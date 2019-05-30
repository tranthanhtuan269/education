<?php

use Illuminate\Database\Seeder;
use App\UserCourse;

class UserCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for ($i = 1; $i < 21; $i++) {
        //     $user_course = new UserCourse;
        //     $user_course->user_role_id = 1;
        //     $user_course->course_id = $i;
        //     $user_course->videos = '{ "learning": 10, "learning_id": 10, "videos":[ 1, 1, 0, 1, 0, 0, 1, 1, 0, 1, 1 ]}';
        //     $user_course->status = 1;
        //     $user_course->save();
        // }
        
        
        for ($j = 0; $j < 12 ; $j++) { 
            $randomValue = mt_rand(3,21);
            $even = $randomValue & ~1;
            $odd = $randomValue | 1;

            $user_course = new UserCourse;
            $user_course->user_role_id = $odd;
            $user_course->course_id = $j;
            $user_course->videos = '{ "learning": 10, "learning_id": 10, "videos":[ 1, 1, 0, 1, 0, 0, 1, 1, 0, 1, 1, 2 ]}';
            $user_course->status = 2;
            $user_course->save();
        }
    }
}
