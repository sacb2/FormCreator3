@extends('layouts_template.app') <!-- template -->

@section('content')


<body>


<div class="panel panel-default">
	<div class="panel-heading"><i class="fa fa-user"></i> Listar Usuarios | <a href="{{ route('UserCreate') }}"><i class="fa fa-save"></i> Crear</a></div>
	<div class="panel-body">
  <div class="table-responsive">
    	<table  class="table table-hover">
						<thead >
							<tr>
								<th scope="col">Nombre</th>
								<th scope="col">Apellido</th>
								<th scope="col">Email</th>
								<th scope="col">Teléfono</th>
								<th scope="col">Dirección</th>
								<th scope="col">Fecha Nacimiento</th>
								<th scope="col">Clase</th>
								<th scope="col">Ver</th>
							</tr>
						</thead>

						<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{$user->name}}</td>
								<td>{{$user->lastname}}</td>
								<td>{{$user->email}}</td>
								<td>{{$user->phone}}</td>
								<td>{{$user->address}}</td>
								<td>{{$user->birth_date}}</td>
								<td>{{$user->type_id}}</td>
								<td><a href="{{URL::to('/userView/')}}/{{$user->id}}">Editar</a></td>
								
								

							</tr>
						@endforeach  
						</tbody>

				</table>
	</div>
	  </div>
</div>
{{$users->links()}}
</body>
@endsection
