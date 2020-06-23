@extends('layouts_template.app') <!-- template -->

@section('content')
<body>


<div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-user"></i> Registro de Usuarios</div>



  <div class="panel-body">


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               
				
		        <div class="card-body">
                    <form method="POST" action="{{ route('storeUsers') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" value="{{ old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
	

  <div class="form-group row">
  
    <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Clase de Usuario') }}</label>
  <div class="col-md-6">
  <select class="custom-select" id="type" name= "type" value="{{ old('type') }}" >
    <option  value= '' selected>Seleccionar...</option>
    <option value='0'>Administrador</option>
    <option value='1'>Evaluador</option>
    <option value='2'>Personal</option>
	<option value='3'>Evaluador Externo</option>

  </select>
  </div>
</div>

				

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8">
							<a href="{{ URL::previous() }}"  type="button"  class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                <button type="submit" class="btn btn-info" ><i class="glyphicon glyphicon-ok-circle"></i> 
                                    {{ __('Registrar') }}
                                </button>  
								<a href="{{ URL::current() }}"  type="button"  class="btn btn-danger"><i class="glyphicon glyphicon-ban-circle"></i> Cancelar</a>
								</div>
						</div>
							
                            </div>
							
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
@endsection
