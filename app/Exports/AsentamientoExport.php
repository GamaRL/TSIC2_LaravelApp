<?php

namespace App\Exports;

use App\Asentamiento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AsentamientoExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Asentamiento::all(['cp', 'nombre']);
    }

    public function headings(): array
    {
        return [
            'Código Postal',
            'Nombre'
        ];
    }

    public function title(): string
    {
        return 'Asentamientos';
    }
}
