<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\InclusiveAnswer;

class ExportsController extends Controller
{
    //


    public function requestsExportAnswers(Request $request) 
{
		
if($request->request_ini_date!=null and $request->request_end_date!=null and $request->request_end_date>=$request->request_ini_date){
	
	return \Excel::download(new  AnswersExport($request->request_ini_date,$request->request_end_date,$request->id), 'requirements.xlsx');
	
	
}else
{
	Session::flash('alertSent', 'PrescriptionInfo');
		Session::flash('message', 'Seleccione una fecha correctamente' );
				return redirect()->back();
}
	$storedAnswers = InclusiveAnswer::where('id_formulario', $request->id)->where('updated_at','>=', $request->request_ini_date)->where('updated_at','<=', $request->request_end_date)->groupBy('id_requerimiento')->get();
//dd($storedAnswers);


if($request->semana!='Seleccionar'){
		
	$year= date("Y");
	$semana_actual= $request->semana;
	$fecha = $this->get_dates($year,$semana_actual);	
	
	$requirements= Requirements::where('request_date','>=',$fecha[0])->where('request_date', '<=',$fecha[1])->get();
//	dd($requirements, $fecha[0]->format('d/m/Y'), $fecha[1]->format('d/m/Y'));

	foreach($requirements as $requirement)
		foreach($requirement->meds as $med){
				//dd($med->medicament_data);//informacion de medicamento
				//dd($med->prescription_data->beneficiarie);//informacion de beneficiario
			
		}
			

 //$medicamentsReqs= MedicamentsRequirements::where('requirements_id','=',$selected)->where('medicaments_id', key($meds))->first();
//     return view('exports.requirements', ['requirements'=>$requirements, 'ini_date'=>$request->request_ini_date,'end_date'=>$request->request_end_date]);

	
	return \Excel::download(new  RequirementExport($fecha[0]->format("Y-m-d H:i:s"),$fecha[1]->format("Y-m-d H:i:s")), 'requirements.xlsx');
		//dd($fecha[0]->format('d/m/Y'), $fecha[1]->format('d/m/Y'));
		
	}else if ($request->request_ini_date!=null and $request->request_end_date!=null and $request->request_end_date>=$request->request_ini_date ){
			 $requirements= Requirements::where('request_date','>=',$request->request_ini_date)->where('request_date', '<=',$request->request_end_date)->get();
	foreach($requirements as $requirement)
		foreach($requirement->meds as $med){
				//dd($med->medicament_data);//informacion de medicamento
				//dd($med->prescription_data->beneficiarie);//informacion de beneficiario
			
		}
			

 //$medicamentsReqs= MedicamentsRequirements::where('requirements_id','=',$selected)->where('medicaments_id', key($meds))->first();
//     return view('exports.requirements', ['requirements'=>$requirements, 'ini_date'=>$request->request_ini_date,'end_date'=>$request->request_end_date]);

	
return \Excel::download(new  RequirementExport($request->request_ini_date,$request->request_end_date), 'requirements.xlsx');
	}else{
			Session::flash('alertSent', 'PrescriptionInfo');
	Session::flash('message', 'Seleccione una fecha correctamente' );
			return redirect()->route('requestsExport');
	}
	
	 $requirements= Requirements::where('request_date','>=',$request->request_ini_date)->where('request_date', '<=',$request->request_end_date)->get();
	foreach($requirements as $requirement)
		foreach($requirement->meds as $med){
				//dd($med->medicament_data);//informacion de medicamento
				//dd($med->prescription_data->beneficiarie);//informacion de beneficiario
			
		}
			

 //$medicamentsReqs= MedicamentsRequirements::where('requirements_id','=',$selected)->where('medicaments_id', key($meds))->first();
//     return view('exports.requirements', ['requirements'=>$requirements, 'ini_date'=>$request->request_ini_date,'end_date'=>$request->request_end_date]);

	
return \Excel::download(new  RequirementExport($request->request_ini_date,$request->request_end_date), 'requirements.xlsx');
}

}
