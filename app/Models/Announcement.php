<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{

    protected $fillable = [
        'user_id', 'title', 'body'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
