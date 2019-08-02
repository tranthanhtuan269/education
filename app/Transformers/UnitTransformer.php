<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Unit;

class UnitTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Unit $unit)
    {
        return [
            'id' => $unit->id,
            'index'=> $unit->index,
            'name' => $unit->name,
            'course_id' => $unit->course_id,
        ];
    }
}
