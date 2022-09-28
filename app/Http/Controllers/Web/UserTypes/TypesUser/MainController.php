<?php

namespace Vanguard\Http\Controllers\Web\UserTypes\TypesUser;

use Illuminate\Http\Request as Req;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Vanguard\Http\Controllers\Web\UserTypes\TypesUser\DbController as Model;

class MainController extends Controller
{
    /**
     * Displays the application dashboard.
     *
     * @return Factory|View
     */
    public function index()
    {
        $data['types'] = Model::getAll();
        // dd($data);

        return view('UserTypes.permission.index', compact('data'));
    }

    public function create()
    {
        $data['types'] = Model::getAll();
        // dd($data);

        return view('UserTypes.permission.action.create', compact('data'));
    }

    // public function getData($rst_id, $perPage = 10){
    //     $data = Model::getPaginate($perPage, $rst_id);
    //     $blade = view('TrxLog.LogBank.component.tableData', compact('data'))->render();

    //     return response()->json([
    //         'status' => [
    //             'code' => 200,
    //             'msg' => 'OK'
    //         ], 'blade' => $blade
    //     ], 200);
    // }
}
