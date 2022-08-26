<?php
namespace Vanguard\Http\Controllers\Web\history_overbooking;

use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;
use Vanguard\Http\Controllers\Web\history_overbooking\DbController as LogBankDB;

class DbController extends Controller 
{
    /** GET DATA */
    public static function getAll($filter = ''){
        $filter = rtrim(base64_decode($filter));
        $where = $filter != '' ? "WHERE $filter" : '';
        $data = DB::SELECT("SELECT * FROM vw_Overbooking_H $where");

        return $data;
    }

    public static function getColumnName($excludeColumn = []){
        $whereClause = '';
        if(count($excludeColumn) > 0){
            $whereClause = 'AND column_id NOT IN (';
            for ($i=0; $i < count($excludeColumn); $i++) { 
                $whereClause .= "'$excludeColumn[$i]',";
            }
            $whereClause = rtrim($whereClause, ',');
            $whereClause .= ')';
        }
        $data = DB::SELECT("SELECT * FROM SchemaInfo where table_name = 'vw_overbooking_h' $whereClause");

        return $data;
    }

    public static function getColumnData($col){
        $data = DB::SELECT("SELECT DISTINCT $col FROM VW_OVERBOOKING_H r GROUP BY $col");

        return $data;
    }
}
?>