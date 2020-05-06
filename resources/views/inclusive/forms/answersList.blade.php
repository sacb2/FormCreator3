@extends('layouts.app')


@section('content')


<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Listar Respuestas</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Ver</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($answers as $answer)
                        <tr>
                            <td>{{$answer->texto_respuesta}}</td>
                            <td>{{$answer->id_respuesta}}</td>
                            @if($answer->estado==1)
                            <td>Activo</td>
                            @elseif($answer->estado==2)
                            <td>Inactivo</td>
                            @else
                            <td>{{$answer->estado}}</td>
                            @endif

                            <td><a href="{{URL::to('/QuestionAnswerView/')}}/{{$answer->id}}">Editar</a></td>

                        </tr>


                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</body>
@endsection