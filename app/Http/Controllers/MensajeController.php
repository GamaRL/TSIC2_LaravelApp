<?php

namespace App\Http\Controllers;

use App\Consulta;
use App\Mensaje;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MensajeController extends Controller
{
    public function store(Request $request, Paciente $paciente)
    {
        $rules = [
            'sesion' => 'required|max:255',
            'mensaje' => 'required|max:255',
            'categoria' => 'required|in:presion,glucosa,icc,imc,sanos'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return [
                'errors' => $validator->errors()
            ];
        $this->validate($request, $rules);
        $paciente->create_message($request->all());
        return response()->json(["success" => true]);
    }

    public function store_all(Request $request)
    {
        $rules = [
            'sesion' => 'required|date',
            'mensaje' => 'required|max:255',
            'categoria' => 'required|in:presion,glucosa,icc,imc,sanos'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()]);

        $date = $request->get('sesion');
        $mensaje = Mensaje::create($request->except('sesion'));
        if ($mensaje->categoria === 'sanos') {
            $query = "
SELECT
	DISTINCT
    c.id
FROM consultas c
LEFT JOIN alertas a ON a.consulta_id = c.id
LEFT JOIN consulta_mensaje c_m ON c_m.consulta_id = c.id
LEFT JOIN mensajes m ON m.id = c_m.mensaje_id AND m.categoria=\"sanos\"
WHERE m.id is NULL AND a.id is NULL AND DATE(c.created_at) = \"$date\"";
        } elseif($mensaje->categoria === 'presion'){
$query = "SELECT
    c.id
FROM alertas a
INNER JOIN consultas c ON a.consulta_id = c.id
LEFT JOIN consulta_mensaje c_m ON c_m.consulta_id = c.id
LEFT JOIN mensajes m ON m.id = c_m.mensaje_id AND m.categoria='presion'
WHERE m.id IS NULL AND DATE(c.created_at) = DATE(\"$date\") AND a.tipo IN ('ta_sist', 'ta_diast')";
        }else {
            $query = "SELECT
    c.id
FROM alertas a
INNER JOIN consultas c ON a.consulta_id = c.id
LEFT JOIN consulta_mensaje c_m ON c_m.consulta_id = c.id
LEFT JOIN mensajes m ON m.id = c_m.mensaje_id AND m.categoria=\"$mensaje->categoria\"
WHERE m.id IS NULL AND DATE(c.created_at) = DATE(\"$date\") AND a.tipo=\"$mensaje->categoria\"";
        }

        DB::insert("INSERT INTO consulta_mensaje SELECT c.id AS consulta_id, \"$mensaje->id\" AS mensaje_id FROM($query) AS c");

        return response()->json(["success" => true]);
    }
}
