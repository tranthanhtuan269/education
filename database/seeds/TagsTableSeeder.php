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
            ['Web Development', 2, 'images/banner_cat_design.png'], 
            ['Graphic Design', 2, 'images/banner_cat_design.png'],
            ['Design Tools', 2, 'images/banner_cat_design.png'], 
            ['User Experience', 2, 'images/banner_cat_design.png'],
            ['Design Thinking', 2, 'images/banner_cat_design.png'],
            ['Web Development', 2, 'images/banner_cat_design.png'], 
            ['Graphic Design', 2, 'images/banner_cat_design.png'],
            ['Design Tools', 2, 'images/banner_cat_design.png'], 
            ['User Experience', 2, 'images/banner_cat_design.png'],
            ['Design Thinking', 2, 'images/banner_cat_design.png'],

            ['IT Certification', 13, 'images/banner_cat_technology.png'],
            ['Network & Security', 13, 'images/banner_cat_technology.png'],
            ['Hardware', 13, 'images/banner_cat_technology.png'],
            ['Operating Systems', 13, 'images/banner_cat_technology.png'],
            ['Artificial Intelligence', 13, 'images/banner_cat_technology.png'],
            ['IT Certification', 13, 'images/banner_cat_technology.png'],
            ['Network & Security', 13, 'images/banner_cat_technology.png'],
            ['Hardware', 13, 'images/banner_cat_technology.png'],
            ['Operating Systems', 13, 'images/banner_cat_technology.png'],
            ['Artificial Intelligence', 13, 'images/banner_cat_technology.png'],
            
            ['Fitness', 24, 'images/banner_cat_lifestyle.png'], 
            ['General Health', 24, 'images/banner_cat_lifestyle.png'], 
            ['Sport', 24, 'images/banner_cat_lifestyle.png'], 
            ['Nutrition', 24, 'images/banner_cat_lifestyle.png'], 
            ['Yoga', 24, 'images/banner_cat_lifestyle.png'],
            ['Fitness', 24, 'images/banner_cat_lifestyle.png'], 
            ['General Health', 24, 'images/banner_cat_lifestyle.png'], 
            ['Sport', 24, 'images/banner_cat_lifestyle.png'], 
            ['Nutrition', 24, 'images/banner_cat_lifestyle.png'], 
            ['Yoga', 24, 'images/banner_cat_lifestyle.png'], 

            ['Teaching Your Kids', 35, 'images/banner_cat_kid.png'],
            ['Playground', 35, 'images/banner_cat_kid.png'],
            ['Communication for children', 35, 'images/banner_cat_kid.png'],
            ['Math For Kids', 35, 'images/banner_cat_kid.png'],
            ['Drawing', 35, 'images/banner_cat_kid.png'],
            ['Teaching Your Kids', 35, 'images/banner_cat_kid.png'],
            ['Playground', 35, 'images/banner_cat_kid.png'],
            ['Communication for children', 35, 'images/banner_cat_kid.png'],
            ['Math For Kids', 35, 'images/banner_cat_kid.png'],
            ['Drawing', 35, 'images/banner_cat_kid.png'],

            ['Teaching Your Kids', 46, 'images/banner_cat_kid.png'],
            ['Playground', 46, 'images/banner_cat_kid.png'],
            ['Communication for children', 46, 'images/banner_cat_kid.png'],
            ['Math For Kids', 46, 'images/banner_cat_kid.png'],
            ['Drawing', 46, 'images/banner_cat_kid.png'],
            ['Teaching Your Kids', 46, 'images/banner_cat_kid.png'],
            ['Playground', 46, 'images/banner_cat_kid.png'],
            ['Communication for children', 46, 'images/banner_cat_kid.png'],
            ['Math For Kids', 46, 'images/banner_cat_kid.png'],
            ['Drawing', 46, 'images/banner_cat_kid.png'],

            ['Arts & Crafts', 57, 'images/banner_cat_personal.png'],
            ['Food & Beverage', 57, 'images/banner_cat_personal.png'],
            ['Beauty & Make up', 57, 'images/banner_cat_personal.png'],
            ['Gaming', 57, 'images/banner_cat_personal.png'],
            ['Home Improvement', 57, 'images/banner_cat_personal.png'],
            ['Arts & Crafts', 57, 'images/banner_cat_personal.png'],
            ['Food & Beverage', 57, 'images/banner_cat_personal.png'],
            ['Beauty & Make up', 57, 'images/banner_cat_personal.png'],
            ['Gaming', 57, 'images/banner_cat_personal.png'],
            ['Home Improvement', 57, 'images/banner_cat_personal.png'],

            ['Digital Marketing', 68, 'images/banner_cat_marketing.png'],
            ['Social Media Marketing', 68, 'images/banner_cat_marketing.png'], 
            ['Search Engine Optimization', 68, 'images/banner_cat_marketing.png'],
            ['Branding', 68, 'images/banner_cat_marketing.png'],
            ['Broadcasting', 68, 'images/banner_cat_marketing.png'],
            ['Digital Marketing', 68, 'images/banner_cat_marketing.png'],
            ['Social Media Marketing', 68, 'images/banner_cat_marketing.png'], 
            ['Search Engine Optimization', 68, 'images/banner_cat_marketing.png'],
            ['Branding', 68, 'images/banner_cat_marketing.png'],
            ['Broadcasting', 68, 'images/banner_cat_marketing.png'],

            ['Break up', 79, 'images/banner_cat_marriage.png'],
            ['Divorce', 79, 'images/banner_cat_marriage.png'],
            ['Having Children', 79, 'images/banner_cat_marriage.png'],
            ['Solving Problems', 79, 'images/banner_cat_marriage.png'],
            ['Understanding', 79, 'images/banner_cat_marriage.png'],
            ['Break up', 79, 'images/banner_cat_marriage.png'],
            ['Divorce', 79, 'images/banner_cat_marriage.png'],
            ['Having Children', 79, 'images/banner_cat_marriage.png'],
            ['Solving Problems', 79, 'images/banner_cat_marriage.png'],
            ['Understanding', 79, 'images/banner_cat_marriage.png'],

            ['Dance Alone ', 90, 'images/banner_cat_personal.png'],
            ['Jobs', 90, 'images/banner_cat_personal.png'],
            ['Skills', 90, 'images/banner_cat_personal.png'],
            ['Mental Health', 90, 'images/banner_cat_personal.png'],
            ['Favourites', 90, 'images/banner_cat_personal.png'],
            ['Dance Alone ', 90, 'images/banner_cat_personal.png'],
            ['Jobs', 90, 'images/banner_cat_personal.png'],
            ['Skills', 90, 'images/banner_cat_personal.png'],
            ['Mental Health', 90, 'images/banner_cat_personal.png'],
            ['Favourites', 90, 'images/banner_cat_personal.png'],

            ['Dance Alone ', 101, 'images/banner_cat_personal.png'],
            ['Jobs', 101, 'images/banner_cat_personal.png'],
            ['Skills', 101, 'images/banner_cat_personal.png'],
            ['Mental Health', 101, 'images/banner_cat_personal.png'],
            ['Favourites', 101, 'images/banner_cat_personal.png'],
            ['Dance Alone ', 101, 'images/banner_cat_personal.png'],
            ['Jobs', 101, 'images/banner_cat_personal.png'],
            ['Skills', 101, 'images/banner_cat_personal.png'],
            ['Mental Health', 101, 'images/banner_cat_personal.png'],
            ['Favourites', 101, 'images/banner_cat_personal.png'],

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
            for ($i=$t[1]; $i <$t[1] + 11 ; $i++) { 
                $tag = new Tag;
                $tag->name = $t[0];
                // $tag->slug = Str::slug($t[0], '-');;
                $tag->image = $banners[rand(0,9)];
                $tag->category_id = $i;
                $tag->status = 1;
                $tag->save();
            }
        }
    }
}
