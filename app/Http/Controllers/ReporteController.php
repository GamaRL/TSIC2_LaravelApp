<?php

namespace App\Http\Controllers;

use App\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $orderBy = $request->query('order');

        if ($orderBy == 'nombre') {
            $pacientes = Paciente::orderBy('nombre')->paginate(40);
            $pacientes->appends(['order' => 'nombre']);
        } elseif ($orderBy == 'ap') {
            $pacientes = Paciente::orderBy('apPat')->orderBy('apMat')->paginate(40);
            $pacientes->appends(['order' => 'ap']);
        } else {
            $orderBy = 'id';
            $pacientes = Paciente::orderBy('id')->paginate(40);
            $pacientes->appends(['order' => 'id']);
        }

        if ($request->query('generate')) {
            $fecha = ucfirst(Carbon::now('-06:00')->locale('es_ES')->isoFormat('MMMM D, YYYY'));
            $pdf = \PDF::loadView('reporte', compact(['pacientes', 'fecha', 'orderBy']))->setPaper('letter', 'vertical');
            return $pdf->download('page_' . $pacientes->currentPage() . ' (' . Carbon::now()->format('d-m-Y') . ')' . '.pdf');
        }
        return view('exportar_reportes', compact(['pacientes', 'orderBy']));
    }

    public function individual(Request $request, Paciente $paciente)
    {
        $fecha = ucfirst(Carbon::now('-06:00')->locale('es_ES')->isoFormat('MMMM D, YYYY'));
        $pdf = \PDF::loadView('paciente_reporte', compact(['paciente', 'request', 'fecha']))
            ->setPaper('letter', 'vertical');
        return $pdf->download('paciente_' . $paciente->id . ' (' . Carbon::now()->format('d-m-Y') . ')' . '.pdf');

    }

}
