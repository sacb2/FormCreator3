@extends('layouts.app_new_new') <!-- template -->

@section('content')


<body>


	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-user"></i> Listar Respuestas><i class="fa fa-save"></i></a></div>
        <div class="panel-heading"><i class="fa fa-user"></i> Evaluar Respuestas con Rubricas  | <a href="{{URL::to('/AutoEvaluateForm/')}}/{{$form->id}}"><i class="fa fa-save"></i> Evaluar</a></div>
        

		<div class="panel-body">
				
					<br>
					
					<div><i class="fa fa-user"></i> Nombre: {{$form->name}} ></a></div>
					<div><i class="fa fa-user"></i> Descripción:  {{$form->descripcion}}></a></div>

	
			@if(isset($answers))
			
		
					
						@foreach($answersId as $answerId)
						
						<div id="accordion">
							<div class="card">
							  <div class="card-header" id="headingOne">
								<h5 class="mb-0">
								  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne{{$answerId}}" aria-expanded="true" aria-controls="collapseOne{{$answerId}}">
									Requerimiento: {{$answerId}}

									
                                        <button aria-label="Habilidades"  role="button" type="button" title="Revisión de habilidades" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#abilityModal{{$answerId}}">
                                        <i alt="Habilidades" class="fas fa-edit"></i>
                                        </button>


								  </button>
								</h5>
							  </div>
							  
							  <div id="collapseOne{{$answerId}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="card-body">
									@php
									$a=0;
									@endphp
									@foreach($answers as $answer)
									@if($answer->id_requerimiento==$answerId)

									Estado:
									@if($answer->evaluation==null&&$a!=$answerId)
									Pendiente
									@elseif($a!=$answerId)
									{{$answer->evaluation->observacion}} Con Puntaje: {{$answer->evaluation->evaluacion}}
									@endif
									<br>
									@php
									$a=$answerId;
									@endphp
									<br>
									Pregunta: 
									{{$answer->question->question->nombre}}
									Tipo de Pregunta:
									@if($answer->question->question->tipo==1)
									Texto
									@elseif($answer->question->question->tipo==2)
									Seleccion Múltiple
									@elseif($answer->question->question->tipo==3)
									Imagen
									@else
									{{$answer->question->question->tipo}}
									@endif
									
									Respuesta: 
									@if($answer->question->question->tipo==1)
										@if(isset($answer->texto_respuesta))
											{{$answer->texto_respuesta}}
										@endif
                                	@elseif($answer->question->question->tipo==2)
                                		<!--{{$answer->respuesta_number}}-->
                                	@elseif($answer->question->question->tipo==3)
                              			<!--  {{$answer->respuesta_number}} -->
									@else
										@if(isset($answer->texto_respuesta))
											{{$answer->texto_respuesta}}
										@endif
                                		<!--{{$answer->respuesta_number}}-->
									@endif
									<!--Respuesta Imagen -->
									Respuesta Imagen:
									@if($answer->question->question->tipo==3)
								@if(isset($answer->document->nombre))
								<a href="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" download='{{$answer->document->nombre}}'> 
							   <img width="100" height="100" src="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" alt="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" class="img-thumbnail">
								</a>
								@endif
							   
							   @elseif($answer->question->question->tipo==2)
							  
							   @if(isset($answer->answer_number->texto_respuesta))
							    {{$answer->answer_number->texto_respuesta}}
								@endif
							   
							   @elseif($answer->question->question->tipo==1)
							   {{$answer->respuesta_text}}

								@endif
                                <!-- Respuesta Imagen -->
                                <!-- Evalaucion-->
                                Evaluación:
                                @if($answer->evaluacion==null)
                                Sin Evaluación
                                @else
                                {{$answer->evaluacion}}
                                @endif
                                <!-- Evalaucion-->
								@endif
								@endforeach
								</div>
							  </div>
						


							</div>
							</div>
					
						  
					
						@endforeach
			
				
            </div>
            @else
            No hay respuestas ingresadas
            @endif
		</div>
	
		
	
	</div>

</body>

<!--Modal que muestra habilidades -->
@if(isset($answers))
@foreach($answersId as $answerId)

<div class="modal fade" id="abilityModal{{$answerId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{$answerId}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
			<label for="comment">Pregunta </label>
			<form method="POST" action="{{ route('UpdateEvaluation') }}">
				@csrf
			<input name="id_requirement" type="hidden" value="{{$answerId}}">

           
				Pregunta: 
				{{$answer->question->question->nombre}}
				Tipo de Pregunta:

				<table class="table table-bordered">
					<thead>
					  <tr>
						<th scope="col">Id Respuesta</th>
						<th scope="col">Nombre Pregunta</th>
						<th scope="col">Tipo de Pregunta</th>
						<th scope="col">Respuesta</th>
						<th scope="col">Evaluación</th>
					  </tr>
					</thead>
					@foreach($answers as $answer)
			@if($answer->id_requerimiento==$answerId)
					<tbody>
					  <tr>
						<th scope="row">{{$answer->answer_id}}</th>
						<td>{{$answer->question->question->nombre}}</td>
						<td>@if($answer->question->question->tipo==1)
							Texto
							@elseif($answer->question->question->tipo==2)
							Seleccion Múltiple
							@elseif($answer->question->question->tipo==3)
							Imagen
							@else
							{{$answer->question->question->tipo}}
							@endif
							</td>
						<td>	@if($answer->question->question->tipo==1)
							@if(isset($answer->texto_respuesta))
								{{$answer->texto_respuesta}}
							@endif
						@elseif($answer->question->question->tipo==2)
							<!--{{$answer->respuesta_number}}-->
						@elseif($answer->question->question->tipo==3)
							  <!--  {{$answer->respuesta_number}} -->
						@else
							@if(isset($answer->texto_respuesta))
								{{$answer->texto_respuesta}}
							@endif
							<!--{{$answer->respuesta_number}}-->
						@endif
						<!--Respuesta Imagen -->
						Respuesta Imagen:
						@if($answer->question->question->tipo==3)
					@if(isset($answer->document->nombre))
					<a href="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" download='{{$answer->document->nombre}}'> 
				   <img width="100" height="100" src="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" alt="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" class="img-thumbnail">
					</a>
					@endif
				   
				   @elseif($answer->question->question->tipo==2)
				  
				   @if(isset($answer->answer_number->texto_respuesta))
					{{$answer->answer_number->texto_respuesta}}
					@endif
				   
				   @elseif($answer->question->question->tipo==1)
				   {{$answer->respuesta_text}}

					@endif
					<!-- Respuesta Imagen --></td>
						<td>  
							<div class="form-group row">
								<div class="col-md-6">
									<input id="group" type="number"
										class="form-control @error('rubric') is-invalid @enderror" name="EvaluateDep[{{$answer->id}}]"
										value='{{$answer->evaluacion}}'  autocomplete="group" autofocus>
									@error('group')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
							</div>
							



							
							</td>
					  </tr>
				
					</tbody>
					@endif
			@endforeach
       
				  </table>

			
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		  <button type="submit" name="estado" value='actualizar' class="btn btn-secondary" >Actualizar</button>
		  <button type="submit" name="estado" value='aceptar' class="btn btn-secondary" >Aceptar</button>
		  <button type="submit" name="estado" value='rechazar' class="btn btn-secondary" >Rechazar</button>
		  </div>
	</form>
      </div>
    </div>
  </div>
 
  @endforeach
@endif

  <!-- Modal de abilidade-->
@endsection