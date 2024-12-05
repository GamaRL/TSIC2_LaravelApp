<?php

use Illuminate\Database\Seeder;

class AddAsentamientos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asentamientos = [
            ['Malacates (Ampl)', '07119'],
            ['Malacates', '07119'],
            ['Ampliación Arboledas De Cuautepec', '07140'],
            ['Arboledas De Cuautepec', '07140'],
            ['Verónica Castro', '07140'],
            ['La Forestal 1', '07140'],
            ['La Forestal 2', '07140'],
            ['La Forestal 3', '07140'],
            ['Lomas De Cuautepec', '07110'],
            ['Juventino Rosas', '07150'],
            ['Cuautepec Barrio Alto', '07100'],
            ['General Felipe Berriozabal', '07180'],
            ['La Casilda', '07150'],
            ['6 De Junio', '07183'],
            ['Cocoyotes (Ampl)', '07180'],
            ['Cocoyotes', '07180'],
            ['San Miguel', '07100'],
            ['San Antonio', '07109'],
            ['Compositores Mexicanos', '07130'],
            ['Luis Donaldo Colosio', '07164'],
            ['Prados De Cuautepec', '07164'],
            ['Quetzalcoatl 3', '07164'],
            ['Loma De La Palma', '07160'],
            ['Chalma De Guadalupe I', '07210'],
            ['Chalma De Guadalupe II', '07210'],
            ['Graciano Sanchez', '07164'],
            ['Tlacaelel', '07164'],
            ['Valle De Madero', '07190'],
            ['Vista Hermosa', '07187'],
            ['Tlalpexco', '07188'],
            ['Ahuehuetes', '07189'],
            ['Jaime S Emiliano G', '07220'],
            ['Cuautepec De Madero', '07200'],
            ['Del Bosque', '07207'],
            ['Castillo Chico', '07220'],
            ['Castillo Grande', '07220'],
            ['Castillo Grande (Ampl)', '07224'],
            ['Zona Escolar Oriente', '07239'],
            ['El Arbolillo 3 (U Hab)', '07250'],
            ['Zona Escolar I', '07230'],
            ['Zona Escolar II', '07230'],
            ['Guadalupe Victoria', '07790'],
            ['Jorge Negrete', '07280'],
            ['La Pastora', '07290'],
            ['Benito Juarez', '07250'],
            ['Benito Juarez (Ampl)', '07259'],
            ['El Arbolillo', '07240'],
            ['El Arbolillo 2 (U Hab)', '07240'],
        ];

        foreach ($asentamientos as $asentamiento) {
            \App\Asentamiento::create([
                'nombre' => $asentamiento[0],
                'cp' => $asentamiento[1]
            ]);
        }
    }
}
