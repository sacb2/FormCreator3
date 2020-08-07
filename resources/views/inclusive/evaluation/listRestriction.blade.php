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
							<th scope="col">id_persona</th>
							<th scope="col">id_restriccion</th>
                            <th scope="col">id_status</th>
                            <th scope="col">actualizar</th>
						</tr>
					</thead>

					<tbody>
						@foreach($lists as $list)
						<tr>
							<td>{{$list->id_persona}}</td>
						
							<td>{{$list->id_restriccion}}</td>
							
                            <td>@if($list->id_status==1)
                                Activado
                                @elseif($list->id_status==2)
                                Desactivado

                                @else
                                {{$list->id_status}}

                                @endif
                                
                                </td>
                                <td>
                                    <a href="{{URL::to('/ActivateRestriction/')}}/{{$list->id}}">Activar</a>
                                    <a href="{{URL::to('/DeactivateRestriction/')}}/{{$list->id}}">Desactivar</a>
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