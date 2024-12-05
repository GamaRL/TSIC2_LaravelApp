<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ConsultasExport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $fields = [
            'peso' => 'Peso',
            'pulso' => 'Pulso',
            'cuello' => 'Cuello',
            'cintura' => 'Cintura',
            'cadera' => 'Cadera',
            'muslo' => 'Muslo',
            'masa_grasa' => 'Masa Grasa',
            'masa_muscular' => 'Masa Mucular',
            'total_agua' => 'Total de Agua',
            'cant_glucosa' => 'Cantidad de Glucosa',
            'ayuno' => 'En ayuno',
            'ta_sist' => 'Tensión Arterial Sistólica',
            'ta_diast' => 'Tensión Arterial Diastólica',
            'oximetria' => 'Oximetría',
            'diab_mill' => 'Diabetes'
        ];

        foreach ($fields as $field => $sheetName)
            $sheets[] = new ItemConsultaExport($field, $sheetName);
        $sheets[] = new PacientesExport();
        $sheets[] = new AsentamientoExport();

        return $sheets;
    }
}
