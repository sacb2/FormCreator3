<?php

use Illuminate\Database\Seeder;

class TypesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_types')->insert([
            'name' => 'Administrador',
            'state_id' => '1',
            'type_id'=>'0'
            
        ]);

        DB::table('users_types')->insert([
            'name' => 'Profesional',
            'state_id' => '1',
            'type_id'=>'1'
            
        ]);
        DB::table('users_types')->insert([
            'name' => 'Evaluador',
            'state_id' => '1',
            'type_id'=>'2'
            
        ]);
        DB::table('users_types')->insert([
            'name' => 'Evaluador Externo',
            'state_id' => '1',
            'type_id'=>'3'
            
        ]);

     
    }
}
