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
        $rawData = $req->post('resData');
        $arrData = [];

        for ($i=0; $i < count($rawData); $i++) { 
            if ($rawData[$i]['name'] != 'bank_secret_show'){
                if ($rawData[$i]['name'] == 'status'){
                    $arrData['status'] = $rawData[1]['value'];
                } else if ($rawData[$i]['name'] == 'bank_secret'){
                    $arrData['dbs_id'] = $rawData[0]['value'];
                } else if($rawData[$i]['name'] == 'endpoint') {
                    $arrData['dbe_endpoint'] = $rawData[$i]['value'];
                } else if($rawData[$i]['name'] == 'endpoint_type') {
                    $arrData['ret_id'] = $rawData[$i]['value'];
                }
            }

            if (count($arrData) >= 4){
                
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
