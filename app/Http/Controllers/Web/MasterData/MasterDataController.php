<?php

namespace Vanguard\Http\Controllers\Web\MasterData;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Request;
use Vanguard\Models\RefApiStatus;

class MasterDataController extends Controller
{
    /**
     * Displays the plugin index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('MasterData.index');
    }

    public function getRefBank(HttpRequest $req){
        if($req->ajax()){
            $data = DB::SELECT("SELECT * FROM vw_RefBank");

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
            ->addColumn('status', function($data){
                $bgColor = $data->rrs_id == 01 ? 'bg-success text-light' : 'bg-warning text-dark';
                $badge = '<span class="badge badge-pill '.$bgColor.' mr-2 text-light">'.$data->rrs_desc.'</span>';
                return $badge;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
        }

        return view('MasterData.bank.index');
    }

    public function getBankSecret(HttpRequest $req){
        if($req->ajax()){
            $data = DB::SELECT("SELECT * FROM vw_BankSecret");

            return Datatables::of($data)
            ->addColumn('action', function($data) {
                $JSON_Sting = json_encode($data);
                return '
                <div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                    <button
                        class="btn btn-icon"
                        onclick="viewDetail(`'.base64_encode($JSON_Sting).'`)"
                        title="View Detail"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-eye"></i>
                    </button>
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
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('MasterData.BankSecret.index');
    }

    public function getBankEndpoint(HttpRequest $req){

        if($req->ajax()){
            $data = DB::SELECT("SELECT * FROM vw_BankEndpoint");

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
            ->addColumn('status', function($data){
                $bgColor = $data->rrs_id == 01 ? 'bg-success text-light' : 'bg-warning text-dark';
                $badge = '<span class="badge badge-pill '.$bgColor.' mr-2 text-light">'.$data->rrs_desc.'</span>';
                return $badge;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
        }

        return view('MasterData.BankEndpoint.index');
    }

    public function getApiStatus(HttpRequest $req){
        if ($req->ajax()){
            $data = RefApiStatus::all();
            
            return Datatables::of($data)
            ->addColumn('action', function($data) {
                $JSON_Sting = json_encode($data);
                return '
                    <button
                        class="btn btn-icon"
                        onclick="editApiStatus(`'.base64_encode($JSON_Sting).'`)"
                        title="Edit Bank"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button
                        class="btn btn-icon"
                        onclick="deleteApiStatus(`'.base64_encode($JSON_Sting).'`)"
                        title="Delete Bank"
                        data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('MasterData.ApiStatus.index');
    }
}
