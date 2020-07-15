@extends('theme.default')


@section('content')


<body>

<div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-user"></i> Buscar Profesionales</div>
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



  


<!-- Search form -->


 <table class="table">
  <thead>
    <tr>
      <th scope="col">R.U.T.</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
    </tr>
  </thead>
  @foreach($beneficiaries as $beneficiary)
  <tbody>
    <tr>
      <td>{{$beneficiary->rut}}</td>
      <td>{{$beneficiary->name1}}</td>
      <td>{{$beneficiary->lname1}}</td>
	  <td><a href="{{ url('/professionalsView/' . $beneficiary->id . '/') }}" class="btn btn-xs btn-info pull-right">Ver</a></td>
    </tr>
    </tbody>
	@endforeach  
</table>

    
</div>
</div>
</body>
@endsection
