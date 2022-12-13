<?php

namespace Vanguard\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDati extends Model
{
    use HasFactory;
    protected $table = 'ref_dati2';

    public static function getConnectedDati(){
        return DB::select("
        SELECT ref.prop_id, ref.dati_id, rd.dati2_nama from (
            SELECT
                to2.prop_id
                , case 
                    when char_length(to2.dati2_id::text) = 1
                        then '0' || to2.dati2_id::text
                    else to2.dati2_id::text
                end as dati_id
            from trx_overbooking to2
            where to2.dati2_id::text is not null
                and to2.dati2_id::text not like '%|'
                and to2.dati2_id::text not like '|%'
            group by to2.dati2_id, to2.prop_id
            ) as ref join ref_dati2 rd on ref.prop_id::text = rd.prop_id and ref.dati_id = rd.dati2_id order by rd.dati2_nama asc
        ");
    }
}
