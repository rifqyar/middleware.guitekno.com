<?php

namespace Vanguard\Http\Controllers\Web\TrxLog\LogSIPD;

use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;

class DbController
{
    /** GET DATA */
    public static function getAll()
    {
        $data = DB::SELECT("SELECT * FROM vw_logsipdtransaction");

        return $data;
    }

    public static function getHeader()
    {
        $data = DB::SELECT("SELECT DISTINCT rst_id, rst_name, count(1) AS total FROM vw_logsipdtransaction D GROUP BY rst_name, rst_id");

        return $data;
    }

    public static function getTotal()
    {
        $data = DB::SELECT("SELECT COUNT(1) as total from vw_logsipdtransaction");
        return $data;
    }

    public static function getPaginate($perPage, $rst_id, $filter)
    {
        if ($filter != ''){
            $parameter = json_decode(base64_decode($filter));
            $data = DB::table('vw_logsipdtransaction')->where('rst_id', $rst_id);
            switch ($rst_id) {
                case '011':
                    $data->where(function  ($query) use ($parameter) {
                        $query->where('lst_request', 'like', '%"bank_code":"'.$parameter->bpd.'"%')
                        ->orWhere('lst_response', 'like', '%"bank_code":"'.$parameter->bpd.'"%');
                    });
                    break;
                case '021':
                    $data->where(function  ($query) use ($parameter) {
                        $query->where('lst_request', 'like', '%"account_bank":"'.$parameter->bpd.'"%')
                        ->orWhere('lst_response', 'like', '%"account_bank":"'.$parameter->bpd.'"%');
                    });
                    break;
                default:
                    $data = DB::table('vw_logsipdtransaction')->where('rst_id', $rst_id);
                    break;
            };
            if ($parameter->tgl != 'null' && $parameter->operator_tgl != '0'){
                if($parameter->tgl2 != 'null'){
                    $data->whereBetween('lst_created', [$parameter->tgl, $parameter->tgl2]);
                } else {
                    $data->where('lst_created', $parameter->operator_tgl, $parameter->tgl);
                }
            }
        } else {
            $data = DB::table("vw_logsipdtransaction")->where('rst_id', $rst_id);
        }

        return $data->paginate($perPage);
    }

    public static function getBpd(){
        $data = DB::select("SELECT * from vw_banksecret order by code_bank");

        return $data;
    }
}
