<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LogBankTrx extends Model
{
    protected $table = 'log_bank_transaction';
    public $incrementing = false;

    protected $fillable = [
        'lbt_id', 'lbt_created', 'lbt_created_by', 'lbt_last_updated', 'lbt_last_updated_by', 'lbt_request', 'lbt_response', 'lbt_useid', 'rest_id'
    ];

}
