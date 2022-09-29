<?php

namespace Vanguard\Http\Controllers\Web\UserTypes\TypesUser;

use Illuminate\Support\Facades\DB;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Controllers\Library;

class DbController
{
    /** GET DATA */
    public static function getAll()
    {
        $data = DB::SELECT("SELECT * FROM ref_user_types");

        return $data;
    }

}
