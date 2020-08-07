@extends('layouts_template.app') <!-- template -->



@section('content')


<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Listar Preguntas | <a href="{{ route('CreateQuestion') }}"><i class="fa fa-save"></i> Crear</a></div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Orden</th>
                            <th scope="col">Opciones</th>
                            <th scope="col">Alternativas</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($questions as $question)
                        <tr>
                            <td>{{$question->id}}</td>
                            <td>{{$question->nombre}}</td>
                            @if($question->estado==1)
                            <td>Activo</td>
                            @elseif($question->estado==2)
                            <td>Inactivo</td>
                            @else
                            <td>{{$question->estado}}</td>
                            @endif
                            <td>{{$question->tipo}}</td>
                            <td>{{$question->orden}}</td>

                            <td><a href="{{URL::to('/ViewQuestions/')}}/{{$question->id}}"><i class="fas fa-pen"></i> Editar</a>
                                
                                @if($question->tipo==2||$question->tipo==7)
                                <br>
                                <a href="{{URL::to('/AnswersQuestionRelation/')}}/{{$question->id}}"><i class="fas fa-tasks"></i>Alternativas</a>
                                    @endif
                            </td>
                            <td>
                                @if($question->tipo==2||$question->tipo==7)
                                @foreach($question->answers as $answer)
                                {{$answer->valor_respuesta}}=
                                {{$answer->texto_respuesta}};
                                @endforeach
                                @endif
                            </td>

                               

                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        {{$questions->links()}}
    </div>

</body>
@endsection