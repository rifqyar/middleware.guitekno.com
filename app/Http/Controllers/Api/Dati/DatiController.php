<?php

namespace Vanguard\Http\Controllers\Api\Dati;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\RefDati;

class DatiController extends Controller
{
    public function get($prop_id = null)
    {
        if ($prop_id) {
            $data = RefDati::where('prop_id', $prop_id)->get();
        } else {
            $data = RefDati::all();
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
