<?php

namespace Vanguard\Models;

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
        'TBK_NTB', 'TBK_TYPE', 'RAS_ID'
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

    public static function typeTrx()
    {
        return DB::SELECT("SELECT
                        CASE tbk_type
                        WHEN 'LS|NONGAJI' THEN 'Non Gaji'
                        ELSE 'Gaji' END as type,
                    count(tbk_type) as amount from trx_overbooking group by tbk_type");
    }

    public static function trxChart()
    {
        $query = DB::select("select to_date(trim(to_char(tbk_created, 'YYYY-MM-DD')), 'YYYY-MM-DD') as tanggal from trx_overbooking
        group by to_date(trim(to_char(tbk_created, 'YYYY-MM-DD')), 'YYYY-MM-DD')");

        foreach ($query as $value) {
            $value->tanggal =  substr($value->tanggal, 0, 10);
            $value->data = DB::select("select tbk_sender_bank_id,sum(tbk_amount) as total from trx_overbooking where tbk_create_by like '%{$value->tanggal}%'
            group by tbk_sender_bank_id");
        }

        return $query;
    }

    public static function status()
    {
        return DB::SELECT("WITH st as (select CASE ras_id WHEN '000' THEN 'Success' WHEN '100' THEN 'Process' ELSE 'Failed' END AS name from trx_overbooking)
        SELECT x.name keterangan, (select count(1) from st where name=x.name) as value from (select distinct(name) from st) x order by x.name");
    }

    public static function countTransaksi()
    {
        return DB::SELECT("SELECT COUNT(1) total from trx_overbooking where ras_id='100'")[0]->total;
    }

    public static function jmlTransaksi()
    {
        return DB::SELECT("SELECT SUM(tbk_amount) as jumlah from vw_Overbooking_H")[0]->jumlah;
    }

    public static function mostActiveBank()
    {
        $data = DB::SELECT("SELECT * FROM vw_MostActiveBank");
        return count($data) > 0 ? $data[0] : '-';
    }

    public static function countTrxBank()
    {
        return DB::SELECT("SELECT ref_bank.bank_name as name, ref_bank.bank_id, count(vw_overbooking_h.tbk_id) as value from vw_overbooking_h inner join ref_bank on ref_bank.bank_id = vw_overbooking_h.tbk_sender_bank_id group by ref_bank.bank_name, vw_overbooking_h.tbk_sender_bank_id, ref_bank.bank_id");
    }
}
