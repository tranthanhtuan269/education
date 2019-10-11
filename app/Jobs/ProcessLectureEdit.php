<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Helper\Helper;
use App\TempVideo;

class ProcessLectureEdit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;
    public $video_id;
    public $resolution;
    public $path_video;
    public $video_temp_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path_video, $video_temp_id, $video_id, $video, $resolution)
    {
        $this->video = $video;
        $this->video_id = $video_id;
        $this->resolution = $resolution;
        $this->path_video = $path_video;
        $this->video_temp_id = $video_temp_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Helper::convertVideoToMultiResolution($this->video, $this->resolution, $this->path_video);        
    }
}
