<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
         'vote',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
