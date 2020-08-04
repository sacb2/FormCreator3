@extends('layouts_template.app') <!-- template -->


@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Editar Formulario</div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">


                            <div class="card-body">
                                <form method="POST" action="{{ route('UpdateForms') }}">
                                    @csrf


                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{$form->nombre}}" ?? "{{ old('name') }}" required
                                                autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>

                                        <div class="col-md-6">
                                            <input id="description" type="text"
                                                class="form-control @error('description') is-invalid @enderror" name="description"
                                                value="{{$form->description }}" required autocomplete="description" autofocus>

                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <input name="id" type="hidden" value="{{$form->id}}">


                                    <div class="form-group row">

                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="state" name="state"
                                                value="{{$form->estado}}" ??"{{ old('state') }}">
                                                @if($form->estado == 1)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1' selected>Activo</option>
                                                <option value='2'>Inactivo</option>

                                                @elseif($form->estado== 2)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2' selected>Inactivo</option>
                                                @else
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2'>Inactivo</option>


                                                @endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Utilizar R.U.T.') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="type" name="type"
                                                value="{{$form->tipo}}" ??"{{ old('state') }}">
                                                @if($form->tipo == 1)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1' selected>Activo</option>
                                                <option value='2'>Inactivo</option>

                                                @elseif($form->tipo== 2)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2' selected>Inactivo</option>
                                                @else
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2'>Inactivo</option>


                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                   
                                        <label for="grouped"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Agrupado') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="grouped" name="grouped"
                                                value="{{$form->grouped}}" ??"{{ old('grouped') }}">
                                                @if($form->grouped == 1)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1' selected>Activo</option>
                                                <option value='2'>Inactivo</option>

                                                @elseif($form->grouped== 2)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2' selected>Inactivo</option>
                                                @else
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2'>Inactivo</option>


                                                @endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                   
                                        <label for="evaluacion"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Evaluación') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="evaluacion" name="evaluacion"
                                                value="{{$form->evaluacion}}" ??"{{ old('grouped') }}">
                                                @if($form->evaluacion == 1)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1' selected>Activo</option>
                                                <option value='2'>Inactivo</option>

                                                @elseif($form->evaluacion== 2)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2' selected>Inactivo</option>
                                                @else
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2'>Inactivo</option>


                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Cantidad de respuestas por usuario') }}</label>
                                        <div class="col-md-6">
                                            <input id="qanswer" type="number"
                                                class="form-control @error('qanswer') is-invalid @enderror" name="qanswer"
                                                value="{{ $form->qanswer }}" required autocomplete="qanswer" autofocus>
                                            @error('qanswer')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group row mb-0">
                                        <div class="col-md-8">
                                            <a href="{{ URL::previous() }}" type="button" class="btn btn-warning"><i
                                                    class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                            <button type="submit" class="btn btn-info"><i
                                                    class="glyphicon glyphicon-ok-circle"></i>
                                                {{ __('Actualizar') }}
                                            </button>
                                            <a href="{{ URL::current() }}" type="button" class="btn btn-danger"><i
                                                    class="glyphicon glyphicon-ban-circle"></i> Cancelar</a>
                                        </div>
                                    </div>




                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
@endsection