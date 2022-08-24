<?php
namespace Vanguard\Http\Controllers\Web\history_overbooking;

use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;
use Vanguard\Http\Controllers\Web\history_overbooking\DbController as LogBankDB;

class DbController extends Controller 
{
    /** GET DATA */
    public static function getAll(){
        $data = DB::SELECT("SELECT * FROM vw_Overbooking_H");

        return $data;
    }
}
?>