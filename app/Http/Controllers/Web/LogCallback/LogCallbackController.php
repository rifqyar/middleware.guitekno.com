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
        $data['datas'] = $query->paginate(5);
        return view('log_callback.index', $data);
    }
}
