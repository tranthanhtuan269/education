<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeCard extends Model
{
    protected $table = 'stripe_card';
    public $timestamps = false;
}
