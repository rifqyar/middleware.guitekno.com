<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    use HasFactory;

    protected $table = 'ref_user_types';

    protected $primaryKey = 'ut_id';

    protected $fillable = ['ut_name', 'ut_displayname', 'ut_desc'];

    protected $casts = [
        'removable' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'usertype_id');
    }
}
