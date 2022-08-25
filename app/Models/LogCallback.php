<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Model;

class LogCallback extends Model
{
    protected $table = 'log_callback';

    public function rst()
    {
        return $this->hasOne(RefServiceType::class, 'rst_id', 'rst_id');
    }
}
