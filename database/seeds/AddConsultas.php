<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AddConsultas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < \App\Paciente::count(); $i++) {
            $paciente = \App\Paciente::find($i + 1);
            for ($j = 0; $j < rand(1, 10); $j++) {
                \App\Consulta::create([
                    'paciente' => $i + 1,
                    'diab_mill' => $paciente->diab_mill,
                    'sesion' => $j + 1,
                    'peso' => $faker->randomFloat(2, 50, 120),
                    'pulso' => $faker->randomFloat(2, 30, 80),
                    'cuello' => $faker->randomFloat(2, 30, 50),
                    'cintura' => $paciente->sexo === 'M' ? $faker->randomFloat(2, 70, 95) : $faker->randomFloat(2, 75, 120),
                    'cadera' => $faker->randomFloat(2, 80, 110),
                    'muslo' => $faker->randomFloat(2, 40, 80),
                    'masa_grasa' => $faker->randomFloat(2, 30, 80),
                    'masa_muscular' => $faker->randomFloat(2, 30, 80),
                    'total_agua' => $faker->randomFloat(2, 30, 80),
                    'cant_glucosa' => $faker->randomFloat(2, 67, 200),
                    'ayuno' => $faker->boolean,
                    'ta_sist' => $faker->randomFloat(2, 75, 140),
                    'ta_diast' => $faker->randomFloat(2, 60, 90),
                    'oximetria' => $faker->randomFloat(2, 90, 99.9),
                ]);
            }
        }
    }
}
