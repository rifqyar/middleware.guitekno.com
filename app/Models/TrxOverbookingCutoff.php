<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxOverbookingCutoff extends Model
{
    use HasFactory;
    protected $table = 'trx_overbooking_cutoff';
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
}
