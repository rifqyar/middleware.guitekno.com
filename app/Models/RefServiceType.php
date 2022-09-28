<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Model;

class RefServiceType extends Model
{
    protected $table = 'ref_service_type';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'rst_id', 'rst_name'
    ];
}
