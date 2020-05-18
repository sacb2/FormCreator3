@extends('layouts.app')


@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> {{ __('newuser.edirusua') }} </div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                            @if (count($datos) > 0)
                            <form method="POST" action="{{ route('EditUniqueNewUser') }}">
                                                    @csrf

                                                    <div class="form-group row">
                                                        <label class="col-md-4 col-form-label text-md-right">{{ __('newuser.mensaje1') }} (*)</label>

                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('newuser.nombres') }} (*)</label>

                                                        <div class="col-md-6">
                                                            <input id="name" type="text" size="50" maxleght="50" placeholder="{{ __('newuser.mensaje2') }}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $datos['nombres'] }}" autocomplete="name" autofocus required>

                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ __($message ) }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('newuser.apellido') }} (*)</label>
                                                        <div class="col-md-6">
                                                            <input id="surname" type="text" size="50" maxleght="50" placeholder="{{ __('newuser.mensaje2') }}" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ $datos['apellidos'] }}" autocomplete="surname" autofocus required>
                                                            @error('surname')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{__($message ) }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="identifier" class="col-md-4 col-form-label text-md-right">{{ __('newuser.rut') }} (*)</label>
                                                        <div class="col-md-6">
                                                            <input id="identifier" type="text" size="10" maxleght="10" placeholder="{{ __('newuser.mensaje3') }}" class="form-control @error('identifier') is-invalid @enderror @error('validarut') is-invalid @enderror" name="identifier" value="{{ $datos['rut'] }}" title="Sin puntos y con digito verificador Ej:123456-0"
                                                                pattern="^[0-9]+[-|‐]{1}[0-9kK]{1}$" readonly>
                                                            @error('identifier')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ __($message ) }}</strong>
                                                                </span>
                                                            @enderror
                                                            @error('validarut')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ __($message )}}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('newuser.direccion') }} (*)</label>
                                                        <div class="col-md-6">
                                                            <input id="address" type="text" size="150" maxlength="150"  placeholder="{{ __('newuser.mensaje4') }}" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $datos['direccion'] }}" required autocomplete="address" autofocus>
                                                            @error('address')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('newuser.telefono') }} 1 (*)</label>

                                                        <div class="col-md-6">
                                                            <input id="phone" type="text" size="9" maxlength="9"  placeholder="{{ __('newuser.mensaje5') }}"  class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $datos['telefono1'] }}" pattern="[0-9]{9}" required autocomplete="phone" autofocus>
                                                            @error('phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="phone1" class="col-md-4 col-form-label text-md-right">{{ __('newuser.telefono') }} 2</label>

                                                        <div class="col-md-6">
                                                            <input id="phone1" type="text" size="9" maxlength="9"  placeholder="{{ __('newuser.mensaje5') }}"  class="form-control" name="phone1" value="{{ $datos['telefono2'] }}" pattern="[0-9]{9}"  autocomplete="phone1" autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('newuser.fechadenac') }} (*)</label>

                                                        <div class="col-md-6">
                                                            <input id="birthdate" type="text" size="10" maxlength="10"  placeholder="{{ __('newuser.mensaje6') }}"  class="form-control datepicker" name="birthdate" pattern="^(0[1-9]|[12][0-9]|3[01])[/.](0[1-9]|1[012])[/.](19|20)\d\d$" required autofocus>
                                                            @error('birthdate')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <script>window.addEventListener('load', function() {
                                                            $('#birthdate').datepicker({
                                                                format:'dd/mm/yyyy', language: '{{ str_replace('_', '-', app()->getLocale()) }}'
                                                            }).datepicker("setDate",'{{ $datos['fechnac'] }}');
                                                        })</script>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('newuser.email') }} (*)</label>

                                                        <div class="col-md-6">
                                                            <input id="email" type="text" size="50" maxlength="50"  placeholder="{{ __('newuser.mensaje7') }}"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $datos['email'] }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  readonly>

                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                   <input type="hidden" name="id" id="id" value="{{ $datos['id'] }}'">
                                                    
                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-6 offset-md-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Register') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-4 col-form-label text-md-right">{{ __('newuser.mensaje1') }} (*)</label>

                                                    </div>



                                                </form>
                            @else
                            {{ __('newuser.sinregistros') }}
                            @endif
                            
                                            





                                
                            </div>

                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
@endsection