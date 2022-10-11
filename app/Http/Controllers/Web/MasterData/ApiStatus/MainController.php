<?php

namespace Vanguard\Http\Controllers\Web\MasterData\ApiStatus;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Vanguard\Http\Controllers\Web\MasterData\ApiStatus\DbController as Model;
use Vanguard\Http\Controllers\Library;

class MainController extends Controller
{
    /**
     * GET DATA
     */
    public function getApiStatus($id = null){
        $data = Model::getRAS($id);
        
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

    public function put(Request $req){
        $rawData = $req->post('resData');
        $arrData = [];

        foreach ($rawData as $val) {
            $arrData[$val['name']] = $val['value'];
        }

        $post = Model::postInsertUpdate($arrData, 'update');
        return response()->json($post->original, $post->original['status']['code']);
    }

    public function delete($id){
        $post = Model::deleteData($id);
        return response()->json($post->original, $post->original['status']['code']);
    }
}
