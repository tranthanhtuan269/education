<?php

use Illuminate\Database\Seeder;
use App\UserRole;
use App\Teacher;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = new User;
        $user->name = "Tran Thanh Tuan";
        $user->email = "tran.thanh.tuan269@gmail.com";
        $user->password = bcrypt('secret');
        $user->remember_token = str_random(10);
        $user->facebook = "https://www.facebook.com/canhchimcodon26988";
        $user->phone = "0973619398";
        $user->address = "So 65 - to 7 - Dong Anh - Ha Noi";
        $user->avatar = "images/avatar.jpg";
        $user->coins = 350;
        $user->dob = date("Y-m-d H:i:s");
        $user->gender = 1;
        $user->status = 1;
        $user->save();
        // add role

    	$ho = ["Tran", "Le", "Nguyen", "Pham", "Dang"];
    	$lot = ["", "Thi", "Thanh", "Tuyet", "Ngoc"];
    	$ten = ["Ha", "Suong", "Mai", "Anh", "Tu"]; 
    	for($i = 0; $i < 5; $i++){
	    	for($j = 0; $j < 5; $j++){
		    	for($k = 0; $k < 5; $k++){
			        $user = new User;
			        $user->name = $ho[$i] ." ".$lot[$j] ." ".$ten[$k];
			        $user->email = $ho[$i] .".".$lot[$j] .".".$ten[$k]. "@gmail.com";
			        $user->password = bcrypt('secret');
			        $user->remember_token = str_random(10);
			        $user->facebook = "https://www.facebook.com/canhchimcodon26988";
			        $user->phone = "0973619".$i.$j.$k;
			        $user->address = "So 65 - to 7 - Dong Anh - Ha Noi";
			        $user->avatar = "images/avatar.jpg";
			        $user->coins = 350;
			        $user->dob = date("Y-m-d H:i:s");
			        $user->gender = 1;
			        $user->status = 1;
			        $user->save();

			        // add role student
			        $userRole = new UserRole;
			        $userRole->user_id = $user->id;
			        $userRole->role_id = 1;
			        $userRole->save();

			        // add role teacher
			        $userRole2 = new UserRole;
			        $userRole2->user_id = $user->id;
			        $userRole2->role_id = 2;
			        $userRole2->save();

			        $teacher = new Teacher;
			        $teacher->user_role_id = $userRole2->id;
			        $teacher->cv = "";
			        $teacher->rating_count = rand (150, 750);
			        $teacher->vote_count = 150;
			        $teacher->student_count = 150;
			        $teacher->course_count = 15;
			        $teacher->video_intro = "videos/video_intro.mp4";
			        $teacher->save();
			    }
			}
        }
    }
}
