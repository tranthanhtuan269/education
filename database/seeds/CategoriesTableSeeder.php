<?php

use Illuminate\Database\Seeder;
use App\Category;

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
        
    	foreach($cateArr as $cate){
	        $category = new Category;
            $category->name = $cate[0];
            $category->slug = Str::slug($cate[0], '-');
            $category->featured = 1;
            $category->icon = $cate[2];
            $category->image = $cate[3];
	        $category->save();
        }
    }
}
