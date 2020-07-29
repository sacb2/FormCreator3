@extends('layouts.app_new_new')
<!-- template -->
<input name="formulario" type="hidden" value="{{$formulario}}">
@section('content')
<style>
    main {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 300;
        font-size: 1em;
        height: 300vh;
        margin: 0;
    }

    body {
        color: #636b6f;

    }

    textarea {
        resize: none;
    }

    #count_message {
        background-color: smoke;
        margin-top: -20px;
        margin-right: 5px;
    }
</style>
@if(!isset($style_font)||$style_font==null)
@php
$style_font=1;
$size='1em';
@endphp
@endif
@if(!isset($style_color)||$style_color==null)
@php
$style_color=4;
$bcolor='#fff';
$color='#636b6f';
@endphp
@endif

@if($style_font==1)
<input name="style_font" type="hidden" value="1">
<input name="style_color" type="hidden" value="{{$style_color}}">

@php
$size='1em';
@endphp
@elseif($style_font==2)
<input name="style_font" type="hidden" value="2">
<input name="style_color" type="hidden" value="{{$style_color}}">
@php
$size='1.2em';
@endphp
@elseif($style_font==3)
<input name="style_font" type="hidden" value="3">
<input name="style_color" type="hidden" value="{{$style_color}}">
@php
$size='1.7em';
@endphp
@else
@php
$size='1em';
@endphp
@endif

@if($style_color==4)
<input name="style_font" type="hidden" value="{{$style_font}}">
<input name="style_color" type="hidden" value="4">
@php

$bcolor='#fff';
$color='#636b6f';
@endphp
@elseif($style_color==5)
<input name="style_font" type="hidden" value="{{$style_font}}">
<input name="style_color" type="hidden" value="5">
@php
$bcolor='#FFC20A';
$color='#0C7BDC';
@endphp
@elseif($style_color==6)
<input name="style_font" type="hidden" value="{{$style_font}}">
<input name="style_color" type="hidden" value="6">
@php
$bcolor='#E66100';
$color='#5D3A9B';
@endphp
@else
@php

$bcolor='#fff';
$color='#636b6f';
@endphp

@endif

@if(!isset($style_font)&&!isset($style_color))
<style>
	main {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
				font-weight: 300;
				font-size: 1em;
                height: 300vh;
                margin: 0;
    }

</style>
@endif
<style>
	main {
                background-color:{{$bcolor}};
                color: {{$color}};
                font-family: 'Nunito', sans-serif;
				font-weight: 300;
				font-size: {{$size}};
                height: 300vh;
                margin: 0;
    }
	#colornew{
	background-color: {{$bcolor}};
	color: {{$color}};
	font-weight: bold;
}
label {
	color: {{$color}};
    font-weight: bold;

}
</style>

<body>


	<!-- mensaje de error -->  
          @if($errors->any())
          <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <h4>{{$errors->first()}}</h4>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          @if(Session::has('message'))
          <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <h4>{{ Session::get('message')}}</h4>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          <!-- mensaje de error -->


    <div class="panel-heading col-md-8"><i class="fa fa-user"></i> Responder Formulario : {{$formulario->nombre}}


        <a role="contentinfo" class="sr-only sr-only-focusable">.Página de ingreso de respuestas: aquí tendrá que responder las preguntas
            señaladas. Dependiendo el tipo de pregunta se le solicitará responder de diferentes formas, con texto,
            seleccionar alternativas o adjuntar archivos.</a>
    </div>



    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div id="colornew" class="card-body">
                    <form method="POST" action="{{ route('ConfirmAnswersStoreGroup') }}" enctype="multipart/form-data">
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
                        <input name="formulario" type="hidden" value="{{$formulario}}">
                        <input name="answer_id" type="hidden" value="{{$answer_id}}">
                                                     


                        <div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Id Respuesta</th>
							<th scope="col">Fecha</th>
                            <th scope="col">Id Persona</th>
							<th scope="col">Nombre Pregunta</th>
                            <th scope="col">Tipo de Pregunta</th>
                            <th scope="col">Respuesta</th>
							<th scope="col">Ver Adjunto</th>
							
							
						</tr>
					</thead>

					<tbody>
				
                            @foreach($answers as $answer)
						<tr>
							<td>{{$answer->id_requerimiento}}</td>
							<td>{{$answer->updated_at}}</td>
                            <td>{{$answer->rut_persona}}</td>
							<td>{{$answer->question->question->nombre}}</td>
							@if($answer->question->question->tipo==1)
							<td>Texto</td>
							@elseif($answer->question->question->tipo==2)
                            <td>Seleccion Múltiple</td>
                            @elseif($answer->question->question->tipo==3)
							<td>Imagen</td>
							@else
							<td>{{$answer->question->question->tipo}}</td>
							@endif
                            <td>
								@if($answer->question->question->tipo==1)
									@if(isset($answer->texto_respuesta))
								{{$answer->texto_respuesta}}
									@endif
                                @elseif($answer->question->question->tipo==2)
                                <!--{{$answer->respuesta_number}}-->
                                @elseif($answer->question->question->tipo==3)
                              <!--  {{$answer->respuesta_number}} -->
								@else
									@if(isset($answer->texto_respuesta))
									{{$answer->texto_respuesta}}
									@endif
                                	<!--{{$answer->respuesta_number}}-->
                                @endif
                            </td>
                            <td>
								@if($answer->question->question->tipo==3)
								<a href="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" download='{{$answer->document->nombre}}'> 
							   <img width="100" height="100" src="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" alt="/images/{{$answer->id_formulario}}/{{$answer->document->nombre}}" class="img-thumbnail">
								</a>
							   
							   @elseif($answer->question->question->tipo==2)
							  
							   @if(isset($answer->answer_number->texto_respuesta))
							    {{$answer->answer_number->texto_respuesta}}
								@endif
							   
							   @elseif($answer->question->question->tipo==1)
							   {{$answer->respuesta_text}}

                                @endif
                            </td>
							</td>
							@if(isset($answer->questions))
							<td>@foreach($answer->questions as $question)

								@if($question->estado==1)
								{{$question->question->nombre}},
								@endif
								@endforeach</td>
							@endif
						</tr>

                            @endforeach
				
					</tbody>

				</table>
		</div>



                
                        <input name="style_font" type="hidden" value="{{$style_font}}">
                        <input name="style_color" type="hidden" value="{{$style_color}}">

                        <div class="form-group row mb-0">
                            <div class="col-md-8">
                            @if($style_font==1)

                               
                            <a href="{{ url('/BeneficiarieIndex/') }}" role="button" type="button" 
                                    class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Cancelar</a>
                                <button  type="submit" role="button" class="btn btn-info"><i
                                        class="glyphicon glyphicon-ok-circle"></i>
                                    {{ __('Enviar') }}
                                </button>
                                @elseif($style_font==2)
                                <a href="{{ url('/BeneficiarieIndex/') }}" role="button" type="button" style="font-size : 20px; width: 50%; height: 50px;"
                                    class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Cancelar</a>
                                <button  style="font-size : 20px; width: 50%; height: 50px;" type="submit" role="button" class="btn btn-info"><i
                                        class="glyphicon glyphicon-ok-circle"></i>
                                    {{ __('Enviar') }}
                                </button>

                                @elseif($style_font==3)
                                <a href="{{ url('/BeneficiarieIndex/') }}" role="button" type="button" style="font-size : 30px; width: 70%; height: 70px;"
                                    class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Cancelar</a>
                                <button style="font-size : 30px; width: 70%; height: 70px;" type="submit" role="button" class="btn btn-info"><i
                                        class="glyphicon glyphicon-ok-circle"></i>
                                    {{ __('Enviar') }}
                                </button>
                                @else
                                <a href="{{ url('/BeneficiarieIndex/') }}" role="button" type="button"
                                    class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Cancelar</a>
                                <button  type="submit" role="button" class="btn btn-info"><i
                                        class="glyphicon glyphicon-ok-circle"></i>
                                    {{ __('Enviar') }}
                                </button>
                                @endif

                                


                            </div>
                        </div>
                      

                </div>
            </div>



            </br>

            </br>








            </form>
        </div>
    </div>

    </div>
    </div>
</body>
<script>
    function textCounter(field,field2,maxlimit)
    {
     var countfield = document.getElementById(field2);
     console.log(countfield);
     
     //str.split(' ').length;
     if ( field.value.length > maxlimit ) {
      field.value = field.value.substring( 0, maxlimit );
      return false;
     } else {
      countfield.value = maxlimit - field.value.length;
     }
    }
</script>
<script>
    function wordCounter(field,field2,maxlimit)
        {
         var countfield = document.getElementById(field2);
         console.log(field.value.split(' ').length);
         var palabras = field.value.split(' ');
         var count=0;
         for(var i=0;i<maxlimit;i++){
            if (typeof(palabras[i]) != "undefined"){
                count=palabras[i].length +count;
            }
            if(field.value.split(' ').length>1){

            }
            //count=count+1;

         }
         if(field.value.split(' ').length>1){
            count=count+field.value.split(' ').length-1;
         }

         console.log(count);
    

         //str.split(' ').length;
         if ( field.value.split(' ').length > maxlimit +1 ) {
          field.value = field.value.substring( 0, count -2 );
          return false;
         } else {
          countfield.value = maxlimit - field.value.split(' ').length +1;
         }
        }
</script>
@endsection