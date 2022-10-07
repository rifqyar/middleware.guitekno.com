<?php
namespace Vanguard\Http\Controllers\Web\history_overbooking;

use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;

class DbController
{
    /** GET DATA */
    public static function getAll($filter = ''){
        //Filter by role
        $role = auth()->user()->present()->role_id;
        $prop = auth()->user()->present()->province_id;
        $kabupaten = auth()->user()->present()->dati_id;
        $filter = rtrim(base64_decode($filter));
        $where = '';
        
        switch ($role) {
            case 1:
            case 6:
                $where = $filter != '' ? "WHERE $filter" : '';
                break;
            case 7:
                $where = $filter != '' ? "WHERE prop_id = '$prop' AND ($filter)" : "WHERE prop_id = '$prop'" ;
                break;

            case 8:
                $where = $filter != '' ? "WHERE prop_id = '$prop' AND dati2_id = '$kabupaten' AND ($filter)" : "WHERE prop_id = '$prop' AND dati2_id = '$kabupaten'";
                break;
            default:
                $where = '';
                break;
        }

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
