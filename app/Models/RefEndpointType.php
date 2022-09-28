<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefEndpointType extends Model
{
    use HasFactory;
    protected $table = 'ref_endpoint_type';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id', 'name'
    ];
}
