<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'name', 'account_number', 'bank_name', 'iban', 'bic_swift', 'status'
    ];
}
