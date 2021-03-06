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
    		['PHP', 0], ['Laravel', 1], ['YII', 1], ['Symfony', 1], ['CakePHP', 1],
            ['.Net', 0], ['MVC3', 6], ['MVC4', 6], ['MVC5', 6],
    		['Javascript', 0], ['Nodejs', 10], ['AngularJS', 10], ['VueJS', 10],
    	];
    	foreach($cateArr as $cate){
	        $category = new Category;
	        $category->name = $cate[0];
	        $category->parent_id = $cate[1];
	        $category->save();
        }
    }
}
