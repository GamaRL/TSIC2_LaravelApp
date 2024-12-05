<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Paciente extends Model
{
    protected $fillable = [
        'nombre',
        'apPat',
        'apMat',
        'fecha_nacimiento',
        'sexo',
        'curp',
        'tel',
        'asentamiento_id',
        'diab_mill',
        'hiper_t',
        'obesidad',
        'sobrepeso',
        'otro',
        'talla',
        'tipo_sangre',
    ];

    public $timestamps = false;

    public function consulta()
    {
        return $this->hasMany(Consulta::class, 'paciente', 'id');
    }

    public function asentamiento()
    {
        return $this->hasOne(Asentamiento::class, 'id', 'asentamiento_id');
    }

    public function getDiagnostico()
    {
        $diag = [];
        if ($this->diab_mill) {
            array_push($diag, "Diabetes Milletus");
        }
        if ($this->hiper_t) {
            array_push($diag, "Hipertensión");
        }
        if ($this->obesidad) {
            array_push($diag, "Obesidad");
        }
        if ($this->sobrepeso) {
            array_push($diag, "Sobrepeso");
        }
        if ($this->otro) {
            array_push($diag, $this->otro);
        }
        return implode(", ", $diag);
    }

    public function sesiones()
    {
        return $this->consulta()
            ->get()
            ->sortBy('sesion')
            ->transform(function ($consulta) {
                return collect($consulta)
                    ->except([
                        'id',
                        'created_at',
                        'updated_at',
                        'paciente'])
                    ->all();
            });
    }

    public function get_mensajes()
    {
        return DB::table('consultas')
            ->leftJoin('consulta_mensaje', 'consultas.id', '=', 'consulta_mensaje.consulta_id')
            ->leftJoin('mensajes', 'mensajes.id', '=', 'consulta_mensaje.mensaje_id')
            ->select('consultas.sesion', 'mensajes.*')
            ->where('consultas.paciente', $this->id)
            ->get()
            ->groupBy('sesion')
            ->transform(function ($consulta) {
                return $consulta->mapWithKeys(function ($mensaje) {
                    if ($mensaje->mensaje !== null)
                        return [$mensaje->categoria => $mensaje->mensaje];
                    return [];
                });
            })->toArray();
    }

    public function get_alertas()
    {
        return $this->consulta
            ->keyBy('sesion')
            ->transform(function ($consulta) {
                return collect($consulta->alerta()
                    ->selectRaw('CASE WHEN tipo IN ("ta_sist", "ta_diast") THEN "presion" ELSE tipo END As tipo')
                    ->get()
                    ->pluck('tipo')
                    ->unique());
            });
    }

    public function create_message($mensaje)
    {
        $this->consulta()
            ->where('sesion', $mensaje['sesion'])
            ->firstOrFail()
            ->mensajes()
            ->updateOrCreate(['categoria' => $mensaje['categoria']], $mensaje);
    }
}
