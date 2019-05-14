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
    		['Photoshop cơ bản', 1], ['Photoshop nâng cao', 1],
    		['Laravel', 2], ['YII', 2], ['Symfony', 2], ['CakePHP', 2],
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
