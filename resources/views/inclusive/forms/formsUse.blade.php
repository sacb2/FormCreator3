@extends('layouts_template.app') <!-- template -->

@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Responder Formulario</div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST"  action="{{ route('AnswerFormUseStore') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}


                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <input name="id_form" type="hidden" value="{{$formulario->id}}">
                                    <input name="type_form" type="hidden" value="{{$formulario->tipo}}">



                            </div>
                        </div>
                        <div>
                            <p class="text-justify">Preguntas: </p>
                            <div>

                                @if($formulario->tipo==1)
                                <div class="form-group">
                                    <label for="id_label" class="col-2 col-form-label">*R.U.T. (Ej:123456-0)</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span
                                                class="glyphicon glyphicon-list-alt"></span></div>
                                        <input required name="rut"
                                            title="Sin puntos y con digito verificador Ej:123456-0"
                                            pattern="^[0-9]+[-|‐]{1}[0-9kK]{1}$" type="text" maxlength="10"
                                            value="{{ old('rut') }}" style="text-transform:uppercase"
                                            class="form-control" placeholder="rut">
                                    </div>
                                    <span class="help-block" id="error"></span>
                                </div>
                                @endif





                                @foreach($formulario->questions as $pregunta)
                                @if($pregunta->estado==1)
                                @if($pregunta->question->tipo==2)

                                <div class="form-group row">

                                    <label for="answers[{{$pregunta->id}}]"
                                        class="col-md-4 col-form-label text-md-right">{{$pregunta->question->pregunta}}</label>
                                    <div class="col-md-6">
                                        <select class="custom-select" id="answers_int[{{$pregunta->id}}]"
                                            name="answers_int[{{$pregunta->id}}]" value="{{ old('state') }}">
                                            <option value='' selected>Seleccionar...</option>
                                            @foreach($pregunta->question->answers as $answer)
                                            @php
                                            $answer_data = json_encode(array('value'=>$answer->valor_respuesta,'id'=>$answer->id));
                                            @endphp
                                            <option value='{{$answer_data}}'>{{$answer->texto_respuesta}}
                                            </option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>

                                @elseif($pregunta->question->tipo==3)
                                <div align="left" class="form-group{{ $errors->has('attachment') ? ' has-error' : '' }}">
                                    <label for="attachment"  class="col-md-4 control-label">Adjuntar {{$pregunta->question->pregunta}}:</label>
    
                                    <div align="left" class="col-md-6">
                                      Tamaño máximo de adjunto 7MB <input id="answers_img[{{$pregunta->id}}]" type="file" class="form-control" name="answers_img[{{$pregunta->id}}]" required>
    
                                        @if ($errors->has('attachment'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('attachment') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="comment">{{$pregunta->question->pregunta}}</label>
                                    <textarea class="form-control" rows="5" maxlength="6666"
                                        name="answers_text[{{$pregunta->id}}]'" id="{{$pregunta->id}}'"></textarea>
                                </div>
                                @endif
                                @endif
                                @endforeach






                            </div>
                        </div>
                        </br>

                        </br>



                        <div class="form-group row mb-0">
                            <div class="col-md-8">
                                <a href="{{ url('/SelectForms/') }}" role="button" type="button" class="btn btn-warning"><i
                                        class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                <button type="submit" role="button" class="btn btn-info"><i class="glyphicon glyphicon-ok-circle"></i>
                                    {{ __('Agregar') }}
                                </button>
                                <a href="{{ URL::current() }}" role="button" type="button" class="btn btn-danger"><i
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