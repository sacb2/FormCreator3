@extends('layouts.app')


@section('content')


<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Listar Preguntas</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Ver</th>
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

                            <td><a href="{{URL::to('/ViewQuestions/')}}/{{$question->id}}">Editar</a>
                                @if($question->tipo==2)
                                <a href="{{URL::to('/AnswersQuestionRelation/')}}/{{$question->id}}">Seleccionar
                                    alternativas</a>
                                @foreach($question->answers as $answer)
                                {{$answer->valor_respuesta}}=
                                {{$answer->texto_respuesta}};
                                @endforeach

                                @endif

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