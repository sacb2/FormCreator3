<?php

use Illuminate\Database\Seeder;
use App\InclusiveForm;

class InclusiveFormContestIni extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $form= new InclusiveForm();
        $form->id = '1';
        $form->nombre='';
        $form->descripcion;
        $form->tipo;
        $form->estado;
        $form->qanswer;
        $form->save();
    }
}
