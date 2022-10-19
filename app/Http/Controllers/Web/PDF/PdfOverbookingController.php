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

        // $overbooking = TrxOverBooking::getAll();
        // $overbooking = DB::select("SELECT * FROM vw_Overbooking_H where {$field} $operator '$value' ");

        if($request->ajax() == true)
        {
            $overbooking = DB::table('vw_overbooking_h')
            ->where($request->field, $request->operator, $request->value)->orderBy('tbk_id', 'asc')->get();

            $data = [
                'overbooking' => $overbooking
            ];

            // dd($data);

            $pdf = PDF::loadView('Overbooking.overbookingPDF', $data);
            $pdf->setPaper('A4', 'landscape');
            $pdf->render();
            return $pdf->stream('Overbooking.pdf');
        }
    }
}

