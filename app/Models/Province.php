<?php

namespace Vanguard\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    protected $table = 'ref_propinsi';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'prop_id', 'prop_nama'
    ];

}

?>
