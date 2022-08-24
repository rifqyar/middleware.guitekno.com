<?php

namespace Vanguard\Http\Controllers\Web\Overbooking;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class OverbookingController extends Controller
{
    public function index()
    {
        $query = DB::SELECT("SELECT y.bank_name bank_pengirim, x.tbk_created tanggal, x.tbk_amount jumlah, x.tbk_notes keterangan, 
                            CASE x.tbk_type
                            WHEN 'LS|GAJI' THEN 'Gaji'
                            ELSE 'Non Gaji' END as tipe,
                            
                            CASE x.ras_id
                            WHEN '000' THEN 'Success'
                            WHEN '100' THEN 'Process'
                            ELSE 'Failed' END as status
                        from trx_overbooking x, ref_bank y where x.tbk_sender_bank_id=y.bank_id");
        
        $data['trans'] = $query;

        // dd($query);

        return view('Overbooking.index', compact('data'));
    }
}
