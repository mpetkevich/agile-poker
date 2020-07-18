<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
         'value',
    ];

    public $timestamps = false;

}
