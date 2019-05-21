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
        for ($i = 1; $i < 21; $i++) {
            $user_course = new UserCourse;
            $user_course->user_role_id = 1;
            $user_course->course_id = $i;
            $user_course->videos = '{ "learning": 10, "videos":[ 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0 ]}';
            $user_course->status = 1;
            $user_course->save();
        }
    }
}
