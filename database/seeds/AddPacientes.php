<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class AddPacientes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $faker->seed(1234);
        for ($i=0; $i<100; $i++) {
            \App\Paciente::create([
                'nombre' => $faker->name,
                'apPat' => $faker->lastName,
                'apMat' => $faker->lastName,
                'fecha_nacimiento' => $faker->dateTimeBetween('-70 years', '-25 years'),
                'sexo' => $faker->randomElement(['M', 'F']),
                'tel' => $faker->regexify('\d{10}'),
                'curp' => strtoupper(Str::random(18)),
                'tipo_sangre'=> $faker->randomElement(['A+', 'B+', 'AB+', 'O+', 'A-', 'B-', 'AB-', 'O-']),
                'diab_mill' => $faker->boolean,
                'hiper_t' => $faker->boolean,
                'obesidad' => $faker->boolean,
                'sobrepeso' => $faker->boolean,
                'otro' => "",
                'talla' => $faker->numberBetween(150,190),
                'asentamiento_id' => $faker->numberBetween(1,48),
            ]);
        }
    }
}
