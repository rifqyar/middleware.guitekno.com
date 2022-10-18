<?php

namespace Vanguard\Http\Controllers\Web\PDF;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Web\history_overbooking\DbController as TrxOverBooking;
use PDF;

class PdfOverbookingController extends Controller
{
    public function generatePDF(Request $request)
    {
        // dd($request->filter);
        if($request->filter){
            // $filter = $request->filter;
            $filter = isset($request->filter) ? $request->filter : '';
            $overbooking = TrxOverBooking::getAll($filter);
            
            return $overbooking;
        }
        else {
            $filter = isset($request->filter) ? $request->filter : '';
            $overbooking = TrxOverBooking::getAll();
            return $overbooking;
        }
        $data = [
            'overbooking' => $overbooking
        ];
        dd($data);

        $pdf = PDF::loadView('Overbooking/overbookingPDF', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Overbooking.pdf');
        // return $pdf->download('Overbooking.pdf');

    }
}

