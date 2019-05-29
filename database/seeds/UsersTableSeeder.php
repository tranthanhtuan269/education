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
        $user->password = bcrypt('secret12');
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
		
		// add role Admin
		$userRole = new UserRole;
		$userRole->user_id = $user->id;
		$userRole->role_id = 1;
		$userRole->save();

		// add role teacher
		// $userRole2 = new UserRole;
		// $userRole2->user_id = $user->id;
		// $userRole2->role_id = 2;
		// $userRole2->save();

		// // add role student
		// $userRole2 = new UserRole;
		// $userRole2->user_id = $user->id;
		// $userRole2->role_id = 3;
		// $userRole2->save();

    	$ho = ["Rogers", "Banner", "Stark", "Parker", "Strange"];
    	// $lot = ["Oliver", "Alex", "David", "John", "James"];
		$ten = ["Peter", "Steve", "Tony", "Bruce", "Stephen"];
		$experts = ["Football, Guitar, Computer", "Lifestyle, Yoga, Thinking", "Laravel, VueJs, Jquery", "ASP.NET, AngularJs, Flutter"];
    	for($i = 0; $i < 5; $i++){
	    	// for($j = 0; $j < 5; $j++){
		    	for($k = 0; $k < 5; $k++){
			        $user = new User;
			        $user->name = $ten[$i] ." ".$ho[$k];
			        $user->email = $ten[$i] .".".$ho[$k]. "@gmail.com";
			        $user->password = bcrypt('secret12');
			        $user->remember_token = str_random(10);
			        $user->facebook = "https://www.facebook.com/avengers/";
			        $user->phone = "0973619".$i.rand(1,9).$k;
			        $user->address = "Number 2 -Times Square - New York";
			        $user->avatar = "images/avatar_teacher_".$k.".jpg";
			        $user->coins = 350;
			        $user->dob = date("Y-m-d H:i:s");
			        $user->gender = 1;
			        $user->status = 1;
			        $user->save();

			        // add role student
			        $userRole = new UserRole;
			        $userRole->user_id = $user->id;
			        $userRole->role_id = 3;
			        $userRole->save();

			        // add role teacher
			        $userRole2 = new UserRole;
			        $userRole2->user_id = $user->id;
			        $userRole2->role_id = 2;
			        $userRole2->save();

			        $teacher = new Teacher;
			        $teacher->user_role_id = $userRole2->id;
					$teacher->cv = "<p>Chuyên gia <strong>Yoga Nguyễn Hiếu </strong>đã có hơn 12 năm nghiên cứu và giảng dạy Yoga tại các trung tâm và đã huấn luyện cho hàng nghìn học viên khắp Việt Nam và thế giới.</p>

					<p>Chị là Đại sứ Yoga Việt Nam do Trung tâm Unesco Phát triển Văn hóa và Thể thao phong tặng.&nbsp;</p>

					<p>Chị đã thiết kế rất nhiều chương trình Yoga trực tuyến, sở hữu kênh &nbsp;đào tạo Yoga online lớn nhất Việt Nam.</p>

					<p>Hiện tại, Nguyễn Hiếu đang&nbsp;là tổng giám đốc công ty Zenlife Yoga Việt Nam và là huấn luyện viên trưởng cho chương trình đào tạo giáo viên Yoga.</p>

					<p>Hiện nay, dù đã gần 40&nbsp;tuổi và có 2 con lớn, <strong>Chuyên gia Yoga Nguyễn Hiếu </strong>vẫn sở hữu một cơ thể cân đối trẻ trung, khỏe mạnh và dẻo dai như ở tuổi đôi mươi, với vòng eo 60 cm là niềm ao ước của mọi phụ nữ ở độ tuổi này.</p>";
					$teacher->expert = $experts[rand(0, 3)];
					$rating_count = rand (150, 750);
					$teacher->rating_count =  $rating_count;
					$teacher->vote_count = 150;
					$teacher->rating_score = $rating_count / 150;
			        $teacher->student_count = rand(12,20)*1023;
			        $teacher->course_count = rand(6,12);
			        $teacher->video_intro = "https://www.youtube.com/embed/tgbNymZ7vqY?controls=0";
			        $teacher->save();
			    }
			// }
        }
    }
}
