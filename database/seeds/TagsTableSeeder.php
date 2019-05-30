<?php

use Illuminate\Database\Seeder;
use App\Tag;
class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tags = [
            ['Web Development', 1, 'images/banner_cat_design.png'], 
            ['Graphic Design', 1, 'images/banner_cat_design.png'],
            ['Design Tools', 1, 'images/banner_cat_design.png'], 
            ['User Experience', 1, 'images/banner_cat_design.png'],
            ['Design Thinking', 1, 'images/banner_cat_design.png'],
            ['Web Development', 1, 'images/banner_cat_design.png'], 
            ['Graphic Design', 1, 'images/banner_cat_design.png'],
            ['Design Tools', 1, 'images/banner_cat_design.png'], 
            ['User Experience', 1, 'images/banner_cat_design.png'],
            ['Design Thinking', 1, 'images/banner_cat_design.png'],

            ['IT Certification', 2, 'images/banner_cat_technology.png'],
            ['Network & Security', 2, 'images/banner_cat_technology.png'],
            ['Hardware', 2, 'images/banner_cat_technology.png'],
            ['Operating Systems', 2, 'images/banner_cat_technology.png'],
            ['Artificial Intelligence', 2, 'images/banner_cat_technology.png'],
            ['IT Certification', 2, 'images/banner_cat_technology.png'],
            ['Network & Security', 2, 'images/banner_cat_technology.png'],
            ['Hardware', 2, 'images/banner_cat_technology.png'],
            ['Operating Systems', 2, 'images/banner_cat_technology.png'],
            ['Artificial Intelligence', 2, 'images/banner_cat_technology.png'],
            
            ['Fitness', 3, 'images/banner_cat_lifestyle.png'], 
            ['General Health', 3, 'images/banner_cat_lifestyle.png'], 
            ['Sport', 3, 'images/banner_cat_lifestyle.png'], 
            ['Nutrition', 3, 'images/banner_cat_lifestyle.png'], 
            ['Yoga', 3, 'images/banner_cat_lifestyle.png'],
            ['Fitness', 3, 'images/banner_cat_lifestyle.png'], 
            ['General Health', 3, 'images/banner_cat_lifestyle.png'], 
            ['Sport', 3, 'images/banner_cat_lifestyle.png'], 
            ['Nutrition', 3, 'images/banner_cat_lifestyle.png'], 
            ['Yoga', 3, 'images/banner_cat_lifestyle.png'], 

            ['Teaching Your Kids', 4, 'images/banner_cat_kid.png'],
            ['Playground', 4, 'images/banner_cat_kid.png'],
            ['Communication for children', 4, 'images/banner_cat_kid.png'],
            ['Math For Kids', 4, 'images/banner_cat_kid.png'],
            ['Drawing', 4, 'images/banner_cat_kid.png'],
            ['Teaching Your Kids', 4, 'images/banner_cat_kid.png'],
            ['Playground', 4, 'images/banner_cat_kid.png'],
            ['Communication for children', 4, 'images/banner_cat_kid.png'],
            ['Math For Kids', 4, 'images/banner_cat_kid.png'],
            ['Drawing', 4, 'images/banner_cat_kid.png'],

            ['English', 5, 'images/banner_cat_language.png'],
            ['Japanese', 5, 'images/banner_cat_language.png'],
            ['French', 5, 'images/banner_cat_language.png'],
            ['Korean', 5, 'images/banner_cat_language.png'],
            ['Chinese', 5, 'images/banner_cat_language.png'],
            ['English', 5, 'images/banner_cat_language.png'],
            ['Japanese', 5, 'images/banner_cat_language.png'],
            ['French', 5, 'images/banner_cat_language.png'],
            ['Korean', 5, 'images/banner_cat_language.png'],
            ['Chinese', 5, 'images/banner_cat_language.png'],

            ['Arts & Crafts', 6, 'images/banner_cat_personal.png'],
            ['Food & Beverage', 6, 'images/banner_cat_personal.png'],
            ['Beauty & Make up', 6, 'images/banner_cat_personal.png'],
            ['Gaming', 6, 'images/banner_cat_personal.png'],
            ['Home Improvement', 6, 'images/banner_cat_personal.png'],
            ['Arts & Crafts', 6, 'images/banner_cat_personal.png'],
            ['Food & Beverage', 6, 'images/banner_cat_personal.png'],
            ['Beauty & Make up', 6, 'images/banner_cat_personal.png'],
            ['Gaming', 6, 'images/banner_cat_personal.png'],
            ['Home Improvement', 6, 'images/banner_cat_personal.png'],

            ['Digital Marketing', 7, 'images/banner_cat_marketing.png'],
            ['Social Media Marketing', 7, 'images/banner_cat_marketing.png'], 
            ['Search Engine Optimization', 7, 'images/banner_cat_marketing.png'],
            ['Branding', 7, 'images/banner_cat_marketing.png'],
            ['Broadcasting', 7, 'images/banner_cat_marketing.png'],
            ['Digital Marketing', 7, 'images/banner_cat_marketing.png'],
            ['Social Media Marketing', 7, 'images/banner_cat_marketing.png'], 
            ['Search Engine Optimization', 7, 'images/banner_cat_marketing.png'],
            ['Branding', 7, 'images/banner_cat_marketing.png'],
            ['Broadcasting', 7, 'images/banner_cat_marketing.png'],

            ['Break up', 8, 'images/banner_cat_marriage.png'],
            ['Divorce', 8, 'images/banner_cat_marriage.png'],
            ['Having Children', 8, 'images/banner_cat_marriage.png'],
            ['Solving Problems', 8, 'images/banner_cat_marriage.png'],
            ['Understanding', 8, 'images/banner_cat_marriage.png'],
            ['Break up', 8, 'images/banner_cat_marriage.png'],
            ['Divorce', 8, 'images/banner_cat_marriage.png'],
            ['Having Children', 8, 'images/banner_cat_marriage.png'],
            ['Solving Problems', 8, 'images/banner_cat_marriage.png'],
            ['Understanding', 8, 'images/banner_cat_marriage.png'],

            ['Dance Alone ', 9, 'images/banner_cat_personal.png'],
            ['Jobs', 9, 'images/banner_cat_personal.png'],
            ['Skills', 9, 'images/banner_cat_personal.png'],
            ['Mental Health', 9, 'images/banner_cat_personal.png'],
            ['Favourites', 9, 'images/banner_cat_personal.png'],
            ['Dance Alone ', 9, 'images/banner_cat_personal.png'],
            ['Jobs', 9, 'images/banner_cat_personal.png'],
            ['Skills', 9, 'images/banner_cat_personal.png'],
            ['Mental Health', 9, 'images/banner_cat_personal.png'],
            ['Favourites', 9, 'images/banner_cat_personal.png'],

            ['Portrait', 10, 'images/banner_cat_photography.png'],
            ['Street', 10, 'images/banner_cat_photography.png'],
            ['Sport', 10, 'images/banner_cat_photography.png'],
            ['Tourism', 10, 'images/banner_cat_photography.png'],
            ['Shape', 10, 'images/banner_cat_photography.png'],
            ['Portrait', 10, 'images/banner_cat_photography.png'],
            ['Street', 10, 'images/banner_cat_photography.png'],
            ['Sport', 10, 'images/banner_cat_photography.png'],
            ['Tourism', 10, 'images/banner_cat_photography.png'],
            ['Shape', 10, 'images/banner_cat_photography.png'],

        ];

        $banners = [
            "images/banner_cat_design.png",
            "images/banner_cat_photography.png",
            "images/banner_cat_health.png",
            "images/banner_cat_kid.png",
            "images/banner_cat_language.png",
            "images/banner_cat_marriage.png",
            "images/banner_cat_personal.png",
            "images/banner_cat_lifestyle.png",
            "images/banner_cat_technology.png",
            "images/banner_cat_marketing.png",
        ];
        
    	foreach($tags as $t){
	        $tag = new Tag;
            $tag->name = $t[0];
            // $tag->slug = Str::slug($t[0], '-');;
            $tag->image = $banners[rand(0,9)];
            $tag->category_id = $t[1];
            $tag->status = 1;
	        $tag->save();
        }
    }
}
