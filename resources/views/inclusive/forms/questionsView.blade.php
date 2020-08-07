@extends('layouts_template.app') <!-- template -->




@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Editar Pregunta</div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">


                            <div class="card-body">
                                <form enctype="multipart/form-data" method="POST" action="{{ route('UpdateQuestions') }}">
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
                                                value="{{$question->nombre}}" ?? "{{ old('name') }}" required
                                                autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <input name="id" type="hidden" value="{{$question->id}}">

                                    <div class="form-group">
                                        <label for="comment">Pregunta:</label>
                                        <textarea class="form-control" rows="5" maxlength="7000" name="question"
                                            id="question">{{$question->pregunta}}</textarea>
                                    </div>


                                    <div class="form-group row">

                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="state" name="state"
                                                value="{{$question->estado}}" ??"{{ old('state') }}">
                                                @if($question->estado == 1)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1' selected>Activo</option>
                                                <option value='2'>Inactivo</option>

                                                @elseif($question->estado== 2)
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

                                        <label for="required"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Requerido') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="required" name="required"
                                                value="{{$question->required}}" ??"{{ old('state') }}">
                                                @if($question->required == 1)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1' selected>Activo</option>
                                                <option value='2'>Inactivo</option>

                                                @elseif($question->required== 2)
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
                                    <div>
                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Tipo respuesta') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="type" name="type"
                                                value="{{ old('type') }}">
                                                @if($question->tipo == 1)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1' selected>Texto</option>
                                                <option value='2'>Selección múltiple</option>
                                                <option value='3'>Imagen</option>
                                                <option value='6'>Info</option>
                                                <option value='7'>Selección Multiple Varias</option>

                                                @elseif($question->tipo== 2)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1'>Texto</option>
                                                <option value='2' selected>Selección múltiple</option>
                                                <option value='3'>Imagen</option>
                                                <option value='6'>Info</option>
                                                <option value='7'>Selección Multiple Varias</option>
                                                @elseif($question->tipo== 3)
                                                <option value='' >Seleccionar...</option>
                                                <option value='1'>Texto</option>
                                                <option value='2'>Selección múltiple</option>
                                                <option value='3' selected>Imagen</option>
                                                <option value='6'>Info</option>
                                                <option value='7'>Selección Multiple Varias</option>
                                                @elseif($question->tipo== 6)
                                                <option value='' >Seleccionar...</option>
                                                <option value='1'>Texto</option>
                                                <option value='2'>Selección múltiple</option>
                                                <option value='3'>Imagen</option>
                                                <option value='6' selected>Info</option>
                                                <option value='7'>Selección Multiple Varias</option>
                                                @elseif($question->tipo== 7)
                                                <option value='' >Seleccionar...</option>
                                                <option value='1'>Texto</option>
                                                <option value='2'>Selección múltiple</option>
                                                <option value='3'>Imagen</option>
                                                <option value='6' >Info</option>
                                                <option value='7' selected>Selección Multiple Varias</option>
                                                @else
                                                <option value='' selected>Seleccionar...</option>
                                                <option value='1'>Texto</option>
                                                <option value='2'>Selección múltiple</option>
                                                <option value='3'>Imagen</option>
                                                <option value='6'>Info</option>
                                                <option value='7'>Selección Multiple Varias</option>

                                                @endif

                                            </select>
                                        </div>
                                        <div class="form-group row">

                                            <label for="state"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Orden de aparición') }}</label>
                                            <div class="col-md-6">
                                                <input id="size" type="number"
                                                    class="form-control @error('orden') is-invalid @enderror" name="orden"
                                                    value="{{$question->orden}}" required autocomplete="orden" autofocus>
                                                @error('orden')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                    <div class="form-group row">

                                        <label for="edad"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Edad<') }}</label>
                                        <div class="col-md-6">
                                            <input id="edad_max" type="number"
                                                class="form-control @error('edad') is-invalid @enderror" name="edad_max"
                                                value="{{$question->edad_max}}" required autocomplete="edad_max" autofocus>
                                            @error('edad_max')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label for="edad"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Edad>') }}</label>
                                        <div class="col-md-6">
                                            <input id="edad_min" type="number"
                                                class="form-control @error('edad') is-invalid @enderror" name="edad_min"
                                                value="{{$question->edad_min}}" required autocomplete="edad_min" autofocus>
                                            @error('edad_min')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                        <div class="form-group row">

                                            <label for="state"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Tamaño respuesta') }}</label>
                                            <div class="col-md-6">
                                                <input id="size" type="number"
                                                    class="form-control @error('size') is-invalid @enderror" name="size"
                                            value="{{$question->size}}" required autocomplete="size" autofocus>
                                                @error('size')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div align="left"
                                        class="form-group row{{ $errors->has('attachment') ? ' has-error' : '' }}">
                                        <label role="contentinfo" tabindex="0" for="attachment"
                                            class="col-md-4 col-form-label">Adjuntar:</label>
    
                                        <div align="left" class="col-md-6">
                                            Tamaño máximo de adjunto 7MB <input role="button"
                                                id="attachment" type="file" class="form-control"
                                                name="attachment">
    
                                            @if ($errors->has('attachment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('attachment') }}</strong>
                                            </span>
                                            @endif
                                        </div>
    
                                    </div>
                                    </div>
                                    </br>

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