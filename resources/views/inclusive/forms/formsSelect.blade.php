@extends('layouts.app')


@section('content')


<body>


<div class="panel panel-default">
	<div class="panel-heading"><i class="fa fa-user"></i> Listar Formularios</div>
	<div class="panel-body">
  <div class="table-responsive">
    	<table  class="table table-hover">
						<thead >
							<tr>
								<th scope="col">Nombre</th>
								<th scope="col">Estado</th>
								<th scope="col">Ver</th>
							</tr>
						</thead>

						<tbody>
						@foreach($forms as $form)
						
							<tr>
								<td>{{$form->nombre}}</td>
								@if($form->estado==1)
								<td>Activo</td>	
								  @elseif($form->estado==2)
								  <td>Inactivo</td>	
								  @else
								<td>{{$form->estado}}</td>	  
									@endif
								<td>
								@if($form->estado==1)
									<a href="{{URL::to('/PersonalizedFormView/')}}/{{$form->id}}">Responder</a>
									@endif
									</td>
								<td><a href="{{URL::to('/UseFormAnswers/')}}/{{$form->id}}">Respuestas</a></td>
						
							</tr>
							
							
						@endforeach  
						</tbody>

				</table>
	</div>
	  </div>
	    
</div>

</body>
@endsection
