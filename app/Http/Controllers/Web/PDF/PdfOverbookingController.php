<?php

namespace Vanguard\Http\Controllers\Web\PDF;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Web\history_overbooking\DbController as TrxOverBooking;
use Illuminate\Support\Facades\DB;
use PDF;

class PdfOverbookingController extends Controller
{
    public function generatePDF(Request $request)
    {
        // // $filter = isset($request->filter) ? $request->filter : '';
        // // $filter = base64_decode($request->filter);
        // // $overbooking = TrxOverBooking::getAll($filter);
        // $overbooking = TrxOverBooking::getAll();
        // // $overbooking = DB::SELECT("SELECT * FROM vw_Overbooking_H where $filter");

        // $data = [
        //     'overbooking' => $overbooking
        // ];

        // // dd($overbooking);

        // $pdf = PDF::loadView('Overbooking/overbookingPDF', $data);
        // $pdf->setPaper('A4', 'landscape');
        // $pdf->render();
        // return $pdf->stream('Overbooking.pdf');
        // return $pdf->download('Overbooking.pdf');

        $filter = base64_decode($request->filter);

        // $overbooking = TrxOverBooking::getAll();
        $overbooking = DB::select("SELECT * FROM vw_Overbooking_H where sender_bank_name = 'BANK JATENG' ");
        // $overbooking = DB::table('vw_Overbooking_H')->where($filter)->get();

        $data = [
            'overbooking' => $overbooking
        ];

        // dd($filter);

        $pdf = PDF::loadView('Overbooking.overbookingPDF', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->stream('Overbooking.pdf');

    }
}

