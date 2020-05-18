@extends('layouts_template.app') <!-- template -->




@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Editar Respuesta</div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">


                            <div class="card-body">
                                <form method="POST" action="{{ route('UpdateAnswers') }}">
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
                                            <input id="answertext" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="answertext" value="{{$answer->texto_respuesta}}" required
                                                autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <input name="id" type="hidden" value="{{$answer->id}}">


                                    <div class="form-group">
                                        <label for="comment">Valor:</label>
                                        <input class="form-control" type="number" name="answervalue"
                                            value="{{$answer->id_respuesta}}"></input>
                                    </div>


                                    <div class="form-group row">

                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                        <div class="col-md-6">
                                            <select class="custom-select" id="state" name="state"
                                                value="{{$answer->estado}}" ??"{{ old('state') }}">
                                                @if($answer->estado == 1)
                                                <option value=''>Seleccionar...</option>
                                                <option value='1' selected>Activo</option>
                                                <option value='2'>Inactivo</option>

                                                @elseif($answer->estado== 2)
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