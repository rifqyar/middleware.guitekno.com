<?php

namespace Vanguard\Http\Controllers\Web\LogCallback;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\LogCallback;

class LogCallbackController extends Controller
{
    public function index(Request $request)
    {
        $query = LogCallback::orderBy('LCB_LAST_UPDATED', 'desc');

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
        if ($request->all()) {
            $data['param'] = $request->all();
        }

        $data['datas'] = $query->paginate(10)->withQueryString();
        return view('log_callback.index', $data);
    }
}
