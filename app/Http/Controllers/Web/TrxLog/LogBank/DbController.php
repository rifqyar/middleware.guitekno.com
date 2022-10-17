<?php

namespace Vanguard\Http\Controllers\Web\TrxLog\LogBank;

use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;

class DbController
{
    /** GET DATA */
    public static function getAll()
    {
        $data = DB::SELECT("SELECT * FROM vw_logbanktransaction");

        return $data;
    }

    public static function getHeader()
    {
        $data = DB::SELECT("SELECT DISTINCT rst_name, rst_id, count(1) AS total from vw_logbanktransaction GROUP BY rst_name, rst_id");

        return $data;
    }

    public static function getTotal()
    {
        $data = DB::SELECT("SELECT COUNT(1) as total from vw_logbanktransaction");

        return $data;
    }

    public static function getPaginate($perPage, $rst_id, $filter)
    {
        //051, 001, 012, 032, 022
        if ($filter != ''){
            $parameter = json_decode(base64_decode($filter));
            $data = DB::table('vw_logbanktransaction')->where('rst_id', $rst_id);
            switch ($rst_id) {
                case '012':
                    $data->where(function  ($query) use ($parameter) {
                        $query->where('lbt_request', 'like', '%"bank_code":"'.$parameter->bpd.'"%')
                        ->orWhere('lbt_response', 'like', '%"bank_code":"'.$parameter->bpd.'"%');
                    });
                    break;
                case '022':
                    $data->where(function  ($query) use ($parameter) {
                        $query->where('lbt_request', 'like', '%"account_bank":"'.$parameter->bpd.'"%')
                        ->orWhere('lbt_response', 'like', '%"account_bank":"'.$parameter->bpd.'"%');
                    });
                    break;
                default:
                    $data = DB::table('vw_logbanktransaction')->where('rst_id', $rst_id);
                    break;
            };
            if ($parameter->tgl != 'null' && $parameter->operator_tgl != '0'){
                $data->where('lbt_created', $parameter->operator_tgl, $parameter->tgl);
            }
        } else {
            $data = DB::table("vw_logbanktransaction")->where('rst_id', $rst_id);
        }

        return $data->paginate($perPage);
    }

    public static function getBpd(){
        $data = DB::select("SELECT * from vw_banksecret order by code_bank");

        return $data;
    }
}
