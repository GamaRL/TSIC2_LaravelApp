<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = [
        'mensaje', 'categoria'
    ];

    public $timestamps = false;

    public function consulta()
    {
        return $this->belongsToMany(Consulta::class);
    }
}
