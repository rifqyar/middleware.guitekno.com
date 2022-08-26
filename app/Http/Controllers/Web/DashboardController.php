<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;
use Vanguard\Models\TrxOverBooking;
use Vanguard\Models\DatBankSecret;
use Vanguard\Models\LogCallback;

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
        $data['countTransaksi'] = TrxOverBooking::countTransaksi();

        $rawDataJmlTransaksi = TrxOverBooking::jmlTransaksi();
        $data['jumlahTransaksi'] = Library::convertCurrency((int)$rawDataJmlTransaksi);
        $data['mostActiveBank'] = TrxOverBooking::mostActiveBank();

        $data['trxOverbooking'] = TrxOverBooking::where('ras_id', '100')
            ->limit(10)
            ->orderBy('tbk_created', 'desc')
            ->get();
        $data['logCallback'] = LogCallback::orderBy('LCB_LAST_UPDATED', 'desc')
            ->limit(10)->get();
        // dd($data['logCallback']);

        $data['status'] = TrxOverBooking::status();

        $data['transaksi'] = TrxOverBooking::trxChart();

        $data['jenis'] = TrxOverBooking::typeTrx();

        $data['bank'] = TrxOverBooking::countTrxBank();

        // dd($data['countBank']);

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
}
