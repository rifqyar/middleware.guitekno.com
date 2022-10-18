<?php

namespace Vanguard\Http\Controllers\Web\PDF;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Web\history_overbooking\DbController as TrxOverBooking;
use PDF;

class PdfOverbookingController extends Controller
{
    public function generatePDF(Request $req)
    {
        $overbooking = TrxOverBooking::getAll();

        $data = [
            'overbooking' => $overbooking
        ];

        $print_date = date('dmY');

        $pdf = PDF::loadView('Overbooking/overbookingPDF', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->stream('Overbooking.pdf');
        // return $pdf->download('Overbooking.pdf');

    }
}

