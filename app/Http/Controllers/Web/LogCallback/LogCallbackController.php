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

        $data['datas'] = $query->paginate(5)->withQueryString();
        return view('log_callback.index', $data);
    }
}
