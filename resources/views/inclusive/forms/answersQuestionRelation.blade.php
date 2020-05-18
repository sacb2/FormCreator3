@extends('layouts_template.app') <!-- template -->


@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Agregar respuestas a la pregunta</div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">


                            <div class="card-body">
                                <form method="POST" action="{{ route('AnswersQuestionStore') }}">
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
                                            <input readonly id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{$pregunta->nombre}}" ?? "{{ old('nombre') }}" required
                                                autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <input name="id" type="hidden" value="{{$pregunta->id}}">


                      
                                    <div>
                                        <p class="text-justify">Seleccione las alternativas que tendrá la pregunta:
                                        </p>
                                        <div>
                                            @foreach($respuestas as $respuesta)

                                            <input type="checkbox" name="pickedDep[]" id="pickedDep1"
                                                value='{{$respuesta->id}}'> {{$respuesta->texto_respuesta}},
                                            Valor:{{$respuesta->id_respuesta}}</input><br>

                                            @endforeach
                                        </div>
                                    </div>


                                    <div class="form-group row mb-0">
                                        <div class="col-md-8">
                                            <a href="{{ URL::previous() }}" type="button" class="btn btn-warning"><i
                                                    class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                            <button type="submit" class="btn btn-info"><i
                                                    class="glyphicon glyphicon-ok-circle"></i>
                                                {{ __('Agregar') }}
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