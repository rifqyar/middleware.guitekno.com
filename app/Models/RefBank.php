<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefBank extends Model
{
    protected $table = 'ref_bank';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'bank_id', 'bank_name', 'rrs_id'
    ];
}
