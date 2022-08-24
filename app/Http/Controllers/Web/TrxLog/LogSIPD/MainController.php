<?php

namespace Vanguard\Http\Controllers\Web\TrxLog\LogSIPD;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Vanguard\Http\Controllers\Web\TrxLog\LogSIPD\DbController as Model;

class MainController extends Controller
{
    /**
     * Displays the application dashboard.
     *
     * @return Factory|View
     */
    public function index()
    {
        $data['header'] = Model::getHeader();
        $data['totalAllData'] = Model::getTotal();

        return view('TrxLog.LogSIPD.index', compact('data'));
    }

    public function getData($rst_id, $perPage = 10){
        $data = Model::getPaginate($perPage, $rst_id);
        $blade = view('TrxLog.LogSIPD.component.tableData', compact('data'))->render();
        
        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'blade' => $blade
        ], 200);
    }
}
