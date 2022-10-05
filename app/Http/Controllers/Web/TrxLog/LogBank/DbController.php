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

    public static function getPaginate($perPage, $rst_id)
    {
        $data = DB::table("vw_logbanktransaction")->where('rst_id', $rst_id)->paginate($perPage);

        return $data;
    }

    public static function getBpd(){
        $data = DB::select("SELECT * from vw_RefBank order by bank_id");

        return $data;
    }
}
