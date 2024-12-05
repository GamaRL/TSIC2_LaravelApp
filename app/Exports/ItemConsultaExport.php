<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ItemConsultaExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $field;
    protected $sheetName;
    static $pacienteId;

    public function __construct(string $field, string $sheetName)
    {
        $this->field = $field;
        $this->sheetName = $sheetName;
    }

    public function map($row): array
    {
        $row = $row->toArray();
        $paciente = array_map(function ($consulta) {
            ItemConsultaExport::$pacienteId = $consulta->paciente;
            return $consulta->item;
        }, $row);

        array_unshift($paciente, ItemConsultaExport::$pacienteId);
        return $paciente;
    }

    /**
     * @param $key
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('consultas')->select('paciente', DB::raw($this->field . ' as item'))->orderBy('paciente')->get()->groupBy('paciente');
    }

    public function headings(): array
    {
        $sesiones = DB::table('consultas')->max('sesion');
        $headings = ['Id Paciente'];

        foreach (range(1, $sesiones) as $number)
            array_push($headings, "Sesión" . $number);

        return $headings;
    }

    public function title(): string
    {
        return $this->sheetName;
    }

}
