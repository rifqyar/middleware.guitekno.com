<?php

namespace Vanguard\Http\Controllers\Web\history_overbooking;

use Illuminate\Http\Request as Req;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;
use Yajra\Datatables\Datatables;
use Vanguard\Http\Controllers\Web\history_overbooking\DbController as Model;

class MainController extends Controller
{
    public function index(Req $req)
    {
        if($req->ajax()){
            $filter = isset($req->filter) ? $req->filter : '';
            $data = Model::getAll($filter);

            return Datatables::of($data)
            ->addColumn('status', function($data) {
                $bgColor = $data->status_text == 'Success' ? 'bg-success text-light' : ($data->status_text == 'Processed' ? 'bg-warning text-dark' : 'bg-danger text-light');
                $badge = '<span class="badge badge-pill '.$bgColor.' mr-2 text-light">'.$data->status_text.'</span>';
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

    public function columnHeader(){
        $data = Model::getColumnName();

        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'data' => $data
        ],200);
    }

    public function renderFilterForm(){
        $role = auth()->user()->present()->role_id;
        switch ($role) {
            case '1':
            case '3':
                $excludedColumn = [1, 26];
                break;

            case '4':
            case '5':
                $excludedColumn = [1, 26, 11, 14, 27, 28, 30, 31];
                break;
            default:
                $excludedColumn = [1, 26];
                break;
        }
        $column = Model::getColumnName($excludedColumn);
        $blade = view('history_overbooking.component.formFilter', compact('column'))->render();
        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'html' => $blade
        ], 200);
    }

    public function columnData($column_name){
        $column = base64_decode($column_name);
        $data = Model::getColumnData($column);

        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'data' => $data
        ], 200);
    }
}
