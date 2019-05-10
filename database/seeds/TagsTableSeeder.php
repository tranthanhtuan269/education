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
    		['Laravel', 1], ['YII', 1], ['Symfony', 1], ['CakePHP', 1],
    	];
    	foreach($tags as $t){
	        $tag = new Tag;
            $tag->name = $t[0];
            $tag->cat_id = $t[1];
            $tag->status = 1;
	        $tag->save();
        }
    }
}
