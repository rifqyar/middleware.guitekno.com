<?php

namespace Vanguard\Http\Controllers\Web\ApiUser;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\DatApiUser;
use Vanguard\Models\RefBank;
use Yajra\DataTables\Facades\DataTables;

class ApiUserController extends Controller
{
    public function index()
    {
        return view('api_user.index');
    }

    public function post(Request $request)
    {
        $data = DatApiUser::select('*');
        return DataTables::eloquent($data)->addIndexColumn()
            ->editColumn('bank_id', function ($row) {
                return $row->bank->bank_name;
            })
            ->addColumn('action', function ($row) {
                $btn = "<a href='javascript:getIp(`{$row->bank_id}`)' class='btn btn-primary btn-sm'>View Ip List</a>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function form()
    {
        $apiUser = DatApiUser::get()->pluck('bank_id')->toArray();
        $data['banks'] = RefBank::whereNotIn('bank_id', $apiUser)->get();
        return view('api_user.add', $data);
    }

    public function saveAdd(Request $request)
    {
        DatApiUser::create([
            'bank_id' => $request->bank_id,
            'dau_username' => $request->username,
            'dau_password' => bcrypt($request->password)
        ]);
        return view('api_user.index');
    }
}
