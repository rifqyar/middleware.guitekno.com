<?php

namespace Vanguard\Http\Controllers\Web\MasterData\BankEndpoint;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Vanguard\Http\Controllers\Web\MasterData\BankEndpoint\DbController as Model;
use Vanguard\Http\Controllers\Library;

class MainController extends Controller
{
    /**
     * GET DATA
     */
    public function getBankSecret(){
        $data = Model::getDBS();

        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'data' => $data
        ], 200);
    }

    public function getEndpointType(){
        $data = Model::getRET();

        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'data' => $data
        ], 200);
    }

    public function renderForm(){
        $data = Model::getRET();
        $blade = view('integrasi_bank/component/formAdd', compact('data'))->render();

        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'view' => $blade
        ], 200);
    }

    public function post(Request $req){
        $rawData = $req->post('resData');
        $arrData = [];

        foreach ($rawData as $val) {
            $arrData[$val['name']] = $val['value'];
        }

        $post = Model::postInsertUpdate($arrData, 'insert');
        return response()->json($post->original, $post->original['status']['code']);
    }

    public function postWizard(Request $req){
        $bank_secret = $req->bank_secret;
        $status = $req->status;

        $arrData = [];

        if (count($req->endpoint) > 0){
            try {
                for ($i=0; $i < count($req->endpoint); $i++) {
                    $arrData = array(
                        'bank_secret' => $bank_secret,
                        'endpoint' => $req->endpoint[$i],
                        'endpoint_type' => $req->endpoint_type[$i],
                        'status' => $status,
                    );

                    $arrSpParam = ['bank_secret', 'endpoint', 'endpoint_type', 'status'];
                    $rawSpParam = [];

                    foreach ($arrSpParam as $arrV) {
                        $rawSpParam[$arrV] = null;
                    }

                    $spParam = array_intersect_key($arrData, $rawSpParam);
                    $rawQuery = Library::genereteDataQuery($spParam);
                    $query = 'CALL sp_insert_bankEndpoint ' . $rawQuery['query'];
                    DB::statement($query);
                }

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

    public function put(Request $req){
        $rawData = $req->post('resData');
        $arrData = [];

        foreach ($rawData as $val) {
            $arrData[$val['name']] = $val['value'];
        }

        $post = Model::postInsertUpdate($arrData, 'update');
        return response()->json($post->original, $post->original['status']['code']);
    }

    public function delete($dbs_id, $id){
        $post = Model::deleteData($dbs_id, $id);
        return response()->json($post->original, $post->original['status']['code']);
    }
}
