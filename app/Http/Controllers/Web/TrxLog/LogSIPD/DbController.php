<?php
namespace Vanguard\Http\Controllers\Web\TrxLog\LogSIPD;

use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;

class DbController extends Controller 
{
    /** GET DATA */
    public static function getAll(){
        $data = DB::SELECT("SELECT * FROM vw_LogSIPDTransaction");

        return $data;
    }

    public static function getHeader(){
        $data = DB::SELECT("SELECT DISTINCT rst_id, rst_name, count(1) AS total FROM VW_LOGSIPDTRANSACTION D GROUP BY rst_name, rst_id");

        return $data;
    }

    public static function getTotal(){
        $data = DB::SELECT("SELECT COUNT(1) as total from vw_LogSIPDTransaction");
        return $data;
    }

    public static function getPaginate($perPage, $rst_id){
        $data = DB::table("vw_LogSIPDTransaction")->where('rst_id', $rst_id)->paginate($perPage);

        return $data;
    }

}
?>