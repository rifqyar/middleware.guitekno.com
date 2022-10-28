<?php

namespace Vanguard\Models;

use App\Helpers\Helper;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TrxOverBooking extends Model
{
    use HasFactory;
    protected $table = 'trx_overbooking';
    public $incrementing = false;
    protected $fillable = [
        'TBK_ID', 'TBK_CREATED', 'TBK_CREATE_BY', 'TBK_LAST_UPDATED', 'TBK_;AST_UPDATE_BY', 'TBK_NOTES', 'TBK_TX_ID', 'TBK_TX_ID', 'TBK_PARTNERID',
        'TBK_AMOUNT', 'TBK_USERID', 'TBK_SENDER_BANK_ID', 'TBK_SENDER_ACCOUNT', 'TBK_SENDER_AMOUNT', 'TBK_RECIPIENT_BANK_ID', 'TBK_RECIPIENT_ACCOUNT',
        'TBK_RECIPIENT_AMOUNT', 'TBK_INTERNA_STATUS', 'TBK_SP2D_NO', 'TBK_SP2D_DESC', 'TBK_EXCETUIN_TIME', 'TBK_BILLING_ID', 'TBK_NTPN', 'TBK_NTPN_DATE',
        'TBK_NTB', 'TBK_TYPE', 'RAS_ID', 'PROP_ID', 'DATI2_ID', 'REQUEST_DATA', 'TBK_RECIPIENT_NAME', 'TBK_RECIPIENT_NIK', 'TBK_RECIPIENT_ADDRESS', 'STATE'
    ];

    public function senderBank()
    {
        return $this->hasOne(RefBank::class, 'bank_id', 'tbk_sender_bank_id');
    }

    public function receiverBank()
    {
        return $this->hasOne(RefBank::class, 'bank_id', 'tbk_recipient_bank_id');
    }

    public function ras()
    {
        return $this->hasOne(RefApiStatus::class, 'ras_id', 'ras_id');
    }

    public function logCallback()
    {
        return $this->hasOne(LogCallback::class, 'lcb_partnerid', 'tbk_partnerid')->orderBy('lcb_created', 'desc');
    }

    public static function typeTrx()
    {
        $where = Helper::getRoleFilter('query');
        $where = $where != '' ? "WHERE $where" : '';

        return DB::SELECT("SELECT
                        CASE tbk_type
                        WHEN 'LS|NONGAJI' THEN 'Non Gaji'
                        ELSE 'Gaji' END as type,
                    count(tbk_type) as amount from trx_overbooking $where group by tbk_type");
    }

    public static function trxChart()
    {
        $where = Helper::getRoleFilter('query');
        $where2 = $where != '' ? "WHERE $where" : '';
        $where = $where != '' ? "and ($where)" : '';

        $query = DB::SELECT("SELECT to_date(trim(to_char(tbk_created, 'YYYY-MM-DD')), 'YYYY-MM-DD') as tanggal from trx_overbooking $where2 group by to_date(trim(to_char(tbk_created, 'YYYY-MM-DD')), 'YYYY-MM-DD') ORDER BY tanggal DESC LIMIT 10");
        $bank = [];
        foreach ($query as $value) {
            $value->tanggal =  substr($value->tanggal, 0, 10);
            $value->data = DB::select("SELECT ref_bank.bank_name, sum(tbk_amount) as total from trx_overbooking join ref_bank on(trx_overbooking.tbk_sender_bank_id=ref_bank.bank_id) where date(tbk_created) = '{$value->tanggal}' and ras_id in('000', '001', '002') $where group by ref_bank.bank_name");
            if (!empty($value->data)) {
                foreach ($value->data as $bankName) {
                    $bank[] = $bankName->bank_name;
                }
            }
        }
        if (!empty($bank)) {
            $bank = array_unique($bank);
        }
        $result['trx'] = $query;
        $result['bank'] = $bank;
        // dd($result);
        return $result;
    }

    public static function status()
    {
        $where = Helper::getRoleFilter('query');
        $where = $where != '' ? "WHERE $where" : '';

        return DB::SELECT("WITH st as (select CASE ras_id WHEN '000' THEN 'Success' WHEN '100' THEN 'Process' ELSE 'Failed' END AS name from trx_overbooking $where)
        SELECT x.name as keterangan, (select count(1) from st where name=x.name) as value from (select distinct(name) from st) as x order by x.name");
    }

    public static function countTransaksi()
    {
        $where = Helper::getRoleFilter('query');
        $where = $where != '' ? "WHERE $where" : '';
        $query = "SELECT COUNT(1) as total from trx_overbooking $where";
        return DB::SELECT($query)[0]->total;
    }

    public static function jmlTransaksi()
    {
        $where = Helper::getRoleFilter('query');
        $where = $where != '' ? "AND ($where)" : '';
        return DB::SELECT("SELECT SUM(tbk_amount) as jumlah from vw_Overbooking_H where ras_id in ('000', '001', '002') $where")[0]->jumlah;
    }

    public static function CountDati2()
    {
        return DB::SELECT("SELECT count(1) as total_dati from (
            select distinct dati2_id
            from trx_overbooking to2
            where dati2_id is not null
                and dati2_id not like '%|'
                and dati2_id not like '|%'
            group by dati2_id
        ) as data")[0];
    }

    public static function countTrxBank()
    {
        $where = Helper::getRoleFilter('query');
        $where = $where != '' ? "WHERE $where" : '';

        return DB::SELECT("SELECT sender_bank_name as name, tbk_sender_bank_id as bank_id, count(tbk_id) as value from vw_overbooking_h $where group by sender_bank_name, tbk_sender_bank_id");
    }
}
