@extends('layouts_template.app') <!-- template -->

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
                                <form enctype="multipart/form-data" method="POST" action="{{ route('StoreRestrictionList') }}">
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
                                
                                    <div class="form-group row">
                                        <label for="id_status"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="id_status" name="id_status"
                                                value="{{ old('id_status') }}">
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Activo</option>
                                                <option value='2'>Inactivo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="id_type"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Lista') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="id_type" name="id_type"
                                                value="{{ old('id_type') }}">
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Id_Persona</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                 
                                    <div align="left"
                                    class="form-group row{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                    <label role="contentinfo" tabindex="0" for="csv_file"
                                        class="col-md-4 col-form-label">Cargar Lista:</label>

                                    <div align="left" class="col-md-6">
                                        Tamaño máximo de adjunto 7MB <input role="button"
                                            id="csv_file" type="file" class="form-control"
                                            name="csv_file">

                                        @if ($errors->has('csv_file'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('csv_file') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>



                                    <div class="form-group row mb-0">
                                        <div class="col-md-8">
                                            <a href="{{ URL::previous() }}" role="button" type="button" class="btn btn-warning"><i
                                                    class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                            <button type="submit" role="button" class="btn btn-info"><i
                                                    class="glyphicon glyphicon-ok-circle"></i>
                                                {{ __('Crear') }}
                                            </button>
                                            <a href="{{ URL::current() }}"  role="button" type="button" class="btn btn-danger"><i
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