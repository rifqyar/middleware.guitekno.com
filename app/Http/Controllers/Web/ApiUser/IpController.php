<?php

namespace Vanguard\Http\Controllers\Web\ApiUser;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\IpWhiteList;
use Vanguard\Models\RefBank;

class IpController extends Controller
{
    public function getIpByDbs($bank_code)
    {
        $data['datas'] = IpWhiteList::where('bank_id', $bank_code)->get();
        $data['bank'] = RefBank::where('bank_id', $bank_code)->first();
        return view('api_user.ip_index', $data);
    }

    public function deleteDatIp($id)
    {
        IpWhiteList::where('diw_index', $id)->delete();

        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function saveIp(Request $request)
    {
        IpWhiteList::create([
            'bank_id' => $request->bank_id,
            'diw_address' => $request->ip_address
        ]);

        return response()->json([
            'message' => 'Success'
        ]);
    }
}
