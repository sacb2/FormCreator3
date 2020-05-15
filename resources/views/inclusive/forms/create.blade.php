@extends('layouts.app')
@section('content')

<body>
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Registro de Preguntas</div>
        <div class="panel-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('StoreQuestion') }}">
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
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Pregunta:</label>

                                        <textarea class="form-control" rows="5" maxlength="7000" name="question"
                                            id="question"></textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="state" name="state"
                                                value="{{ old('state') }}">
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2'>Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Tipo respuesta') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="type" name="type"
                                                value="{{ old('type') }}">
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Texto</option>
                                                <option value='2'>Selección múltiple</option>
                                                <option value='3'>Imagen</option>
                                                <option value='4'>Documento</option>
                                                <option value='5'>Archivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8">
                                            <a href="{{ URL::previous() }}" type="button" class="btn btn-warning"><i
                                                    class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                            <button type="submit" class="btn btn-info"><i
                                                    class="glyphicon glyphicon-ok-circle"></i>
                                                {{ __('Crear') }}
                                            </button>
                                            <a href="{{ URL::current() }}" type="button" class="btn btn-danger"><i
                                                    class="glyphicon glyphicon-ban-circle"></i> Cancelar</a>
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