<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpWhiteList extends Model
{
    use HasFactory;
    protected $table = 'dat_ipwhitelist';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'bank_id', 'diw_index', 'diw_address'
    ];
}
