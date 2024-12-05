<?php

namespace App\Exports;

use App\Alerta;
use App\Consulta;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Ramsey\Collection\Collection;

class AlertasExport implements FromCollection, WithHeadings, WithTitle
{
    private $sesion;

    public function __construct($sesion)
    {
        $this->sesion = $sesion;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $s = $this->sesion;
        return collect(DB::select('SELECT * FROM (SELECT c.paciente, (SELECT 1 FROM alertas a WHERE c.id = a.consulta_id and a.tipo = "glucosa") AS glucosa, (SELECT 1 FROM alertas a WHERE c.id = a.consulta_id and a.tipo in ("ta_sist", "ta_diast") LIMIT 1) AS presion, (SELECT 1 FROM alertas a WHERE c.id = a.consulta_id and a.tipo = "imc") AS imc, (SELECT 1 FROM alertas a WHERE c.id = a.consulta_id and a.tipo = "icc") AS icc FROM consultas c WHERE c.sesion='.$s.') As t WHERE not glucosa is NULL or not presion is null or not imc is null or not icc is null ORDER BY paciente'));
    }

    public function headings(): array
    {
        return ['Paciente', 'Glucosa', 'Presión', 'IMC', 'ICC'];
    }

    public function title(): string
    {
        return "Alertas Sesión $this->sesion";
    }
}
