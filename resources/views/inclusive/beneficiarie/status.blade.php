@extends('layouts.app_new_new') <!-- template -->

@section('content')


<body>


	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-user"></i> Listar Respuestas><i class="fa fa-save"></i></a></div>

		<div class="panel-body">
				
					<br>
					
					<div><i class="fa fa-user"></i> Nombre: {{$persona->name}} {{$persona->lastname}}></a></div>
					<div><i class="fa fa-user"></i> Identificador:  {{$persona->rut}}></a></div>

	
			@if(isset($answers))
			
		
					
						@foreach($answersId as $answerId)
						
						<div id="accordion">
							<div class="card">
							  <div class="card-header" id="headingOne">
								<h5 class="mb-0">
								  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne{{$answerId}}" aria-expanded="true" aria-controls="collapseOne{{$answerId}}">
									Requerimiento: {{$answerId}}
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
@endsection