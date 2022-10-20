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
    public function generatePDF($filter)
    {
        // dd($filter);
        $where = base64_decode($filter);

        if($filter == 'all')
        {
            $overbooking = DB::select("SELECT * FROM vw_overbooking_h");
        }
        else{
            $overbooking = DB::select("SELECT * FROM vw_overbooking_h where $where");
        }

        $data = [
            'overbooking' => $overbooking
        ];
        // dd($data);

        $pdf = PDF::loadView('Overbooking.overbookingPDF', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->stream('Overbooking.pdf');

        // return view('Overbooking.overbookingPDF', $data);
    }

    public function test(Request $request)
    {
        $data = $request->all();

        dd($data);
    }
}

