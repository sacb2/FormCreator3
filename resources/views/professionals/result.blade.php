@extends('theme.default')


@section('content')


<body>

<div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-user"></i> Resultado Profesionales</div>
  <div class="panel-body">
<!-- Search form -->
 <form role="form" id="register-form" autocomplete="off" action="{{route('professionalsResult')}}" method="post" class="navbar-form navbar-left">
 @csrf <!-- {{ csrf_field() }} -->   
 <div class="form-group">
 <input name="Search" type="text" class="form-control" placeholder="Buscar R.U.T.">
 </div>
<button type="submit" class="btn btn-info">
		<i class="glyphicon glyphicon-log-in"></i> Buscar </button>

	  </form>


		@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>No encontrado</li>
        </ul>
    </div>
		@endif
<!-- Search form -->
@if(isset($beneficiarie))

    <table class="table">
  <thead>
    <tr>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">R.U.T.</th>
	  <th scope="col">Telefonos</th>
	  <th scope="col">Direccion</th>
	  <th scope="col">Fecha Nacimiento</th>
    </tr>
  </thead>
 
  <tbody>
    <tr>
      <td>{{$beneficiarie->name1}} {{$beneficiarie->name2}}</td>
      <td>{{$beneficiarie->lname1}} {{$beneficiarie->lname2}}</td>
      <td>{{$beneficiarie->rut}}</td>
	  <td>{{$beneficiarie->phone1}} | {{$beneficiarie->phone2}}</td>
	  <td>{{$beneficiarie->address}}</td>
	<td>{{$beneficiarie->birth_date}}</td>
		  
	      
	  
    </tr>
    </tbody>

</table>
@else
<td>No econtrado</td>
@endif
</div>
</div>
</body>
@endsection
