<?php

namespace Vanguard;

use Database\Factories\TypesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Support\Authorization\AuthorizationRoleTrait;

class Dati2 extends Model
{
    use AuthorizationRoleTrait, HasFactory;

    protected $table = 'ref_dati2';

    protected $primaryKey = 'dati2_id';

    protected $fillable = ['prop_id', 'dati2_nama'];


}
