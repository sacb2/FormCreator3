@extends('layouts_template.app') <!-- template -->



@section('content')


<body>


	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-user"></i> Listar Formularios  | <a href="{{ route('CreateRestrictionList') }}"><i class="fa fa-save"></i> Crear</a></div>
        @if(isset($lists))
        <div class="panel-body">
            
			<div class="table-responsive">

				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Nombre</th>
							<th scope="col">Estado</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Ver</th>
						</tr>
					</thead>

					<tbody>
						@foreach($lists as $list)
						<tr>
							<td>{{$list->nombre}}</td>
							@if($list->id_status==1)
							<td>Activo</td>
							@elseif($list->id_status==2)
							<td>Inactivo</td>
							@else
							<td>{{$list->id_status}}</td>
							@endif

							<td>
								@if($list->id_type==1)
								ID_Personas
								@endif
							</td>
							<td><a href="{{URL::to('/ViewRestrictionList/')}}/{{$list->id}}">Ver Lista</a>
							</td>
							
						</tr>


						@endforeach
					</tbody>

				</table>
            </div>
            
        {{$lists->links()}}
        @else
        No hay listas creadas
        @endif
		</div>

	</div>

</body>
@endsection