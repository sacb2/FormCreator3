@extends('layouts_template.app') <!-- template -->



@section('content')


<body>


	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-user"></i> Listar Respuestas><i class="fa fa-save"></i></a></div>
		<div class="panel-body">
            @if(isset($answersById))
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
                            <th scope="col">Id Respuesta</th>
                            <th scope="col">Id Persona</th>
							<th scope="col">Nombre Pregunta</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Respuesta</th>
							<th scope="col">Ver</th>
						</tr>
					</thead>

					<tbody>
                        @foreach($answersById as $answers)
                            @foreach($answers as $answer)
						<tr>
                            <td>{{$answer->id_requerimiento}}</td>
                            <td>{{$answer->rut_persona}}</td>
							<td>{{$answer->question->question->nombre}}</td>
							@if($answer->question->question->tipo==1)
							<td>Texto</td>
							@elseif($answer->question->question->tipo==2)
                            <td>Seleccion Múltiple</td>
                            @elseif($answer->question->question->tipo==3)
							<td>Imagen</td>
							@else
							<td>{{$answer->question->question->tipo==3}}</td>
							@endif
                            <td>
                                @if($answer->question->question->tipo==1)
                                {{$answer->texto_respuesta}}
                                @elseif($answer->question->question->tipo==2)
                                {{$answer->valor_respuesta}}
                                @elseif($answer->question->question->tipo==3)
                                {{$answer->valor_respuesta}}
                                @else
                                {{$answer->texto_respuesta}}
                                {{$answer->valor_respuesta}}
                                @endif
                            </td>
                            <td>
                                @if($answer->question->question->tipo==3)
                               <img width="100" height="100" src="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" alt="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" class="img-thumbnail">
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
					</tbody>

				</table>
            </div>
            @else
            No hay respuestas ingresadas
            @endif
		</div>

	
	</div>

</body>
@endsection