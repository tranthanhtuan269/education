<?php

use Illuminate\Database\Seeder;
use App\Video;
use App\Document;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker\Factory::create();

        $videos = Video::get();
        foreach($videos as $key => $video){
            for ($i=0; $i < 5; $i++) { 
                $document = new Document;
                $document->title = $faker->catchPhrase;
                $document->video_id = $video->id;
                $document->url_document = 'https://mshare.io/file/sDosXWr';
                $document->size = rand(10,100);
                $document->save();
            }
        }
    }
}
