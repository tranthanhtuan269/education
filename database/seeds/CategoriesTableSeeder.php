<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Tag;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$cateArr = [
            ['Design', 0, 'fa-palette', 'banner_cat_design.png'], 
            ['Technology', 0, 'fa-wrench', 'banner_cat_technology.png'], 
            ['Health', 0, 'fa-book-medical', 'banner_cat_health.png'],
            ['Kid', 0, 'fa-baby', 'banner_cat_kid.png'], 
            ['Language', 0, 'fa-language', 'banner_cat_language.png'],
            ['LifeStyle', 0, 'fa-tshirt', 'banner_cat_lifestyle.png'], 
            ['Marketing', 0, 'fa-store', 'banner_cat_marketing.png'],
            ['Marriage', 0, 'fa-home', 'banner_cat_marriage.png'],
            ['Personal', 0, 'fa-users', 'banner_cat_personal.png'],
            ['Photography', 0, 'fa-camera-retro', 'banner_cat_photography.png']
        ];

        // $tags = [
        //     ['Web Development', 1, 'images/banner_cat_language.png'], 
        //     ['Mysql', 1, 'images/banner_cat_marriage.png'],
        //     ['Laravel', 2, 'images/banner_cat_lifestyle.png'], 
        //     ['YII', 2, 'images/banner_cat_language.png'], 
        //     ['Symfony', 2, 'images/banner_cat_personal.png'],
        //     ['Zend', 1, 'images/banner_cat_marketing.png'], 
        //     ['Python', 1, 'images/banner_cat_marketing.png'],
        //     ['Cake', 2, 'images/banner_cat_language.png'], 
        //     ['Jquery', 2, 'images/banner_cat_language.png'], 
        //     ['Angular', 2, 'images/banner_cat_personal.png'],
    	// ];


    	foreach($cateArr as $key_cate => $cate){
	        $category = new Category;
            $category->name = $cate[0];
            $category->parent_id = 0;
            $category->featured = 1;
            $category->icon = $cate[2];
            $category->image = $cate[3];
            $category->save();
            
            foreach($cateArr as $key => $value){
                $category_child = new Category;
                $category_child->name = $value[0]. '_' .$key_cate.' '.$key;
                $category_child->parent_id = $category->id;
                $category_child->featured = 1;
                $category_child->icon = $value[2];
                $category_child->image = $value[3];
                $category_child->save();
            }
        }



    }
}
