<?php

namespace App\Exports;

use App\Paciente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PacientesExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Paciente::all()
            ->makeHidden(['created_at', 'updated_at']);
    }

    public function headings(): array
    {
        return [
            'id',
            'nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Fecha de Nacimiento',
            'Sexo',
            'CURP',
            'Teléfono',
            'Código Postal',
            'Tipo de sangre',
            'Diabetes Milletus',
            'Híper Tensión',
            'Obesidad',
            'Sobrepeso',
            'Otro',
            'Talla',
        ];
    }

    public function title(): string
    {
     return "Pacientes";
    }
}
