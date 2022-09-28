<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatApiUser extends Model
{
    use HasFactory;
    protected $table = "dat_apiuser";
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'bank_id', 'dau_username', 'dau_password'
    ];


    public function bank()
    {
        return $this->hasOne(RefBank::class, 'bank_id', 'bank_id');
    }
}
