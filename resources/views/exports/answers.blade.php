<title> Formulario de Respuesta Apoyo al Presupuesto Familiar</title>
<h1 class="page-header">Respuestas</h1>
<h1>Desde {{$ini_date}} Hasta {{$end_date}}</h1>
@if($answersById==null)
<h1 class="page-header">No hay datos en las fechas seleccionadas</h1>
@endif

@if($answersById!=null)
<table border="1">
    <thead>
        <tr>
            <th scope="col">Id Respuesta</th>
            <th scope="col">Fecha</th>
            <th scope="col">Id Persona</th>
            <th scope="col">Nombre Pregunta</th>
            <th scope="col">Tipo</th>
            <th scope="col">Respuesta</th>



        </tr>
    </thead>

    <tbody>

        @foreach($answersById as $answers)
        @foreach($answers as $answer)
        <tr>
            <td>{{$answer->id_requerimiento}}</td>
            <td>{{$answer->updated_at}}</td>
            <td>{{$answer->rut_persona}}</td>
            <td>{{$answer->question->question->nombre}}</td>
            <td>
                @if($answer->question->question->tipo==1)
                Texto
                @elseif($answer->question->question->tipo==2)
                Seleccion Múltiple
                @elseif($answer->question->question->tipo==3)
                Imagen
                @else
                {{$answer->question->question->tipo}}
                @endif
            </td>

            <td>
                @if($answer->question->question->tipo==3)
                
                <a href="http://decom.lascondes.cl/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}"> Imagen</a>


                @elseif($answer->question->question->tipo==2)
                @if(isset($answer->answer_number->texto_respuesta))
                {{$answer->answer_number->texto_respuesta}}
                @endif

                @elseif($answer->question->question->tipo==1)
                {{$answer->texto_respuesta}}

                @endif
            </td>
            @if(isset($answer->questions))
            <td>@foreach($answer->questions as $question)

                @if($question->estado==1)
                {{$question->question->nombre}}
                @endif
                @endforeach</td>
            @endif



        </tr>

        @endforeach
        @endforeach

    </tbody>
</table>

@endif