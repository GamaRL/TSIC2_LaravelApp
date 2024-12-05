<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = [
        'paciente',
        'sesion',
        'peso',
        'pulso',
        'cuello',
        'cintura',
        'cadera',
        'muslo',
        'masa_grasa',
        'masa_muscular',
        'total_agua',
        'cant_glucosa',
        'diab_mill',
        'ayuno',
        'ta_sist',
        'ta_diast',
        'oximetria'
    ];

    public function paciente()
    {
        $this->belongsTo(Paciente::class);
    }

    public function alerta()
    {
        return $this->hasMany(Alerta::class);
    }

    public function mensajes()
    {
        return $this->belongsToMany(Mensaje::class);
    }
}
