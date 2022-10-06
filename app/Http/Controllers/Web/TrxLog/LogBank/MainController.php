<?php

namespace Vanguard\Http\Controllers\Web\TrxLog\LogBank;

use Illuminate\Http\Request as Req;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Vanguard\Http\Controllers\Web\TrxLog\LogBank\DbController as Model;

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
        // dd($data);

        return view('TrxLog.LogBank.index', compact('data'));
    }

    public function getData($rst_id, $perPage = 10, $filter = ''){
        $data = Model::getPaginate($perPage, $rst_id, $filter);
        $blade = view('TrxLog.LogBank.component.tableData', compact('data'))->render();
        
        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'blade' => $blade
        ], 200);
    }

    public function renderFilter(){
        $bpd = Model::getBpd();
        $blade = view('TrxLog.LogBank.component.filter', compact('bpd'))->render();

        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'blade' => $blade
        ]);
    }
}
