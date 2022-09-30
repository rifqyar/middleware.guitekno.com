<?php

namespace Vanguard;

use Database\Factories\TypesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Support\Authorization\AuthorizationRoleTrait;

class Type extends Model
{
    use AuthorizationRoleTrait, HasFactory;

    protected $table = 'ref_user_types';

    protected $primaryKey = 'ut_id';

    protected $casts = [
        'removable' => 'boolean'
    ];

    protected $fillable = [
        'ut_name', 'ut_displayname', 'ut_desc'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'usertype_id');
    }
}
