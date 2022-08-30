<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Model;

class RefApiStatus extends Model
{
    protected $table = 'ref_api_status';

    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'ras_id', 'ras_message', 'ras_description'
    ];
}
