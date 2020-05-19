@extends('layouts_template.app') <!-- template -->



@section('content')


<body>


	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-user"></i> Listar Formularios  | <a href="{{ route('CreateForms') }}"><i class="fa fa-save"></i> Crear</a></div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
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

							<td><a href="{{URL::to('/ViewForms/')}}/{{$form->id}}">Editar</a></td>
							<td><a href="{{URL::to('/QuestionsFormRelation/')}}/{{$form->id}}">Modificar Preguntas</a>
							</td>
							@if(isset($form->questions))
							<td>@foreach($form->questions as $question)

								@if($question->estado==1)
								{{$question->question->nombre}},
								@endif
								@endforeach</td>
							@endif
						</tr>


						@endforeach
					</tbody>

				</table>
			</div>
		</div>

		{{$forms->links()}}
	</div>

</body>
@endsection