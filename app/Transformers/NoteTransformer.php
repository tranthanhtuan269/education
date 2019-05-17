<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Note;
use App\Helper\Helper;

class NoteTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Note $note)
    {
        $time_tick = "";
        if($note->time_tick){
            $time_tick = Helper::convertSecondToTimeFormat($note->time_tick);
        }else{
            $time_tick = "0:00";
        }
        return [
            'content' => $note->content,
            'timeTick' => $time_tick,
            'created_at'=> $note->created_at->format('Y-m-d H:i:s')         
        ];
    }
}
