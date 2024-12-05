<?php

use Illuminate\Database\Seeder;

class AddAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'GamaRL',
            'password' => \Illuminate\Support\Facades\Hash::make('Gamy2411'),
            'type' => 'admin'
        ]);
    }
}
