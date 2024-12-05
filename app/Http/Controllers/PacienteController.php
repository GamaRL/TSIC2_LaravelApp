<?php

namespace App\Http\Controllers;

use App\Asentamiento;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pacientes = DB::table('pacientes')->get(['id', 'nombre', 'apPat', 'apMat']);
        return view('pacientes', compact('pacientes'));
    }

    public function dataTable(Request $request)
    {
        $columns = ['id', 'nombre', 'apPat', 'apMat'];
        $value = strtolower($request->input('search.value'));
        $data = DB::table('pacientes')
            ->whereRaw("lower(concat(nombre,' ', apPat,' ', apMat)) like '%$value%'")
            ->orWhereRaw("id like '%$value%'")
            ->select(['id', 'nombre', 'apPat', 'apMat'])
            ->orderBy($columns[$request->input('order.0.column')], $request->input('order.0.dir'))
            ->skip(intval($request->input('start')))
            ->take(intval($request->input('length')))
            ->get();

        $recordsFiltered = DB::table('pacientes')
            ->whereRaw("lower(apPat) like '%$value%'")
            ->orWhereRaw("lower(apMat) like '%$value%'")
            ->orWhereRaw("lower(nombre) like '%$value%'")
            ->orWhereRaw("id like '%$value%'")
            ->count();

        $json_data = [
            "draw" => intval($request->input('draw')),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval(Paciente::count()),  // total number of records
            "recordsFiltered" => $recordsFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data
        ];

        return response()->json($json_data);
    }

    public function create()
    {
        return view('nuevo_paciente');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:50|min:2',
            'apPat' => 'required|max:25|min:2',
            'apMat' => 'required|max:25|min:2',
            'fecha_nacimiento' => 'required|date_format:Y-m-d|before:today',
            'sexo' => 'required|in:M,F',
            'curp' => [
                'required',
                'regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/',
                'unique:pacientes'
            ],
            'tel' => [
                'required',
                'regex:/^\d{8,10}$/',
                'digits_between:8,10',
                'numeric'
            ],
            'cp' => 'digits:5|exclude_if:nuevo_asentamiento,on|required|exists:asentamientos',
            'nombre_nuevo_asentamiento' => 'exclude_unless:nuevo_asentamiento,on|max:50|min:2',
            'asentamiento_id' => 'exclude_if:nuevo_asentamiento,on|required|numeric',
            'diab_mill' => 'required|boolean',
            'hiper_t' => 'required|boolean',
            'obesidad' => 'required|boolean',
            'sobrepeso' => 'required|boolean',
            'otro' => 'max:50|min:0',
            'tipo_sangre' => 'required|in:A+,B+,AB+,O+,A-,B-,AB-,O-',
            'talla' => 'required|integer|min:30',
        ];

        $mesages = [
            'asentamiento_id.numeric' => 'Por favor seleccione un asentamiento',
            'nombre_nuevo_asentamiento.required' => 'Por favor escriba el nombre del asentamiento'
        ];

        $this->validate($request, $rules, $mesages);

        $asentamiento = $request->input('asentamiento_id');
        if ($request->input('nuevo_asentamiento') === 'on') {
            $asentamiento = Asentamiento::create([
                'cp' => $request->input('cp'),
                'nombre' => $request->input('nombre_nuevo_asentamiento')
            ])->id;
        }
        $paciente = Paciente::create(collect($request->except(['asentamiento', 'cp', 'asentamiento_id', 'nombre_nuevo_asentamiento', 'nuevo_asentamiento']))->merge(['asentamiento_id' => $asentamiento])->toArray());
        return redirect('/pacientes/' . $paciente->id);
    }

    public function show(Paciente $paciente)
    {
        return view('paciente_only', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        return view("paciente_edit", compact('paciente'));
    }

    public function updateAlertas(Paciente $paciente) {
        $paciente->consulta->each(function ($consulta) {
//           $consulta->alerta()->delete();
            AlertaController::getAlertas($consulta);
        });
    }

    public function update(Request $request, Paciente $paciente)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'apPat' => 'required',
            'apMat' => 'required',
            'fecha_nacimiento' => 'required|date_format:Y-m-d|before:today',
            'talla' => 'required|integer|min:30',
        ]);

        $paciente->fill($request->all())->save();

        $this->updateAlertas($paciente);

        return redirect("/pacientes/$paciente->id/edit")->with('success', true);
    }

    public function getStatData($id)
    {
        $data = Paciente::find($id)
            ->consulta()
            ->orderBy('sesion')
            ->get()
            ->map(function ($consulta) {
                $paciente = Paciente::find($consulta->paciente);
                return [
                    'peso' => $consulta->peso,
                    'cuello' => $consulta->cuello,
                    'cintura' => $consulta->cintura,
                    'cadera' => $consulta->cadera,
                    'muslo' => $consulta->muslo,
                    'cant_glucosa' => $consulta->cant_glucosa,
                    'ta_sist' => $consulta->ta_sist,
                    'ta_diast' => $consulta->ta_diast,
                    'oximetria' => $consulta->oximetria,
                    'imc' => ($consulta->peso !== null) ? $consulta->peso / ($paciente->talla / 100) ** 2 : null,
                    'icc' => ($consulta->cintura !== null && $consulta->cadera !== null) ? $consulta->cintura / $consulta->cadera : null,
                    'intervalo_glucosa' => AlertaController::intervalsGlucosa($consulta),
                    'intervalo_imc' => AlertaController::intervalIMC(),
                    'intervalo_icc' => AlertaController::intervalICC(Paciente::find($consulta->paciente)),
                    'intervalo_ta_sist' => AlertaController::intervalTensionSist($consulta, Paciente::find($consulta->paciente)),
                    'intervalo_ta_diast' => AlertaController::intervalTensionDiast($consulta, Paciente::find($consulta->paciente))
                ];
            });
        return response()->json([
            'data' => $data
        ]);
    }

    public function get_alertas_data(Paciente $paciente)
    {
        return response()->json([
           'alertas'=> $paciente->get_alertas(),
            'mensajes' => $paciente->get_mensajes()
        ]);
    }

    public function getRiesgo($sesion, $paciente)
    {
        $paciente = Paciente::find($paciente);

        $cons_curr = $paciente->consulta()->get()->where('sesion', $sesion)->first();
        $cons_prev = null;

        $curr_imc = null;
        $prev_imc = null;

        $curr_icc = null;
        $prev_icc = null;

        if ($cons_curr->peso !== null)
            $curr_imc = $cons_curr->peso / ($paciente->talla / 100) ** 2;

        if ($cons_curr->cintura !== null && $cons_curr->cadera !== null)
            $curr_icc = $cons_curr->cintura / $cons_curr->cadera;

        if ($sesion > 1) {
            $cons_prev = $paciente->consulta()->get()->where('sesion', $sesion - 1)->first();
            if ($cons_prev->peso !== null)
                $prev_imc = $cons_prev->peso / ($paciente->talla / 100) ** 2;
            if ($cons_prev->cintura !== null && $cons_prev->cadera !== null)
                $prev_icc = $cons_prev->cintura / $cons_prev->cadera;
        }

        if ($cons_curr === null)
            return redirect('/admin/pacientes');

        $data = [
            'paciente' => $paciente,
            'curr' => $cons_curr,
            'prev' => $cons_prev,
            'curr_imc' => $curr_imc,
            'prev_imc' => $prev_imc,
            'curr_icc' => $curr_icc,
            'prev_icc' => $prev_icc,
        ];

        $msg = [
            'glucosa' => $cons_curr
                ->alerta()
                ->where('tipo', 'glucosa')
                ->first(),
            'ta_sist' => $cons_curr
                ->alerta()
                ->where('tipo', 'ta_sist')
                ->first(),
            'ta_diast' => $cons_curr
                ->alerta()
                ->where('tipo', 'ta_diast')
                ->first(),
            'imc' => $cons_curr
                ->alerta()
                ->where('tipo', 'imc')
                ->first(),
            'icc' => $cons_curr
                ->alerta()
                ->where('tipo', 'icc')
                ->first(),
        ];

        $msg = array_filter(
            array_map(function ($alert) {
                if ($alert !== null)
                    return $alert->mensaje;
                return null;
            }, $msg),
            function ($alert) {
                return $alert !== null;
            }
        );

        $data['alertas'] = $msg;
        return view('paciente_riesgo', compact('data'));
    }

    public function changeDiabMill($id)
    {
        $paciente = Paciente::find($id);
        $paciente->diab_mill = true;
        $paciente->save();
        return redirect('/admin/pacientes/1');
    }

}
