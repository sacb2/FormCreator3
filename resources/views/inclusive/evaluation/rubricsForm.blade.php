@extends('layouts_template.app') <!-- template -->



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
                                <form method="POST" action="{{ route('RubricsFormStore') }}">
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


                                    <div>
                                        <p class="text-justify">Seleccione las preguntas que desea agregar al formulario
                                        </p>
                                        <div>

                                           
                                            @foreach($form->questions as $selectedQ)
                                            @if($selectedQ->estado==1)
                                            

                                      
                                               @if($form->evaluacion==1 & $selectedQ->question->tipo==2)
                                                    <label for="group"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Pregunta Rúbrica:') }} {{$selectedQ->question->nombre}}</label>
                                                
                                               
                                                <br>
                                                
                                                @foreach($selectedQ->question->answers as  $answer)
                                                {{$answer->texto_respuesta}} 
                                                {{$answer->valor_respuesta}}
                                                {{$rubric->where('id_respuesta',$answer->id)->pluck('id_evaluacion')->first()}}
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input id="group" type="number"
                                                            class="form-control @error('rubric') is-invalid @enderror" name="rubricDep[{{$answer->id}}]"
                                                            value='{{$rubric->where('id_respuesta',$answer->id)->pluck('id_evaluacion')->first()}}'  autocomplete="group" autofocus>
                                                        @error('group')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                </div>
                                               

                                                    <label for="state"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Rubrica') }}</label>
                                                    <div class="col-md-6">
                                                        <select class="custom-select" id="id_tipo" name="tipo[{{$answer->id}}]"
                                                          >
                                                         
                                                            <option value='' >Seleccionar...</option>
                                                            <option value='1'>Rango</option>
                                                            <option value='2' selected>Exacto</option>
            
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                @endforeach
                                                 
                       
                                                @endif
                                            @endif
                                            @endforeach
                                       
                                           
                                  
                                               
                                           
                                                <br>
                                         


                                         
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