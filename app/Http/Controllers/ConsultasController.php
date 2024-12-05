<?php /** @noinspection SqlDialectInspection */

namespace App\Http\Controllers;

use App\Consulta;
use App\Paciente;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsultasExport;

class ConsultasController extends Controller
{
    public static $filterUsers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id_paciente)
    {
        $paciente = Paciente::where('id', $id_paciente)->first();
        if ($paciente)
            return view('consulta', compact('paciente'));
        else
            return redirect('/');
    }

    public function store(Request $request)
    {
        $rules = [
            'paciente' => 'required|exists:pacientes,id',
            'peso' => 'nullable|numeric',
            'pulso' => 'nullable|integer|min:0|max:1000',
            'cuello' => 'nullable|numeric',
            'cintura' => 'nullable|numeric',
            'cadera' => 'nullable|numeric',
            'muslo' => 'nullable|numeric',
            'masa_grasa' => 'nullable|numeric|regex:/^\d*\.?\d$/',
            'masa_muscular' => 'nullable|numeric|regex:/^\d*\.?\d$/',
            'total_agua' => 'nullable|numeric|regex:/^\d*\.?\d$/',
            'cant_glucosa' => 'required|numeric|min:0|max:1000',
            'ayuno' => 'boolean',
            'ta_sist' => 'required|numeric|min:0|max:1000',
            'ta_diast' => 'required|numeric|min:0|max:1000',
            'oximetria' => 'required|numeric|min:0|max:100',
            'sesion' => 'required|numeric',
        ];

        $this->validate($request, $rules);

        if (Consulta::where('sesion', $request->input('sesion'))->where('paciente', $request->input('paciente'))->count() === 0) {
            $consulta = Consulta::create($request->all());
            AlertaController::getAlertas($consulta);
        }
        return redirect('/pacientes/' . $request->input('paciente'));
    }

    public function exportExcel()
    {
        return Excel::download(new ConsultasExport, 'list.xlsx');
    }

    private function countDataBetween($dataInfo, $campo, $sesion)
    {
        $glucosa = [];
        foreach ($dataInfo as $data) {
            $glucosa_tmp = Consulta::where("sesion", $sesion)
                ->where($campo, ">", $data["intervals"][0])
                ->where($campo, "<=", $data["intervals"][1])
                ->count();
            array_push($glucosa, [
                "tag" => $data["tag"],
                "size" => $glucosa_tmp
            ]);
        }
        return $glucosa;
    }

    private function makeIntervals($interval)
    {
        $intervals = [];
        for ($i = 0; $i < count($interval) - 1; $i++) {
            $intervals[] = [
                'intervals' => [$interval[$i], $interval[$i + 1]],
                'tag' => $interval[$i] . '-' . $interval[$i + 1]
            ];
        }
        $intervals[0]['tag'] = '<' . $intervals[0]['intervals'][1];
        $intervals[count($intervals) - 1]['tag'] = '>' . $intervals[count($intervals) - 1]['intervals'][0];
        return $intervals;
    }

    private function countDiabetes($sesion)
    {
        $query = '
            SELECT
                COUNT(
                    CASE
                        WHEN c.diab_mill
                            THEN 1
                        WHEN NOT c.diab_mill AND ((c.cant_glucosa > 130 AND c.ayuno) OR (c.cant_glucosa > 140 AND NOT c.ayuno ))
                            THEN 1
                        ELSE NULL
                    END
                ) AS diabeticos,
                COUNT(
                    CASE
                        WHEN NOT c.diab_mill AND c.cant_glucosa >= 100 AND c.cant_glucosa < 130 AND c.ayuno
                            THEN 1
                        ELSE
                            NULL
                    END
                ) AS prediabeticos,
                COUNT(
                    CASE
                        WHEN NOT c.diab_mill AND ((c.cant_glucosa < 100 AND c.ayuno) OR (NOT c.ayuno AND c.cant_glucosa <= 140))
                            THEN 1
                        ELSE
                            NULL
                    END
                ) as normales

            FROM pacientes p
            INNER JOIN consultas c
                ON c.paciente = p.id
            WHERE c.sesion = ' . $sesion;
        return (array)DB::select($query)[0];
    }

    public function statistics($sesion)
    {
        $dataInfoGluscosa = $this->makeIntervals([0, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 1000]);
        $dataInfoTensionSist = $this->makeIntervals([0, 70, 80, 90, 100, 110, 120, 130, 140, 150, 1000]);
        $dataInfoTensionDiast = $this->makeIntervals([0, 50, 60, 70, 80, 90, 100, 1000]);

        $glucosa = $this->countDataBetween($dataInfoGluscosa, "cant_glucosa", $sesion);
        $tension_sist = $this->countDataBetween($dataInfoTensionSist, "ta_sist", $sesion);
        $tension_diast = $this->countDataBetween($dataInfoTensionDiast, "ta_diast", $sesion);
        $diabetes = $this->countDiabetes($sesion);

        return response()->json([
            'glucosa' => $glucosa,
            'ta_sist' => $tension_sist,
            'ta_diast' => $tension_diast,
            'diabetes' => $diabetes,
        ]);
    }

    public function alertasSesion($i)
    {
        $tipos = [
            'glucosa' => 0,
            'tension' => 0,
            'icc' => 0,
            'imc' => 0
        ];
        return Consulta::where('sesion', $i)
            ->get()
            ->pluck('alerta')
            ->reduce(function ($carry, $consulta) {
                if (!empty($consulta->all())) {
                    $al = $consulta->pluck('tipo');
                    $carry['glucosa'] += $al->contains('glucosa');
                    $carry['tension'] += $al->contains('ta_sist') || $al->contains('ta_diast');
                    $carry['icc'] += $al->contains('icc');
                    $carry['imc'] += $al->contains('imc');
                }
                return $carry;
            }, $tipos);
    }

    public function getStatGeneral()
    {
        $data = [];
        for ($i = 1; $i <= Consulta::max('sesion'); $i++) {
            $consulta = $this->countDiabetes($i);
            $consulta['asistentes'] = DB::table('consultas')
                ->where("sesion", $i)
                ->count();
            $consulta['alertas'] = $this->alertasSesion($i);
            $data[] = $consulta;
        }
        return response()->json($data);
    }

    public function getPacientesRiesgo($sesion)
    {
        $max_sesion = Consulta::max('sesion');
        return view('riesgos', compact(['sesion', 'max_sesion']));
    }

    public function riesgoDatatable(Request $request, $sesion)
    {
        $columns = ['id', 'nombre', 'apPat', 'apMat', 'alertas'];
        $value = strtolower($request->input('search.value'));

        $total_alertas = DB::table('pacientes')
            ->join('consultas', 'consultas.paciente', '=', 'pacientes.id')
            ->join('alertas', 'alertas.consulta_id', '=', 'consultas.id')
            ->select('pacientes.id')
            ->where('consultas.sesion', $sesion)
            ->groupBy('id')
            ->get()
            ->count();

        $pacientes = DB::table('pacientes')
            ->join('consultas', function ($join) use ($sesion) {
                $join->on('pacientes.id', '=', 'consultas.paciente')
                    ->where('consultas.sesion', $sesion);
            })
            ->join('alertas', 'alertas.consulta_id', '=', 'consultas.id')
            ->whereRaw("lower(concat(pacientes.nombre,' ', pacientes.apPat,' ', pacientes.apMat)) like '%$value%' or pacientes.id like '%$value%'")
            ->select('alertas.tipo', 'pacientes.id')
            ->get()
            ->groupBy('id')
            ->transform(function ($paciente, $index) {
                $alertas = $paciente->pluck('tipo');
                $curr_paciente = Paciente::find($index);
                return collect([
                    'id' => $curr_paciente->id,
                    'nombre' => $curr_paciente->nombre,
                    'apPat' => $curr_paciente->apPat,
                    'apMat' => $curr_paciente->apMat,
                    'alertas' => [
                        'glucosa' => $alertas->contains('glucosa'),
                        'tension' => $alertas->contains('ta_diast') || $alertas->contains('ta_sist'),
                        'imc' => $alertas->contains('imc'),
                        'icc' => $alertas->contains('icc'),
                    ]
                ]);
            });
        $column_to_sort = $columns[$request->input('order.0.column')];
        if ($column_to_sort !== "alertas") {
            $pacientes = $request->input('order.0.dir') === 'asc'
                ?
                $pacientes->sortBy($column_to_sort)
                :
                $pacientes->sortByDesc($column_to_sort);

        } else {
            $pacientes = $request->input('order.0.dir') === 'asc'
                ?
                $pacientes->sortBy(function ($paciente) {
                    return collect($paciente['alertas'])->only(['glucosa', 'tension', 'imc', 'icc'])->diff(false)->count();
                })
                :
                $pacientes->sortByDesc(function ($paciente) {
                    return collect($paciente['alertas'])->only(['glucosa', 'tension', 'imc', 'icc'])->diff(false)->count();
                });
        };

        $filteredData = $pacientes
            ->skip(intval($request->input('start')))
            ->take(intval($request->input('length')))
            ->values();

        $json_data = [
            "draw" => intval($request->input('draw')),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => $total_alertas,  // total number of records
            "recordsFiltered" => $pacientes->count(), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $filteredData
        ];
        return response()->json($json_data);
    }

    public function get_mensajes_disponibles()
    {
            $query = 'SELECT
        DISTINCT
        DATE(c.created_at) AS fecha,
        CASE
            WHEN a.tipo IN ("ta_sist", "ta_diast") THEN "presion"
            ELSE a.tipo
        END AS categoria
    FROM alertas a
    INNER JOIN consultas c ON a.consulta_id = c.id
    LEFT JOIN consulta_mensaje c_m ON c_m.consulta_id = c.id
    LEFT JOIN mensajes m ON m.id = c_m.mensaje_id AND m.categoria = (CASE
            WHEN a.tipo IN ("ta_sist", "ta_diast") THEN "presion"
            ELSE a.tipo
        END)
WHERE m.categoria IS NULL AND c_m.consulta_id IS NULL
 UNION
 SELECT
 DISTINCT
	DATE(c.created_at) AS fecha,
	"sanos" As categoria
FROM consultas c
LEFT JOIN alertas a ON a.consulta_id = c.id
LEFT JOIN consulta_mensaje c_m ON c_m.consulta_id = c.id
LEFT JOIN mensajes m ON m.id = c_m.mensaje_id AND m.categoria="sanos"
WHERE m.id is NULL AND a.id is NULL
ORDER BY fecha, categoria';
        return collect(DB::select($query))
            ->mapToGroups(function($item) {
                return [$item->fecha=>$item->categoria];
            });
    }

}
