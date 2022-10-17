<?php

namespace Vanguard\Http\Controllers\Web\Overbooking;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Vanguard\Models\DatBankSecret;
use Vanguard\Models\TrxOverBooking;

class OverbookingController extends Controller
{
    public function index()
    {
        $data['banks'] = DatBankSecret::get();
        $data['types'] = TrxOverBooking::select('tbk_type')->groupBy('tbk_type')->get();
        $data['status'] = TrxOverBooking::select('ras_id')->with('ras')->groupBy('ras_id')->get();
        return view('Overbooking.indexnew', $data);
    }

    public function data(Request $request)
    {
        $overBooking = TrxOverBooking::with('senderBank')
            ->with('receiverBank')
            ->with('ras');
        if ($request->sender_bank) $overBooking->where('tbk_sender_bank_id', $request->sender_bank);

        if ($request->recipient_bank) $overBooking->where('tbk_recipient_bank_id', $request->recipient_bank);

        if ($request->type) $overBooking->where('tbk_type', $request->type);

        if ($request->ras_id) $overBooking->where('ras_id', $request->ras_id);


        return DataTables::of($overBooking)->addIndexColumn()
            ->editColumn('tbk_amount', function ($data) {
                return Helper::getRupiah($data->tbk_amount);
            })
            ->editColumn('tbk_execution_time', function ($data) {
                return Helper::getFormatWib($data->tbk_execution_time);
            })
            ->make(true);
    }
}
