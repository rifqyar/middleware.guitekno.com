<?php
namespace Vanguard\Http\Controllers\Web\history_overbooking;

use Auth;
use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;
use Vanguard\Models\TrxOverBooking;
use Vanguard\Models\TrxOverbookingCutoff;

class DbController
{
    /** GET DATA */
    public static function getAll($filter = ''){
        //Filter by role
        $role = Auth::user()->role_id;
        $prop = Auth::user()->province_id;
        $kabupaten = Auth::user()->dati_id;
        $filter = rtrim(base64_decode($filter));

        $where = '';

        switch ($role) {
            case 1:
            case 3:
                $where = $filter != '' ? "WHERE $filter" : '';
                break;
            case 4:
                $where = $filter != '' ? "WHERE prop_id = '$prop' AND ($filter)" : "WHERE prop_id = '$prop'" ;
                break;

            case 5:
                $where = $filter != '' ? "WHERE prop_id = '$prop' AND dati2_id = '$kabupaten' AND ($filter)" : "WHERE prop_id = '$prop' AND dati2_id = '$kabupaten'";
                break;
            default:
                $where = '';
                break;
        }
        $data = DB::SELECT("SELECT * FROM vw_Overbooking_H $where");

        return $data;
    }

    public static function getAllNew($req){
        
        // $dataOvr_Cutoff = TrxOverbookingCutoff::with('senderBank')->with('receiverBank')->with('ras');
        // $dataOvr_Cutoff->addSelect(['*', DB::raw("'true' as status_cutoff")]);

        // $dataOvr = TrxOverBooking::with('senderBank')->with('receiverBank')->with('ras')->union($dataOvr_Cutoff);
        // $dataOvr->addSelect(['*',DB::raw("'false' as status_cutoff")]);

        $dataOvr = DB::table('vw_overbooking_h');

        $filter = isset($req->filter) ? (count($req->filter) > 0 ? json_decode(json_encode($req->filter)) : '') : '';
        if ($filter != ''){
            foreach ($filter as $val) {
                if (!isset($val->separator)){
                    $dataOvr->where($val->name, $val->operator, $val->value);
                } else {
                    if ($val->separator == 'AND'){
                        $dataOvr->where($val->name, $val->operator, $val->value);
                    } else {
                        $dataOvr->orWhere($val->name, $val->operator, $val->value);
                    }
                }
            }
        }

        /** Filter by user */
        $role = Auth::user()->role_id;
        $prop = Auth::user()->province_id;
        $kabupaten = Auth::user()->dati_id;

        switch ($role) {
            case 4:
                $dataOvr->where(function ($query) use ($prop) {
                    $query->where('prop_id', $prop);
                });
                break;
            case 5:
                $dataOvr->where(function ($query) use ($prop, $kabupaten) {
                    $query->where('prop_id', $prop);
                    $query->where('dati2_id', $kabupaten);
                });
                break;
            default:
                break;
        }

        return $dataOvr->get();
    }

    public static function getColumnName($excludeColumn = [], $table = 'vw_overbooking_h'){
        $whereClause = '';
        if(count($excludeColumn) > 0){
            $whereClause = 'AND column_id NOT IN (';
            for ($i=0; $i < count($excludeColumn); $i++) {
                $whereClause .= "'$excludeColumn[$i]',";
            }
            $whereClause = rtrim($whereClause, ',');
            $whereClause .= ')';
        }
        $data = DB::SELECT("SELECT * FROM SchemaInfo where table_name = '$table' $whereClause");

        return $data;
    }

    public static function getColumnData($col){
        $data = DB::SELECT("SELECT DISTINCT $col FROM vw_overbooking_h r GROUP BY $col");

        return $data;
    }

    public static function CutoffData($filter = ''){
        $filter = rtrim(base64_decode($filter));
        if ($filter != ''){
            $query = "DELETE FROM trx_overbooking where $filter";
        } else {
            $query = "DELETE FROM trx_overbooking";
        }

        DB::statement($query);

        return true;
    }
}
