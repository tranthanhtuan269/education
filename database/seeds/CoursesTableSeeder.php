<?php

use Illuminate\Database\Seeder;
use App\Course;

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
    		['Laravel cơ bản', 2, 'Giới thiệu về Laravel, các thành phần cơ bản và cấu trúc MVC của Laravle, một số bài thực hành cơ bản với Laravel'], 
    		['Laravel cho designer', 2, 'Giới thiệu về Laravel, cách sử dụng Laravel cho các bài toán thực tế, viết ứng dụng quản lý ảnh '], 
    		['Sử lý gửi email tự động trong Laravel', 2, 'Đặt vấn đề với một bài toán cơ bản, cách giải quyết, chia vấn đề lớn thành nhiều vấn đề cơ bản và cách xử lý vấn đề gửi email tự động trong Laravel'], 

    		['YII cơ bản', 2, 'Giới thiệu về YII, các thành phần cơ bản và cấu trúc MVC của Laravle, một số bài thực hành cơ bản với YII'], 
    		['YII cho designer', 2, 'Giới thiệu về YII, cách sử dụng YII cho các bài toán thực tế, viết ứng dụng quản lý ảnh '], 
    		['Sử lý gửi email tự động trong YII', 2, 'Đặt vấn đề với một bài toán cơ bản, cách giải quyết, chia vấn đề lớn thành nhiều vấn đề cơ bản và cách xử lý vấn đề gửi email tự động trong YII'], 

    		['Symfony cơ bản', 2, 'Giới thiệu về Symfony, các thành phần cơ bản và cấu trúc MVC của Laravle, một số bài thực hành cơ bản với Symfony'], 
    		['Symfony cho designer', 2, 'Giới thiệu về Symfony, cách sử dụng Symfony cho các bài toán thực tế, viết ứng dụng quản lý ảnh '], 
    		['Sử lý gửi email tự động trong Symfony', 2, 'Đặt vấn đề với một bài toán cơ bản, cách giải quyết, chia vấn đề lớn thành nhiều vấn đề cơ bản và cách xử lý vấn đề gửi email tự động trong Symfony'],

    		['CakePHP cơ bản', 2, 'Giới thiệu về CakePHP, các thành phần cơ bản và cấu trúc MVC của Laravle, một số bài thực hành cơ bản với CakePHP'], 
    		['CakePHP cho designer', 2, 'Giới thiệu về CakePHP, cách sử dụng CakePHP cho các bài toán thực tế, viết ứng dụng quản lý ảnh '], 
    		['Sử lý gửi email tự động trong CakePHP', 2, 'Đặt vấn đề với một bài toán cơ bản, cách giải quyết, chia vấn đề lớn thành nhiều vấn đề cơ bản và cách xử lý vấn đề gửi email tự động trong CakePHP'], 
    	];

    	foreach($courseArr as $course){
	    	$rand_one = rand (0,30);
	    	$rand_two = rand (0,30);
	    	$rand_three = rand (0,30);
	    	$rand_four = rand (0,30);
	    	$rand_five = 150 - $rand_one - $rand_two - $rand_three - $rand_four;

	        $courses = new Course;
	        $courses->name = $course[0];
	        $courses->category_id = $course[1];
	        $courses->price = 500000;
	        $courses->price = 800000;
	        $courses->duration = 516;
	        $courses->downloadable_count = 3;
	        $courses->video_count = 36;
	        $courses->student_count = 150;
	        $courses->star_count = $rand_one * 1 + $rand_two * 2 + $rand_three * 3 + $rand_four * 4 + $rand_five * 5;
	        $courses->vote_count = 150;
	        $courses->sale_count = 150;
	        $courses->view_count = 350;
	        $courses->description = $course[2];
	        $courses->will_learn = $course[2];
	        $courses->requirement = "MVC";
	        $courses->level = 1;
	        $courses->apptox_time = 516;
	        $courses->featured = 1;
	        $courses->featured_index = 1;
	        $courses->promotion = 1;
	        $courses->promotion_index = 1;
	        $courses->five_stars = $rand_five;
	        $courses->four_stars = $rand_four;
	        $courses->three_stars = $rand_three;
	        $courses->two_stars = $rand_two;
	        $courses->one_stars = $rand_one;
	        $courses->status = 1;
	        $courses->save();
	    }
    }
}
