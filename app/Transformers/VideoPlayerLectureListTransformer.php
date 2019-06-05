<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Video;
use App\Unit;
use App\Helper\Helper;


class VideoPlayerLectureListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Video $video)
    {   
        return [
            "unitIndex" => $video->unit->index,
            "unitName"  => $video->unit->name,
            'id'        => $video->id,
            "index"     => $video->index,
            "name"      => $video->name,
            "duration"  => Helper::convertSecondToTimeFormat($video->duration),
        ];
    }
}
