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
        $videos = Video::get();
        foreach($videos as $key => $video){
            $document = new Document;
            $document->title = "Làm giàu ko khó " . ($key + 1);
            $document->video_id = $video->id;
            $document->url_document = 'https://mshare.io/file/sDosXWr';
            $document->size = rand(10,100);
            $document->save();
        }
    }
}
