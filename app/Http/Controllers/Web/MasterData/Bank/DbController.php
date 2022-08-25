<?php

namespace Vanguard\Http\Controllers\MasterData\Web\Bank;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Request;
use Vanguard\Http\Controllers\Library;
use Vanguard\Http\Controllers\MasterData\Web\Bank\DbController as BankDbController;

class DbController extends Controller
{
    /**
     * GET DATA
     */
    public static function getBank($id = null){
        $where = '';
        $statement = "*";
        if ($id != null){
            $where = "WHERE bank_id = '$id'";
            $statement = "COUNT(1) as totaldata";
        }

        $data = DB::SELECT("SELECT $statement FROM vw_RefBank $where");

        return $data;
    }

    public static function cekData($id){
        /**
         * Cek data before delete
         */
        $count = DB::SELECT("SELECT COUNT(1) as total FROM VW_BANKSECRET vb LEFT JOIN VW_BANKENDPOINT vb2 ON vb.ID = vb2.DBS_ID  WHERE vb.CODE_BANK = '$id'");

        return $count;
    }
    /**
     * POST DATA
     */

    public static function postInsertUpdate($data, $action){
        $arrSpParam = ['bank_id', 'bank_name'];
        $rawSpParam = [];
        
        foreach ($arrSpParam as $arrV) {
            $rawSpParam[$arrV] = null;
        }

        $spParam = array_intersect_key($data, $rawSpParam);
        $rawQuery = Library::genereteDataQuery($spParam);
        $query = 'CALL sp_'.$action.'_RefBank '.$rawQuery['query'];
        
        $exec = BankDbController::execQuery($query, 'statement');
        return $exec;
    }

    public static function deleteData($id){
        $query = "CALL sp_del_RefBank ('$id')";
        $exec = BankDbController::execQuery($query, 'statement');
        return $exec;
    }
    
    public static function execQuery($sp, $type){
        try {
            $exec = DB::$type($sp);
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'OK'
                ], 'detail' => 'Process Running Successfully'
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Error',
                ],
                'detail' => $th
            ], 500);
        }
    }
}
