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
        $momentNow = new \MomentPHP\MomentPHP();
        if ( ($momentNow->diff($note->created_at, 'months')) <= 1  ){
            $created_at = \Carbon\Carbon::now()->subSeconds($momentNow->diff($note->created_at))->locale('vi_VN')->diffForHumans();
        }else{
            $created_at = $note->created_at->format("d F Y");
        }
        return [
            'content' => $note->content,
            'timeTick' => $time_tick,
            'created_at'=> $created_at
        ];
    }
}
