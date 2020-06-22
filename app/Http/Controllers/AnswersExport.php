<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\InclusiveAnswer;



class AnswersExport implements FromView
{
		//constructor necesario para entregar parametros a la clase
  public $start_date;
  public $end_date;
  public $id;

  public function __construct($start_date, $end_date,$id) {
	 // dd($start_date, $end_date);
    $this->start_date = $start_date;
    $this->end_date = $end_date;
    $this->id = $id;
  }
	
     public function view(): View
    {
		//dd(substr($this->start_date,-18,2),substr($this->start_date,-11,2),substr($this->start_date,-20,4),$this->start_date);
		$año=substr($this->start_date,-20,4);
		$mes=substr($this->start_date,-18,2);
		$dia=substr($this->start_date,-11,2);
		
		$añoe=substr($this->end_date,-20,4);
		$mese=substr($this->end_date,-18,2);
		$diae=substr($this->end_date,-11,2);
		
		//$ini=array_merge((array)$año,(array)$mes,(array)$dia);
		$ini=$dia.'-'.$mes.'-'.$año;
		$end=$diae.'-'.$mese.'-'.$añoe;
		//$inicio=date_format(date_create($ini),'Y-m-d');
		//$final=date_format(date_create($end),'Y-m-d');
		//dd($date);
		
		//$inicio=date("dd/mm/YYYY",substr($this->start_date,-20,10));
		//$inicio=date("dd/mm/YYYY",$ini);
		//dd($inicio,$final);
       // $requirements= Answers::where('request_date','>=',$inicio)->where('request_date', '<=',$final)->get();
        $answers = InclusiveAnswer::where('id_formulario', $this->id)->where('updated_at','>=', $this->start_date." 00:00:00")->where('updated_at','<=', $this->end_date." 23:59:59")->groupBy('id_requerimiento')->pluck('id_requerimiento');
        //$answers_all = InclusiveAnswer::where('id_formulario', $this->id)->groupBy('id_requerimiento')->get();
       $answerById=null;
       //dd($answers,$answers_all ,$this->end_date,$this->start_date);
       if($answers->count()>0){
        foreach($answers as $answer){
			$answerById[$answer]=InclusiveAnswer::where('id_requerimiento', $answer)->get();
        }
    }

	
        return view('exports.answers',  ['answersById'=> $answerById,'ini_date'=>$this->start_date,'end_date'=>$this->end_date]
		);
    }
}

