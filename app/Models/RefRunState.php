<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRunState extends Model
{
    use HasFactory;
    protected $table = 'ref_runstate';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'rrs_id', 'rrs_desc'
    ];
}
