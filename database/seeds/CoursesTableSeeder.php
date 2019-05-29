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
			$sample_course_names = [
				'Build Web Apps with Vue JS 2 & Firebase',
				'Modern JavaScript (from Novice to Ninja)',
				'Ultimate Google Ads / AdWords Course 2018',
				'Home Business: The Complete CPA Marketing',
				'Travel Writing: Explore the World & Publish Your Stories!',
				'Travel Hacking and Credit Card Reward Basics!',
				'The Complete Financial Analyst Training Course',
				'Forex Robots: Automate Your Trading',
				'Business Strategy Execution: The Agile/Lean Way',
				'THE 8 FACTORS: Gain Clarity & Grow Your Business',
				'Complete Guitar System - Beginner to Advanced',
				'Pianoforall - Incredible New Way To Learn Piano',
				'Learn to play HARMONICA - the easiest axe you can!'
			];
    	$courseArr = [
    		[
    			'Build Web Apps with Vue JS 2 & Firebase', 2, 'Vue JS is an awesome JavaScript Framework for building Frontend Applications! VueJS mixes the Best of Angular + React!',
    			[
    				[
						'Getting Started',
						[
							['Course Introduction', '{"1080" : "vod/_definst_/bai-nay-chill-phet-1080.mp4","720" : "vod/_definst_/bai-nay-chill-phet-720.mp4","480" : "vod/_definst_/bai-nay-chill-phet-480.mp4","360" : "vod/_definst_/bai-nay-chill-phet-360.mp4"}', rand(300, 600), 1,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],
							["Let's Create our First VueJS Application",  '{"1080" : "vod/_definst_/dung-yeu-nua-em-met-roi-1080.mp4","720" : "vod/_definst_/dung-yeu-nua-em-met-roi-720.mp4","480" : "vod/_definst_/dung-yeu-nua-em-met-roi-480.mp4","360" : "vod/_definst_/dung-yeu-nua-em-met-roi-360.mp4"}', rand(300, 600), 1,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],
							["Expanding the VueJs Application",  '{"1080" : "vod/_definst_/dung-yeu-nua-em-met-roi-1080.mp4","720" : "vod/_definst_/dung-yeu-nua-em-met-roi-720.mp4","480" : "vod/_definst_/dung-yeu-nua-em-met-roi-480.mp4","360" : "vod/_definst_/dung-yeu-nua-em-met-roi-360.mp4"}', rand(300, 600), 1,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							]
						]
					],[
						'Using VueJs to Interact with the DOM',
						[
							['Module Introduction ',  '{"1080" : "vod/_definst_/bai-nay-chill-phet-1080.mp4","720" : "vod/_definst_/bai-nay-chill-phet-720.mp4","480" : "vod/_definst_/bai-nay-chill-phet-480.mp4","360" : "vod/_definst_/bai-nay-chill-phet-360.mp4"}', rand(300, 600), 2,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],
							['Understanding VueJs Templates', '{"1080" : "vod/_definst_/bai-nay-chill-phet-1080.mp4","720" : "vod/_definst_/bai-nay-chill-phet-720.mp4","480" : "vod/_definst_/bai-nay-chill-phet-480.mp4","360" : "vod/_definst_/bai-nay-chill-phet-360.mp4"}', rand(300, 600), 2,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],
							['Accessing Data in the Vue Instance', '{"1080" : "vod/_definst_/bai-nay-chill-phet-1080.mp4","720" : "vod/_definst_/bai-nay-chill-phet-720.mp4","480" : "vod/_definst_/bai-nay-chill-phet-480.mp4","360" : "vod/_definst_/bai-nay-chill-phet-360.mp4"}', rand(300, 600), 2,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							]
						]
					],[
						'Using Conditional and Rendering Lists',
						[
							['Request Lifecycel', '{"1080" : "vod/_definst_/dung-yeu-nua-em-met-roi-1080.mp4","720" : "vod/_definst_/dung-yeu-nua-em-met-roi-720.mp4","480" : "vod/_definst_/dung-yeu-nua-em-met-roi-480.mp4","360" : "vod/_definst_/dung-yeu-nua-em-met-roi-360.mp4"}', rand(300, 600), 3,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],
							['Service Container',  '{"1080" : "vod/_definst_/bai-nay-chill-phet-1080.mp4","720" : "vod/_definst_/bai-nay-chill-phet-720.mp4","480" : "vod/_definst_/bai-nay-chill-phet-480.mp4","360" : "vod/_definst_/bai-nay-chill-phet-360.mp4"}', rand(300, 600), 3,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],
							['Looping through Objects',  '{"1080" : "vod/_definst_/bai-nay-chill-phet-1080.mp4","720" : "vod/_definst_/bai-nay-chill-phet-720.mp4","480" : "vod/_definst_/bai-nay-chill-phet-480.mp4","360" : "vod/_definst_/bai-nay-chill-phet-360.mp4"}', rand(300, 600), 3,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							]
						]
					],[
						'Understanding the VueJs Instance',
						[
							['Routing',  '{"1080" : "vod/_definst_/dung-yeu-nua-em-met-roi-1080.mp4","720" : "vod/_definst_/dung-yeu-nua-em-met-roi-720.mp4","480" : "vod/_definst_/dung-yeu-nua-em-met-roi-480.mp4","360" : "vod/_definst_/dung-yeu-nua-em-met-roi-360.mp4"}', rand(300, 600), 4,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],

							['Middleware',  '{"1080" : "vod/_definst_/bai-nay-chill-phet-1080.mp4","720" : "vod/_definst_/bai-nay-chill-phet-720.mp4","480" : "vod/_definst_/bai-nay-chill-phet-480.mp4","360" : "vod/_definst_/bai-nay-chill-phet-360.mp4"}', rand(300, 600), 4,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],

							['Controller',  '{"1080" : "vod/_definst_/dung-yeu-nua-em-met-roi-1080.mp4","720" : "vod/_definst_/dung-yeu-nua-em-met-roi-720.mp4","480" : "vod/_definst_/dung-yeu-nua-em-met-roi-480.mp4","360" : "vod/_definst_/dung-yeu-nua-em-met-roi-360.mp4"}', rand(300, 600), 4,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							],
							['Views',  '{"1080" : "vod/_definst_/bai-nay-chill-phet-1080.mp4","720" : "vod/_definst_/bai-nay-chill-phet-720.mp4","480" : "vod/_definst_/bai-nay-chill-phet-480.mp4","360" : "vod/_definst_/bai-nay-chill-phet-360.mp4"}', rand(300, 600), 4,
							"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
							]
						]
					]
				],
				1
    		]
    	];

			
		for ($i=1; $i <= 12 ; $i++) { 
			foreach($courseArr as $course){
				$five_stars = rand(1,100);
				$four_stars = rand(1,100);
				$three_stars = rand(1,100);
				$two_stars = rand(1,100);
				$one_stars = rand(1,100);

				$courses = new Course;
				$courses->name = $sample_course_names[$i];
				// $courses->name = $course[0] .' '. $i;
				$courses->short_description = "Learn one of the most famous front-end framework!";
				$courses->slug = Str::slug($courses->name, '-');
				$courses->image = 'course_'.$i.'.jpg';
				$courses->category_id = $course[1];
				$courses->price = rand(2, 5)*100000;
				$courses->real_price = rand(6,9)*100000;
				$courses->from_sale = "2019-05-01";
				$courses->to_sale = "2019-0".rand(5,8)."-20";
				$courses->duration = rand(1,3).':'.rand(10,59).':'.rand(10,59);
				$courses->downloadable_count = 3;
				$courses->video_count = 13;
				$courses->student_count = rand(20,35)*1000;
				$courses->star_count = $five_stars * 5 + $four_stars * 4 + $three_stars * 3 + $two_stars * 2  + $one_stars;
				$courses->vote_count = $five_stars + $four_stars + $three_stars + $two_stars + $one_stars;
				$courses->sale_count = 0;
				$courses->view_count = rand(25,35)*10123;
				$courses->description = $course[2];
				$courses->will_learn = '{"0":"Build amazing Vue.js Applications - all the Way from Small and Simple Ones up to Large Enterprise-level Ones","1":"Leverage Vue.js in both Multi- and Single-Page-Applications (MPAs and SPAs)","2":"Understand the Theory behind Vue.js and use it in Real Projects"}';
				$courses->requirement = '{"0":"Basic JavaScript Knowledge is Required","1":"ES6 Knowledge is a Plus but not a Must","2":"Basic HTML and CSS Knowledge is assumed throughout the Course","3":"Having NodeJs coding skills"}';
				$courses->level = 1;
				$courses->approx_time = rand(3,7)*rand(7,9);
				$courses->featured = 1;
				$courses->featured_index = $i;
				$courses->promotion = 1;
				$courses->promotion_index = 1;
				$courses->five_stars = $five_stars;
				$courses->four_stars = $four_stars;
				$courses->three_stars = $three_stars;
				$courses->two_stars = $two_stars;
				$courses->one_stars = $one_stars;
				$courses->status = 1;
				$courses->save();


				$videoIndex = 1;
				foreach($course[3] as $key => $unit){
					$unitObj = new Unit;
					$unitObj->name = $unit[0];
					$unitObj->index = $key+1;
					$unitObj->course_id = $courses->id;
					$unitObj->video_count = count($unit[1]);
					$unitObj->save();
	
					foreach($unit[1] as $video){

						$videoObj = new Video();
						$videoObj->name = $video[0];
						$videoObj->index = $videoIndex;
						$videoObj->url_video = $video[1];
						$videoObj->duration = $video[2];
						$videoObj->description = $video[4];
						$videoObj->unit_id = $unitObj->id;
						$videoObj->state = 1;
						$videoObj->save();

						$videoIndex = $videoIndex + 1;
					}
				}
			}
		}
    }
}
