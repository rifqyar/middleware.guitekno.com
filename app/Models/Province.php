<?php

namespace Vanguard\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    protected $table = 'ref_propinsi';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'prop_id', 'prop_nama'
    ];

    public static function getConnectedProp(){
        return DB::SELECT("
            select
                to2.prop_id
                , rp.prop_nama 
            from trx_overbooking to2 
                join ref_propinsi rp on to2.prop_id::text = rp.prop_id 
                where to2.prop_id ::text is not null
                    and to2.prop_id ::text not like '%|'
                    and to2.prop_id ::text not like '|%'
                group by to2.prop_id, rp.prop_nama 
                order by rp.prop_nama asc
        ");
    }

}

?>
