<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Unit;
use App\Video;
use Illuminate\Support\Str;
class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//'name', 'category_id', 'price', 'real_price', 'from_sale', 'to_sale', 'duration', 'downloadable_count', 'video_count', 'student_count', 'star_count', 'vote_count', 'sale_count', 'view_count', 'description', 'will_learn', 'requirement', 'level', 'apptox_time', 'featured', 'featured_index', 'promotion', 'promotion_index', 'five_stars', 'four_stars', 'three_stars', 'two_stars', 'one_stars', 'status'

    	$courseArr = [
    		[
    			'Laravel cơ bản', 2, 'Giới thiệu về Laravel, các thành phần cơ bản và cấu trúc MVC của Laravle, một số bài thực hành cơ bản với Laravel',
    			[
    				[
						'Giới thiệu về Laravel',
						[
							['Lịch sử các phiên bản', 'videos/video.mp4', 360, 1],
							['Những tính năng vượt trội của Laravel', 'videos/video.mp4', 360, 1]
						]
					],[
						'Getting Started',
						[
							['Installation ', 'videos/video.mp4', 360, 2],
							['Configuration', 'videos/video.mp4', 360, 2],
							['Directory Structure', 'videos/video.mp4', 360, 2]
						]
					],[
						'Architecture Concepts',
						[
							['Request Lifecycel', 'videos/video.mp4', 360, 3],
							['Service Container', 'videos/video.mp4', 360, 3]
						]
					],[
						'The Basics',
						[
							['Routing', 'videos/video.mp4', 360, 4],
							['Middleware', 'videos/video.mp4', 360, 4],
							['Controller', 'videos/video.mp4', 360, 4],
							['Views', 'videos/video.mp4', 360, 4]
						]
					]
				],
				1
    		]
    	];

		for ($i=0; $i < 20 ; $i++) { 
			foreach($courseArr as $course){
				$rand_one = rand (0,30);
				$rand_two = rand (0,30);
				$rand_three = rand (0,30);
				$rand_four = rand (0,30);
				$rand_five = 150 - $rand_one - $rand_two - $rand_three - $rand_four;
	
				$courses = new Course;
				$courses->name = $course[0] . $i;
				$courses->short_description = 'Linux Troubleshooting and Administration';
				$courses->slug = Str::slug($courses->name, '-');
				$courses->image = 'featured_hero_big.png';
				$courses->category_id = $course[1];
				$courses->price = 500000;
				$courses->real_price = 800000;
				$courses->duration = '12:00:00';
				$courses->downloadable_count = 3;
				$courses->video_count = 36;
				$courses->student_count = 150;
				$courses->star_count = $rand_one * 1 + $rand_two * 2 + $rand_three * 3 + $rand_four * 4 + $rand_five * 5;
				$courses->vote_count = 150;
				$courses->sale_count = 150;
				$courses->view_count = 350;
				$courses->description = $course[2];
				$courses->will_learn = '{"0":"Bạn đang học tiếng Hàn, nhưng ngại giao tiếp với người Hàn Quốc","1":"Bạn đang học tiếng Hàn, nhưng ngại giao tiếp với người Hàn Quốc","2":"Bạn đang học tiếng Hàn, nhưng ngại giao tiếp với người Hàn Quốc","3":"Bạn đang học tiếng Hàn, nhưng ngại giao tiếp với người Hàn Quốc"}';
				$courses->requirement = '{"0":"Là người thành lập trang Fanpage dạy tiếng Hàn miễn phí","1":"Là người thành lập trang Fanpage dạy tiếng Hàn miễn phí","2":"Là người thành lập trang Fanpage dạy tiếng Hàn miễn phí","3":"Là người thành lập trang Fanpage dạy tiếng Hàn miễn phí"}';
				$courses->level = 1;
				$courses->approx_time = 516;
				$courses->featured = 1;
				$courses->featured_index = $i;
				$courses->promotion = 1;
				$courses->promotion_index = 1;
				$courses->five_stars = $rand_five;
				$courses->four_stars = $rand_four;
				$courses->three_stars = $rand_three;
				$courses->two_stars = $rand_two;
				$courses->one_stars = $rand_one;
				$courses->status = 1;
				$courses->save();
	
				foreach($course[3] as $unit){
					$unitObj = new Unit;
					$unitObj->name = $unit[0];
					$unitObj->course_id = $courses->id;
					$unitObj->video_count = count($unit[1]);
					$unitObj->save();
	
					foreach($unit[1] as $video){
						$videoObj = new Video();
						$videoObj->name = $video[0];
						$videoObj->url_video = $video[1];
						$videoObj->duration = $video[2];
						$videoObj->unit_id = $unitObj->id;
						$videoObj->state = 1;
						$videoObj->save();
					}
				}
			}
		}
    }
}
