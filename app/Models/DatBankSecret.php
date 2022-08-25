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

    public static function countBank()
    {
        return count(DB::SELECT("SELECT * from dat_bank_secret x, ref_bank y where x.code_bank=y.bank_id"));
    }
}
