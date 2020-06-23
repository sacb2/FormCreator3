<?php

use Illuminate\Database\Seeder;

class TestUsers extends Seeder
{
    /**
     * Run Seeder test on user
     * 0 admin 2 valuador
     * 1 profesional 3 evaluador exeterno
     * 
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.cl',
            'type_id' => '0',
            'password' => Hash::make('hola1234'),
        ]);

        DB::table('users')->insert([
            'name' => 'Profesional',
            'email' => 'profesional@profesional.cl',
            'type_id' => '1',
            'password' => Hash::make('hola1234'),
        ]);
        DB::table('users')->insert([
            'name' => 'Evaluador',
            'email' => 'evaluador@evaluador.cl',
            'type_id' => '2',
            'password' => Hash::make('hola1234'),
        ]);
        DB::table('users')->insert([
            'name' => 'Evaluador Externo',
            'email' => 'evaluadorexterno@evaluadorexterno.cl',
            'type_id' => '2',
            'password' => Hash::make('hola1234'),
        ]);
    }
}
