@extends('layouts_template.app')

@section('content')


<body>


	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-user"></i> Listar Respuestas><i class="fa fa-save"></i></a></div>

		<div class="panel-body">
					<!-- Search form -->
					<form role="form" id="register-form" autocomplete="off" action="{{route('personalizedFormAnswersSearch')}}" method="post">
						@csrf <!-- {{ csrf_field() }} -->   
						<div class="col-xs-2">
						<input name="Search" type="text" class="form-control" placeholder="Buscar R.U.T.">
						</div>
					   <button type="submit" class="btn btn-info">
							   <i class="glyphicon glyphicon-log-in"></i> Buscar </button>
								  <input name="id" type="hidden" value="{{$id}}">
							   <input name="perPage" type="hidden" value="{{$perPage}}">
							   <input name="lastPage" type="hidden" value="{{$lastPage}}">
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
			
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Id Respuesta</th>
							<th scope="col">Fecha</th>
                            <th scope="col">Id Persona</th>
							<th scope="col">Nombre Pregunta</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Respuesta</th>
							<th scope="col">Ver</th>
							
							
						</tr>
					</thead>

					<tbody>
					@foreach($answerById_paginate as $answersById)
                        @foreach($answersById as $answers)
                            @foreach($answers->WhereNotIn('state_id',1) as $answer)
						<tr>
							<td>{{$answer->id_requerimiento}}</td>
							<td>{{$answer->updated_at}}</td>
                            <td>{{$answer->rut_persona}}</td>
							<td>{{$answer->question->question->nombre}}</td>
							@if($answer->question->question->tipo==1)
							<td>Texto</td>
							@elseif($answer->question->question->tipo==2)
                            <td>Seleccion Múltiple</td>
                            @elseif($answer->question->question->tipo==3)
							<td>Imagen</td>
							@else
							<td>{{$answer->question->question->tipo}}</td>
							@endif
                            <td>
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
                            </td>
                            <td>
								@if($answer->question->question->tipo==3)
								<a href="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" download='{{$answer->document->nombre}}'> 
							   <img width="100" height="100" src="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" alt="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" class="img-thumbnail">
								</a>
							   
							   @elseif($answer->question->question->tipo==2)
							  
							   @if(isset($answer->answer_number->texto_respuesta))
							    {{$answer->answer_number->texto_respuesta}}
								@endif
							   
							   @elseif($answer->question->question->tipo==1)
							   {{$answer->respuesta_text}}

                                @endif
                            </td>
							</td>
							@if(isset($answer->questions))
							<td>@foreach($answer->questions as $question)

								@if($question->estado==1)
								{{$question->question->nombre}},
								@endif
								@endforeach</td>
							@endif
						</tr>

                            @endforeach
						@endforeach
					@endforeach
					</tbody>

				</table>
		
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