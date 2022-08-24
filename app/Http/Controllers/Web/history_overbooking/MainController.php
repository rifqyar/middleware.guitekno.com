<?php

namespace Vanguard\Http\Controllers\Web\history_overbooking;

use Illuminate\Http\Request as Req;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;
use Yajra\Datatables\Datatables;
use Vanguard\Http\Controllers\Web\history_overbooking\DbController as Model;

class MainController extends Controller
{
    /**
     * Displays the application dashboard.
     *
     * @return Factory|View
     */
    public function index(Req $req)
    {
        $data = Model::getAll();
        if($req->ajax()){
            return Datatables::of($data)
            ->addColumn('status', function($data) {
                $bgColor = $data->statustext == 'Success' ? 'bg-success text-light' : ($data->statustext == 'Processed' ? 'bg-warning text-dark' : 'bg-danger text-light');
                $badge = '<span class="badge badge-pill '.$bgColor.' mr-2 text-light">'.$data->statustext.'</span>';
                return $badge;
            })
            ->addColumn('action', function($data){
                return '<button class="btn btn-icon" onclick="showDetail(`'.rtrim($data->tbk_id).'`)" data-toggle="tooltip" data-placement="top" title="View Detail Data">
                    <i class="fas fa-eye"></i>
                </button>';
            })->addColumn('recipient_amount', function($data){
                return Library::convertCurrency($data->tbk_recipient_amount);
            })->addColumn('sender_amount', function($data){
                return Library::convertCurrency($data->tbk_sender_amount);
            })->addColumn('amount', function($data){
                return Library::convertCurrency($data->tbk_amount);
            })
            ->rawColumns(['status', 'recipient_amount', 'sender_amount', 'amount'])
            ->make(true);
        }
        return view('history_overbooking.index');
    }
}
