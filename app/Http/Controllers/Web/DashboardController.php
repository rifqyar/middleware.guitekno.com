<?php

namespace Vanguard\Http\Controllers\Web;

use App\Models\TrxOverBooking;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;

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

        $data['countBank'] = count(DB::SELECT("SELECT * from dat_bank_secret x, ref_bank y where x.code_bank=y.bank_id"));
        $data['countTransaksi'] = DB::SELECT("SELECT COUNT(1) total from trx_overbooking where ras_id='100'")[0]->total;

        $rawDataJmlTransaksi = DB::SELECT("SELECT SUM(tbk_amount) as jumlah from vw_Overbooking_H")[0]->jumlah;
        $data['jumlahTransaksi'] = Library::convertCurrency((int)$rawDataJmlTransaksi);
        $data['mostActiveBank'] = DB::SELECT("SELECT * FROM vw_MostActiveBank")[0];

        $bank = DB::SELECT("SELECT xx.tbk_sender_bank_id, zz.bank_name from (select distinct(tbk_sender_bank_id) from trx_overbooking) xx, ref_bank zz where zz.bank_id = xx.tbk_sender_bank_id");
        foreach ($bank as $valueT) {
            $valueT->data = DB::SELECT(
                "WITH tx as (select to_date(trim(to_char(tbk_created, 'YYYY-MM-DD')), 'YYYY-MM-DD') tanggal, tbk_amount, tbk_sender_bank_id from trx_overbooking where tbk_sender_bank_id = '{$valueT->tbk_sender_bank_id}')
                select yy.tanggal, vv.tbk_sender_bank_id bank_code, (select sum(tbk_amount) from tx where tanggal = yy.tanggal) total, (select count(1) from tx where tanggal = yy.tanggal) value from (select distinct(tanggal) from tx) yy, (select distinct(tbk_sender_bank_id) from tx) vv order by yy.tanggal
            "
            );
        }

        $date = DB::select("select to_date(trim(to_char(tbk_created, 'YYYY-MM-DD')), 'YYYY-MM-DD') tanggal from trx_overbooking
        group by to_date(trim(to_char(tbk_created, 'YYYY-MM-DD')), 'YYYY-MM-DD')");
        foreach ($date as $value) {
            $value->tanggal =  substr($value->tanggal, 0, 10);
            $value->data = DB::select("select TBK_SENDER_BANK_ID,sum(TBK_AMOUNT) total from trx_overbooking where TBK_CREATED like '%{$value->tanggal}%'
            group by TBK_SENDER_BANK_ID");
        }

        // $te = DB::SELECT(
        //     "WITH tx as (select to_date(trim(to_char(tbk_created, 'YYYY-MM-DD')), 'YYYY-MM-DD') tanggal, tbk_amount, tbk_sender_bank_id, ref_bank.bank_name from trx_overbooking inner join ref_bank on ref_bank.bank_id=trx_overbooking.tbk_sender_bank_id)
        //     select yy.tanggal, vv.tbk_sender_bank_id bank_code, zz.bank_name bank_name, (select sum(tbk_amount) from tx where tanggal = yy.tanggal) total, (select count(1) from tx where tanggal = yy.tanggal) value
        //     from (select distinct(tanggal) from tx) yy, (select distinct(tbk_sender_bank_id) from tx) vv, (select distinct(bank_name) from tx) zz order by yy.tanggal
        // ");

        // $data['']

        // dd($date);
        $test = TrxOverBooking::get();
        echo $test->senderBank->bank_name;
        die();
        $status = DB::SELECT("WITH st as (select CASE ras_id WHEN '000' THEN 'Success' WHEN '100' THEN 'Process' ELSE 'Failed' END AS name from trx_overbooking)
        SELECT x.name keterangan, (select count(1) from st where name=x.name) value from (select distinct(name) from st) x order by x.name");

        $tableTrans = DB::SELECT("SELECT y.bank_name bank_pengirim, x.tbk_created tanggal, x.tbk_amount jumlah, x.tbk_notes keterangan,
                            CASE x.tbk_type
                            WHEN 'LS|GAJI' THEN 'Gaji'
                            ELSE 'Non Gaji' END as tipe,

                            CASE x.ras_id
                            WHEN '000' THEN 'Success'
                            WHEN '100' THEN 'Process'
                            ELSE 'Failed' END as status
                        from trx_overbooking x, ref_bank y where x.tbk_sender_bank_id=y.bank_id");

        $data['status'] = $status;

        $data['transaksi'] = $date;

        $data['tableTrans'] = $tableTrans;

        $data['jenis'] = DB::SELECT("SELECT statustext type, count(statustext) amount from vw_overbooking_h group by statustext");

        $data['bank'] = DB::SELECT("SELECT vw_refbank.bank_name name, vw_refbank.bank_id, count(vw_overbooking_h.tbk_id) value from vw_overbooking_h inner join vw_refbank on vw_refbank.bank_id = vw_overbooking_h.tbk_sender_bank_id group by vw_refbank.bank_name, vw_overbooking_h.tbk_sender_bank_id, vw_refbank.bank_id");

        $testBank =  $data['bank'];
        $getIndexBank = function ($bank_id) use ($testBank) {
            $key = array_search($bank_id, $testBank);
            return $key;
        };

        // dd($data['tableTrans']);

        return view('dashboard.index', compact('data', 'getIndexBank'));
    }
    // public function getPengajuanAllUser($tglAwal, $tglAkhir)
    // {
    //     $result = [];
    //     $arrData = [];
    //     $month = $tglAwal;
    //     while ($month < $tglAkhir) {
    //         //echo date('F Y', $month), PHP_EOL;
    //         $awalBulan = date_format($month, "Ymd");
    //         $arrItem = [];
    //         $arrItem["date"] = $awalBulan;
    //         $q = $this->db->query("SELECT x.*, (select count(1) from dat_alur_dokumen where user_id = x.userid and trunc(dad_tgl_rekam) between to_date('$awalBulan', 'YYYYMMDD') and last_day(to_date('$awalBulan', 'YYYYMMDD')) and rsd_id = '1') jml
    //             from (select nm_ppat || ' - PPAT' nama, user_id userid from dat_ppat union select v.nm_pegawai || ' - User' nama, v.user_id userid from dat_pegawai v, dat_user y where v.user_id = y.user_id and y.usertype_id in ('2', '3')) x")->result();
    //         foreach ($q as $r) {
    //             $key = "user" . $r->USERID;
    //             $arrItem[$key] = $r->JML;
    //         }
    //         array_push($arrData, $arrItem);
    //         $month = strtotime("+1 month", $month);
    //     }
    //     $arrKeys = [];
    //     $q = $this->db->query("SELECT nm_ppat || ' - PPAT' nama, user_id userid from dat_ppat union select v.nm_pegawai || ' - User' nama, v.user_id userid from dat_pegawai v, dat_user y
    //         where v.user_id = y.user_id and y.usertype_id in ('2', '3')")->result();
    //     foreach ($q as $r) {
    //         $key = "user" . $r->USERID;
    //         array_push($arrKeys, array(
    //             "key" => $key,
    //             "name" => $r->NAMA
    //         ));
    //     }
    //     $result["Data"] = $arrData;
    //     $result["Keys"] = $arrKeys;
    //     return $result;
    // }
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
