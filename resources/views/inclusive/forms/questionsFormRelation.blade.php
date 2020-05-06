@extends('layouts.app')


@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Agregar preguntas a formulario</div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">


                            <div class="card-body">
                                <form method="POST" action="{{ route('QuestionsFormStore') }}">
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
                                    <input name="id_form" type="hidden" value="{{$form->id}}">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                        <div class="col-md-6">
                                            <input readonly id="name" type="text"
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

                                    <input name="id" type="hidden" value="{{$form->id}}">


                                    <div class="form-group row">

                                        <label for="state"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                        <div class="col-md-6">
                                            <select readonly class="custom-select" id="state" name="state"
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
                                    <div>
                                        <p class="text-justify">Seleccione las preguntas que desea agregar al formulario
                                        </p>
                                        <div>

                                            @foreach($questions as $question)
                                            @php
                                            $a=0;
                                            @endphp
                                            @foreach($form->questions as $selectedQ)
                                            @if($question->id==$selectedQ->id_pregunta&&$selectedQ->estado==1)
                                            <input checked type="checkbox" name="pickedDep[]" id="pickedDep1"
                                                value='{{$question->id}}'> {{$question->nombre}}</input><br>
                                            @php
                                            $a=1;
                                            @endphp
                                            @endif
                                            @endforeach
                                            @if($a==0)
                                            <input type="checkbox" name="pickedDep[]" id="pickedDep1"
                                                value='{{$question->id}}'> {{$question->nombre}}</input><br>
                                            @endif


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