<?php

namespace Vanguard\Http\Controllers\Web\MasterData\BankSecret;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Request;
use Vanguard\Http\Controllers\Library;

class DbController
{
    /**
     * GET DATA
     */
    public static function getBank()
    {
        $data = DB::SELECT("SELECT * FROM vw_AvailBankSecret");

        return $data;
    }

    public static function cekData($id)
    {
        return DB::SELECT("SELECT COUNT(1) AS total from vw_BankEndpoint where dbs_id = '$id'");
    }
    /**
     * POST DATA
     */

    public static function postInsertUpdate($data, $action)
    {
        $arrSpParam = ['id', 'bank_id', 'client_id', 'client_secret', 'username', 'password'];
        $rawSpParam = [];

        foreach ($arrSpParam as $arrV) {
            $rawSpParam[$arrV] = null;
        }

        $spParam = array_intersect_key($data, $rawSpParam);
        $rawQuery = Library::genereteDataQuery($spParam);
        $query = 'CALL sp_' . $action . '_bankSecret ' . $rawQuery['query'];

        $exec = self::execQuery($query, 'statement');
        return $exec;
    }

    public static function deleteData($id)
    {
        $query = "CALL sp_del_bankSecret ('$id')";
        $exec = self::execQuery($query, 'statement');
        return $exec;
    }

    public static function execQuery($sp, $type)
    {
        try {
            $exec = DB::$type($sp);
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'OK'
                ], 'detail' => 'Process Running Successfully'
            ], 200);
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
