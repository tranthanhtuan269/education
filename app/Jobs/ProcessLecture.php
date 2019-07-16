<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Helper\Helper;

class ProcessLecture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;
    protected $resolution;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video, $resolution)
    {
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
        Helper::convertVideoToMultiResolution($this->video, $this->resolution);
    }
}
