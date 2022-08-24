<?php

namespace Vanguard\MasterData\Http\Controllers\Web;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Request;

class MasterDataController extends Controller
{
    /**
     * Displays the plugin index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('master-data::index');
    }

    public function getRefBank(HttpRequest $req){
        $data = DB::SELECT("SELECT * FROM vw_RefBank");
        if($req->ajax()){
            return Datatables::of($data)
            ->addColumn('action', function($data) {
                $JSON_Sting = json_encode($data);
                return '
                    <button
                        class="btn btn-icon"
                        onclick="editBank(`'.base64_encode($JSON_Sting).'`)"
                        title="Edit Bank"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button
                        class="btn btn-icon"
                        onclick="deleteBank(`'.base64_encode($JSON_Sting).'`)"
                        title="Delete Bank"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('master-data::bank.index', compact('data'));
    }

    public function getBankSecret(HttpRequest $req){
        $data = DB::SELECT("SELECT * FROM vw_BankSecret");
        //lowercase
        if($req->ajax()){
            return Datatables::of($data)
            ->addColumn('action', function($data) {
                $JSON_Sting = json_encode($data);
                return '
                    <button
                        class="btn btn-icon"
                        onclick="editBank(`'.base64_encode($JSON_Sting).'`)"
                        title="Edit Bank"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button
                        class="btn btn-icon"
                        onclick="deleteBank(`'.base64_encode($JSON_Sting).'`)"
                        title="Delete Bank"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('master-data::BankSecret.index', compact('data'));
    }

    public function getBankEndpoint(HttpRequest $req){
        $data = DB::SELECT("SELECT * FROM vw_BankEndpoint");

        if($req->ajax()){
            return Datatables::of($data)
            ->addColumn('action', function($data) {
                $JSON_Sting = json_encode($data);
                return '
                    <button
                        class="btn btn-icon"
                        onclick="editBankEndpoint(`'.base64_encode($JSON_Sting).'`)"
                        title="Edit Bank"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button
                        class="btn btn-icon"
                        onclick="deleteBankEndpoint(`'.base64_encode($JSON_Sting).'`)"
                        title="Delete Bank"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('master-data::BankEndpoint.index', compact('data'));
    }
}
