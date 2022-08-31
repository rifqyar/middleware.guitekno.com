<?php

namespace Vanguard\Http\Controllers\Web\MasterData\BankEndpoint;

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
    public static function getDBE()
    {
        $data = DB::SELECT("SELECT * FROM vw_BankEndpoint");

        return $data;
    }

    public static function getDBS()
    {
        $data = DB::SELECT("SELECT * FROM vw_BankSecret");

        return $data;
    }

    public static function getRET()
    {
        $data = DB::SELECT("SELECT * FROM vw_refEndpoint");

        return $data;
    }

    /**
     * POST DATA
     */

    public static function postInsertUpdate($data, $action)
    {
        $arrSpParam = ['bank_secret', 'endpoint', 'endpoint_type'];
        $rawSpParam = [];

        foreach ($arrSpParam as $arrV) {
            $rawSpParam[$arrV] = null;
        }

        $spParam = array_intersect_key($data, $rawSpParam);
        $rawQuery = Library::genereteDataQuery($spParam);
        $query = 'CALL sp_' . $action . '_bankEndpoint ' . $rawQuery['query'];

        $exec = self::execQuery($query, 'statement');
        return $exec;
    }

    public static function deleteData($id)
    {
        $query = "CALL sp_del_bankEndpoint ('$id')";
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
