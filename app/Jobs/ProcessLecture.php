<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Helper\Helper;
use App\Video;

class ProcessLecture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path_video;
    protected $video_id;
    protected $video;
    protected $resolution;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path_video, $video_id, $video, $resolution)
    {
        $this->path_video = $path_video;
        $this->video_id = $video_id;
        $this->video = $video;
        $this->resolution = $resolution;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Helper::convertVideoToMultiResolution($this->video, $this->resolution, $this->path_video);

        // BaTV - Kiểm tra xem video đó còn tồn tại ko, nếu ko xóa luôn các độ phân giải trong video đó
        $check_video = Video::find($this->video_id);
        
        if (!$check_video) {
            $path_video = $this->path_video;
            
            if(\File::exists($path_video)) {
                \File::delete($path_video);
            }
         
        }
        
    }
}
