<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LogSipdTrx extends Model
{
    protected $table = 'log_sipd_transaction';
    public $incrementing = false;

    protected $fillable = [
        'lst_id', 'lst_created', 'lst_created_by', 'lst_last_updated', 'lst_last_updated_by', 'lst_request', 'lst_response', 'lst_useid', 'rest_id',
        'lst_sipd_tx_id', 'lst_bpd_tx_id'
    ];
}
