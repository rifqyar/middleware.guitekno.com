<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function chartTxStatus(Request $request)
    {
        return view('chart.tx-status', ['data' => $request->data]);
    }

    public function chartTxBank(Request $request)
    {
        return view('chart.tx-bank', ['data' => $request->data]);
    }

    public function chartTxType(Request $request)
    {
        // dd($request->data);
        return view('chart.tx-type', ['data' => $request->data]);
    }

    public function chartTxDaily(Request $request)
    {
        return view('chart.tx-daily', ['bank' => $request->bank, 'transaksi' => $request->transaksi]);
    }
}
