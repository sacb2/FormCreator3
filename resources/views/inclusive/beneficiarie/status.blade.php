@extends('layouts.app_new_new') <!-- template -->

@section('content')


<body>


	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-user"></i> Listar Respuestas><i class="fa fa-save"></i></a></div>

		<div class="panel-body">
					<!-- Search form -->
					<form role="form" id="register-form" autocomplete="off" action="{{route('BeneficiarieStatusSearch')}}" method="post">
						@csrf <!-- {{ csrf_field() }} -->   
						<div class="col-xs-2">
						<input name="Search" type="text" class="form-control" placeholder="Buscar R.U.T.">
						</div>
					   <button type="submit" class="btn btn-info">
							   <i class="glyphicon glyphicon-log-in"></i> Buscar </button>
								 
						</form>
					<!-- Search form -->
					<br>
					
   
					@if($search==1)				  
					<a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/10/1">Volver a lista de Resultados</a>
					@endif

					@if($search=='-1')
					<a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/10/1">Volver a lista de Resultados</a>
					No se encontraron resultados
					@endif
			@if(isset($answerById_paginate)&&$search>'-1')
			
		
					@foreach($answerById_paginate as $answersById)
						@foreach($answersById as $answers)
						
						<div id="accordion">
							<div class="card">
							  <div class="card-header" id="headingOne">
								<h5 class="mb-0">
								  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne{{$answers[0]->id_requerimiento}}" aria-expanded="true" aria-controls="collapseOne{{$answers[0]->id_requerimiento}}">
									Requerimiento: {{$answers[0]->id_requerimiento}} Estado: {{$answers[0]->state_id}} Evaluación: {{$answers[0]->state_id}}
								  </button>
								</h5>
							  </div>
							  @foreach($answers->WhereNotIn('state_id',1) as $answer)
							  <div id="collapseOne{{$answer->id_requerimiento}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="card-body">
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
								</div>
							  </div>
							  @endforeach
							</div>
							</div>
					
						  
					
						@endforeach
					@endforeach
				
		
@if($search==0&&$lastPage>1)
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						@if($page<'1')
						@php
						$page=1;
						@endphp
						@endif
						<li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/1">Primera</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/{{$page-1}}">Anterior</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/1">1</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/2">2</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/3">3</a></li>
					  <li class="page-item"><a class="page-link" href="#">...</a></li>
					
					
					  @if($page>$lastPage)
					  @php
					  $page=$lastPage;
					  @endphp
					  @endif
					 
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/{{$lastPage-2}}">{{$lastPage-2}}</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/{{$lastPage-1}}">{{$lastPage-1}}</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/{{$lastPage-1}}">{{$lastPage}}</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/{{$page+1}}">Siguiente</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/{{$lastPage}}">Ultima</a></li>
					  <li class="page-item"><a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/{{$perPage}}/{{$page}}">Actual {{$page}}</a></li>
					</ul>
				  </nav>
@elseif($search==1)				  
<a class="page-link" href="{{URL::to('/PersonalizedFormAnswerPage/')}}/{{$id}}/10/1">Volver a lista de Resultados</a>
@endif
            </div>
            @else
            No hay respuestas ingresadas
            @endif
		</div>
	
		
	
	</div>

</body>
@endsection