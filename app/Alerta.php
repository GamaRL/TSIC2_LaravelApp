<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $fillable = [
        'tipo',
        'mensaje',
        'consulta_id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id', 'id');
    }

    public $timestamps = false;
}
