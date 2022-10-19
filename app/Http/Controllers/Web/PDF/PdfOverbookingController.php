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
        // $filter = base64_decode($request->filter);

        $table = $request->field;
        $parameters = $request->operator;
        $value = $request->value;
        // dd($value);

        // $overbooking = TrxOverBooking::getAll();
        // $overbooking = DB::select("SELECT * FROM vw_Overbooking_H where {$field} $operator '$value' ");

        // $overbooking = DB::table('vw_Overbooking_H')->where('$field', '$operator', '$value')->get();
        $overbooking = DB::select("SELECT * from vw_Overbooking_H where $table $parameters '$value'");

        $data = [
            'overbooking' => $overbooking
        ];

        // dd($overbooking);

        $pdf = PDF::loadView('Overbooking.overbookingPDF', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->download('Overbooking.pdf');
    }
}

