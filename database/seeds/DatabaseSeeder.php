<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\User::truncate();
//        \App\Asentamiento::truncate();
//        \App\Alerta::truncate();
//        \App\Consulta::truncate();
//        \App\Paciente::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call(AddAdminUser::class);
//        $this->call(AddAsentamientos::class);
//        $this->call(AddPacientes::class);
//        $this->call(AddConsultas::class);
    }
}
