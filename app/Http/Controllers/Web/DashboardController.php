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
use Carbon\Carbon;
use DateInterval;
use DateTime;
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

        $data['prop'] = Province::getConnectedProp();
        $data['countBank'] = count($data['prop']);

        $dateTime = new DateTime();
        $data['thisMonth'] = $dateTime->format('F');
        $dateInterval = new DateInterval('P1M');
        $dateInterval->invert = true;
        $dateTime->add($dateInterval);
        $data['lastMonth'] = $dateTime->format('F');

        $dateTime = new DateTime();
        $data['thisYear'] = $dateTime->format('Y');
        $dateInterval = new DateInterval('P1Y');
        $dateInterval->invert = true;
        $dateTime->add($dateInterval);
        $data['lastYear'] = $dateTime->format('Y');

        $data['countTransaksi'] = TrxOverBooking::countTransaksi();
        $data['countTransaksiToday'] = TrxOverBooking::countTransaksi('today');
        $data['countTransaksiYesterday'] = TrxOverBooking::countTransaksi('yesterday');
        $data['percentageCountTrx'] = $data['countTransaksiYesterday'] != 0 ? round(((int)$data['countTransaksiToday'] - (int)$data['countTransaksiYesterday']) / (int)$data['countTransaksiYesterday'] * 100, 2) : (int)$data['countTransaksiToday'];

        $rawDataJmlTransaksi = TrxOverBooking::jmlTransaksi();
        // dd($data['jumlahTransaksiToday']);
        $rawDataJmlTransaksiToday = TrxOverBooking::jmlTransaksi('today');
        $rawDataJmlTransaksiYesterday = TrxOverBooking::jmlTransaksi('yesterday');
        $data['jumlahTransaksi'] = Library::convertCurrency((int)$rawDataJmlTransaksi);
        $data['jumlahTransaksiToday'] = Library::convertCurrency((int)$rawDataJmlTransaksiToday);
        $data['jumlahTransaksiYesterday'] = Library::convertCurrency((int)$rawDataJmlTransaksiYesterday);
        $data['percentageTrxToday'] = (int)$rawDataJmlTransaksiYesterday != 0 ? round(((int)$rawDataJmlTransaksiToday - (int)$rawDataJmlTransaksiYesterday) / (int)$rawDataJmlTransaksiYesterday * 100, 2) : (int)$rawDataJmlTransaksiToday;

        $data['dati2'] = RefDati::getConnectedDati();
        $data['countDati2'] = count($data['dati2']);

        $data['logCallback'] = LogCallback::orderBy('lcb_last_updated', 'desc')
            ->limit(10)->get();
        // dd($data['logCallback']);

        $data['status'] = TrxOverBooking::status();

        $data['transaksi'] = TrxOverBooking::trxChart();

        $data['jenis'] = TrxOverBooking::typeTrx();

        $data['bank'] = TrxOverBooking::countTrxBank();

        $data['lastMontTrans'] = TrxOverBooking::lastMonthTrx();
        $data['thisMontTrans'] = TrxOverBooking::thisMonthTrx();
        $data['percentageMonth'] = (int)$data['lastMontTrans'] != 0 ? round(((int)$data['thisMontTrans'] - (int)$data['lastMontTrans']) / (int)$data['lastMontTrans'] * 100, 2) : (int)$data['thisMontTrans'];

        $data['lastYearTrans'] = TrxOverBooking::lastYearTrx();
        $data['thisYearTrans'] = TrxOverBooking::thisYearTrx();
        $data['percentageYear'] = (int)$data['lastYearTrans'] != 0 ? round(((int)$data['thisYearTrans'] - (int)$data['lastYearTrans']) / (int)$data['lastYearTrans'] * 100, 2) : (int)$data['thisYearTrans'];

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
