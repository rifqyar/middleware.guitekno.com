<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatBankSecret extends Model
{
    //
    public $timestamps = false;
    protected $table = "dat_bank_secret";
    public $incrementing = false;
    public $fillable = [
        'id', 'code_bank', 'client_id', 'client_secret', 'username', 'password', 'token', 'expired_time'
    ];

    public function bank()
    {
        return $this->hasOne(RefBank::class, 'bank_id', 'code_bank');
    }
}
