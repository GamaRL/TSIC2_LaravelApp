<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asentamiento extends Model
{
    protected $fillable = [
        'cp',
        'nombre'
    ];

    public $timestamps = false;
}
