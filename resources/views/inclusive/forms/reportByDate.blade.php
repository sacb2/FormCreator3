@extends('layouts_template.app') <!-- template -->


@section('content')


<body>


<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-book"></i> Exportar Solicitudes</div>
  <div class="panel-body">



    <div class="signup-form-container">
    
         <!-- form start -->
		 <form role="form" id="register-form" autocomplete="off" action="{{route('requestExportGenerateAnswers')}}" method="post">
		 @csrf <!-- {{ csrf_field() }} -->
		
         <input name="id" type="hidden" value="{{$id}}">


<div class="form-group">	  
		  		    
  
  <label for="birth_date" class="col-2 col-form-label">Fecha de Inicio</label>
  <div class="form-group">
    <input class="form-control" type="date" name="request_ini_date"   id="date_start">

  </div>
    <label for="birth_date" class="col-2 col-form-label">Fecha de Fin</label>
  <div class="form-group">
    <input class="form-control" type="date" name="request_end_date"   id="date_end">

  </div>
  
  
</div>
  
 
			<div class="form-group row mb-0">
                            <div class="col-md-8"  >
							<a href="{{ URL::previous() }}"  type="button"  class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                <button type="submit" class="btn btn-info" ><i class="glyphicon glyphicon-ok-circle"></i> 
                                    {{ __('Exportar') }}
                                </button>  
								<a href="{{ URL::current() }}"  type="button"  class="btn btn-danger"><i class="glyphicon glyphicon-ban-circle"></i> Cancelar</a>
								</div>
						</div>
            </form>
           

    
</div>
</div>
</body>
@endsection
