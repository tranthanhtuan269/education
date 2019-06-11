<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\UserEmail;
use App\Email;

class UnreadEmailsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(UserEmail $unread_emails )
    {
        $wanted_email = Email::find($unread_emails->id);
        return [
            
        ];
    }
}
