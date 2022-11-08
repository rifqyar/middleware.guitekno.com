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

    public static function countBank()
    {
        return DB::SELECT("SELECT count(1) as total_prop from (
            SELECT distinct prop_id::text
            from trx_overbooking to2
            where prop_id::text is not null
                and prop_id::text not like '%|'
                and prop_id::text not like '|%'
            group by prop_id
        ) as data")[0];
    }

    public function bank()
    {
        return $this->hasOne(RefBank::class, 'bank_id', 'code_bank');
    }
}
