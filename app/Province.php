<?php

namespace Vanguard;

use Database\Factories\TypesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Vanguard\Support\Authorization\AuthorizationRoleTrait;

class Province extends Model
{
    use AuthorizationRoleTrait, HasFactory;

    protected $table = 'ref_propinsi';

    protected $primaryKey = 'prop_id';

    protected $fillable = ['prop_id', 'prop_nama', 'ut_id'];

    // protected $casts = [
    //     'removable' => 'boolean'
    // ];

    public function users()
    {
        return $this->hasMany(User::class, 'usertype_id');
    }
}
