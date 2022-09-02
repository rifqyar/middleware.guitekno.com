<?php

namespace Vanguard\Http\Controllers\Web\LogCallback;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\LogCallback;
use Yajra\DataTables\DataTables;

class LogCallbackController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax() == true){
            $query = LogCallback::orderBy('lcb_last_updated', 'desc');
            if ($request->all()) {
                $data['param'] = $request->all();
            }
            if ($request->rst_id) {
                $query->where('rst_id', $request->rst_id);
            }
            if ($request->partner_id) {
                $query->where('lcb_partnerid', $request->partner_id);
            }
            if ($request->last_updated) {
                // dd($request->between, $request->last_updated);
                $query->whereDate('lcb_last_updated', $request->parameter, $request->last_updated);
            }

            // dd($request->all());

            $data = $query->get();
            return DataTables::of($data)
            ->addColumn('created', function($data) {
                return Helper::getFormatWib($data->lcb_created);
            })
            ->addColumn('last_update', function($data){
                return Helper::getFormatWib($data->lcb_last_updated);
            })
            ->addColumn('service', function($data){
                return $data->rst->rst_name;
            })
            ->rawColumns(['created', 'last_update', 'service'])
            ->make(true);
        }
        return view('log_callback.index');
    }
}
