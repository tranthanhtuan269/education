<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use \App\Video;

class VideoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Video $video)
    {
        return [
            'id' => $video->id,
            'name' => $video->name,
            'unit_id' => $video->unit_id,
            'index' => $video->index
        ];
    }
}
