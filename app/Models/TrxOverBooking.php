<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
