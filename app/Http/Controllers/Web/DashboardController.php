<?php

namespace Vanguard\Http\Controllers\Web;

use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;
use Vanguard\Models\TrxOverBooking;
use Vanguard\Models\DatBankSecret;
use Vanguard\Models\LogCallback;
use Yajra\Datatables\Datatables;
use App\Helpers\Helper;
use Vanguard\Models\Province;
use Vanguard\Models\RefDati;

class DashboardController extends Controller
{
    /**
     * Displays the application dashboard.
     *
     * @return Factory|View
     */
    public function index()
    {
        if (session()->has('verified')) {
            session()->flash('success', __('E-Mail verified successfully.'));
        }

        $data['countBank'] = DatBankSecret::countBank();
        // dd($data['countBank']);
        $data['countTransaksi'] = TrxOverBooking::countTransaksi();
        $data['countTransaksiToday'] = TrxOverBooking::countTransaksi(true);
        $rawDataJmlTransaksi = TrxOverBooking::jmlTransaksi();
        $rawDataJmlTransaksiToday = TrxOverBooking::jmlTransaksi(true);
        $data['jumlahTransaksi'] = Library::convertCurrency((int)$rawDataJmlTransaksi);
        $data['jumlahTransaksiToday'] = Library::convertCurrency((int)$rawDataJmlTransaksiToday);
        $data['countDati2'] = TrxOverBooking::CountDati2();
        // var_dump([
        //     'jumlahTransaksi' => $data['jumlahTransaksi'],
        //     'jumlahTransaksiToday' => $data['jumlahTransaksiToday'],
        // ]);
        // die();

        $data['logCallback'] = LogCallback::orderBy('lcb_last_updated', 'desc')
            ->limit(10)->get();
        // dd($data['logCallback']);

        $data['status'] = TrxOverBooking::status();

        $data['transaksi'] = TrxOverBooking::trxChart();

        $data['jenis'] = TrxOverBooking::typeTrx();

        $data['bank'] = TrxOverBooking::countTrxBank();

        $data['lastMontTrans'] = TrxOverBooking::lastMonthTrx();
        $data['thisMontTrans'] = TrxOverBooking::thisMonthTrx();
        $data['percentageMonth'] = (int)$data['lastMontTrans'] != 0 ? round(((int)$data['thisMontTrans']-(int)$data['lastMontTrans'])/(int)$data['lastMontTrans'] *100,2) : 100;

        $data['lastYearTrans'] = TrxOverBooking::lastYearTrx();
        $data['thisYearTrans'] = TrxOverBooking::thisYearTrx();
        $data['percentageYear'] = (int)$data['lastYearTrans'] != 0 ? round(((int)$data['thisYearTrans']-(int)$data['lastYearTrans'])/(int)$data['lastYearTrans'] *100 ,2) : 100;

        return view('dashboard.index', compact('data'));
    }

    public function testing_view()
    {
        return view('testing');
    }
    public function testing()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://jatimva.bankjatim.co.id/MC/Qris/Dynamic",
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"merchantPan\": \"9360011400000022721\",\n    \"hashcodeKey\": \"49add9cf214057a5b8021973effa9a40748f0c68489fc556a2550acc4dd09f45\",\n    \"billNumber\": \"2160321090607031\",\n    \"purposetrx\": \"PENGUJIAN\",\n    \"storelabel\": \"DISHUB KEPANJEN\",\n    \"customerlabel\": \"PUBLIC\",\n    \"terminalUser\": \"U060001\",\n    \"expiredDate\": \"2021-03-17 09:08:21\",\n    \"amount\": \"60000\"\n}",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error sda#:" . $err;
        } else {
            echo $response;
        }
    }
    function logTrx()
    {
        $log = TrxOverBooking::with('senderBank')
            ->with('receiverBank')
            ->with('ras')
            ->with('logCallback');
        if (env('APP_ENV') == 'production') {
            $log->where('state', '01');
        }
        return DataTables::of($log)->addIndexColumn()
            ->editColumn('tbk_amount', function ($data) {
                return Helper::getRupiah($data->tbk_amount);
            })
            ->addColumn('Actions', function ($data) {
                if ($data->request_data) {
                    $res = base64_encode($data->request_data);
                    return '<button type="button" class="btn btn-primary btn-sm" onclick="openDetailTransaksi(`' . $res . '`)">Detail</button>';
                } else {
                    return '-';
                }
            })
            ->editColumn('ras_id', function ($data) {
                // dd($data);
                if (in_array($data->ras_id,  $this->status['code'])) {
                    return $this->status['message'][$data->ras_id];
                } else {
                    return '<span class="badge badge-pill bg-danger text-white">Failed</span>';
                }
            })
            ->rawColumns(['Callback', 'Actions', 'ras_id'])
            ->make(true);
    }
    function awaitLogTrx()
    {
        $log = TrxOverBooking::where('ras_id', '100')
            ->limit(10)
            ->orderBy('tbk_created', 'desc')
            ->get();

        if (env('APP_ENV') == 'production') {
            $log->where('state', '01');
        } else {
            $log->where('state', '!=', '01');
        }
        return DataTables::of($log)->addIndexColumn()
            ->editColumn('tbk_amount', function ($data) {
                return Helper::getRupiah($data->tbk_amount);
            })
            ->addColumn('Actions', function ($data) {
                if ($data->request_data) {
                    $res = base64_encode($data->request_data);
                    return '<button type="button" class="btn btn-primary btn-sm" onclick="openDetailTransaksi(`' . $res . '`)">Detail</button>';
                } else {
                    return '-';
                }
            })
            ->editColumn('ras_id', function ($data) {
                // dd($data);
                if (in_array($data->ras_id,  $this->status['code'])) {
                    return $this->status['message'][$data->ras_id];
                } else {
                    return '<span class="badge badge-pill bg-danger text-white">Failed</span>';
                }
            })
            ->rawColumns(['Callback', 'Actions', 'ras_id'])
            ->make(true);
    }
}
