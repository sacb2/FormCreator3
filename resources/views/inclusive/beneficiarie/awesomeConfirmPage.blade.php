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
                    <form method="POST" action="{{ route('AwesomerAnswersStoreGroup') }}" enctype="multipart/form-data">
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
                                                     

                        <div>
                            <p class="text-justify">Preguntas: </p>



                            <div>

                                @if($formulario->tipo==1)
                                <a class="hide">Ingrese su número de rut sin puntos y con guión</a>
                                <div class="form-group">
                                    <label tabindex="0" role="contentinfo" for="id_label"
                                        class="col-3 col-form-label">*R.U.T. (Ej:123456-0)</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span
                                                class="glyphicon glyphicon-list-alt"></span></div>
                                        <input required name="rut"
                                            title="Sin puntos y con digito verificador Ejemplo:123456-0"
                                            pattern="^[0-9]+[-|‐]{1}[0-9kK]{1}$" type="text" maxlength="10"
                                            value="{{$rut ?? ''}}" style="text-transform:uppercase"
                                            class="form-control" placeholder="rut">
                                    </div>
                                    <span class="help-block" id="error"></span>
                                </div>
                                @endif



                                <input name="formQuestions" type="hidden" value="{{$formulario->questions}}">


                                @foreach($formulario->questions->sortBy('orden') as $pregunta)


<!--Pregunta requerida -->
@if($pregunta->question->required==1)
    @php
        $required="required";
    @endphp
@else 
    @php
    $required="";
    @endphp
@endif
<!--Pregunta requerida -->


                                @if($pregunta->estado==1)
                                @if($pregunta->question->tipo==2)
                                <!-- restriccion de edad -->
                                @if($pregunta->question->edad_max!=null&&$pregunta->question->edad_max!=0&&$pregunta->question->edad_max>$edad||$pregunta->question->edad_min!=null&&$pregunta->question->edad_min!=0&&$pregunta->question->edad_min<$edad)
                                @if($pregunta->question->required==1)
                                Requerida
                                <input name="answers_req[]" type="hidden" value="{{$pregunta->id}}">
                                @endif
                                <input name="questions[]" type="hidden" value="answers_int[{{$pregunta->id}}]">






                                <div class="form-group row">

                                    <label role="contentinfo" tabindex="0" for="answers[{{$pregunta->id}}]"
                                        class="col-md-4 col-form-label">{{$pregunta->question->pregunta}}</label>
                                    <div class="col-md-6">
                                        <select  class="custom-select" id="answers_int[{{$pregunta->id}}]"
                                            name="answers_int[{{$pregunta->id}}]" value="{{ old('state') }}">
                                            <option value='' selected>Seleccionar...</option>
                                            @foreach($pregunta->question->answers as $answer)
                                            <option value="multiple[{{$answer->valor_respuesta}}][{{$answer->id}}]">
                                                {{$answer->texto_respuesta}}
                                            </option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                @elseif(($pregunta->question->edad_max==null||$pregunta->question->edad_max==0)&&($pregunta->question->edad_min==null||$pregunta->question->edad_min==0))
                                <input name="questions[]" type="hidden" value="answers_int[{{$pregunta->id}}]">
                                @if($pregunta->question->required==1)
                                Requerida
                                <input name="answers_req[]" type="hidden" value="{{$pregunta->id}}">
                                @endif
                                <div class="form-group row">

                                    <label role="contentinfo" tabindex="0" for="answers[{{$pregunta->id}}]"
                                        class="col-md-4 col-form-label">{{$pregunta->question->pregunta}}</label>
                                    <div class="col-md-6">
                                        <select  class="custom-select" id="answers_int[{{$pregunta->id}}]"
                                            name="answers_int[{{$pregunta->id}}]" value="{{ old('state') }}">
                                            <option value='' selected>Seleccionar...</option>
                                            @foreach($pregunta->question->answers as $answer)
                                           
                                            @php
                                            $answer_data = json_encode(array('value'=>$answer->valor_respuesta,'id'=>$answer->id));
                                            @endphp
                                            <option value='{{$answer_data}}'>
                                                {{$answer->texto_respuesta}} 
                                            </option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                @endif
                                @elseif($pregunta->question->tipo==6)
                                <!-- restriccion de edad -->
                                @if($pregunta->question->edad_max!=null&&$pregunta->question->edad_max!=0&&$pregunta->question->edad_max>$edad||$pregunta->question->edad_min!=null&&$pregunta->question->edad_min!=0&&$pregunta->question->edad_min<$edad)

                                <div class="form-group">
                                    <label tabindex="0" role="contentinfo"
                                        for="comment">{{$pregunta->question->pregunta}}</label>
                                        
								<a role="contentinfo" title="Descargar documentación" href="/images/questions/{{$pregunta->question->document_name}}" download='{{$pregunta->question->document_name}}'> 
                                    <i class="fas fa-clipboard-list"> Descargar </i>
							   
								</a>

                                </div>
                                @elseif(($pregunta->question->edad_max==null||$pregunta->question->edad_max==0)&&($pregunta->question->edad_min==null||$pregunta->question->edad_min==0))
                                
                                <div class="form-group">
                                    <label tabindex="0" role="contentinfo"
                                        for="comment">{{$pregunta->question->pregunta}}</label>
                                        
								<a role="contentinfo" title="Descargar documentación" href="/images/questions/{{$pregunta->question->document_name}}" download='{{$pregunta->question->document_name}}'> 
                                    <i class="fas fa-clipboard-list"> Descargar </i>
							   
								</a>

                                </div>
                                @endif
                                @elseif($pregunta->question->tipo==3)
                                <!-- restriccion de edad -->
                                @if($pregunta->question->edad_max!=null&&$pregunta->question->edad_max!=0&&$pregunta->question->edad_max>$edad||$pregunta->question->edad_min!=null&&$pregunta->question->edad_min!=0&&$pregunta->question->edad_min<$edad)
                                <input name="questions[]" type="hidden" value="answers_img[{{$pregunta->id}}]">
                                @if($pregunta->question->required==1)
                                Requerida
                                <input name="img_req[]" type="hidden" value="{{$pregunta->id}}">
                                @endif

                                <div align="left"
                                    class="form-group row{{ $errors->has('attachment') ? ' has-error' : '' }}">
                                    <label role="contentinfo" tabindex="0" for="attachment"
                                        class="col-md-4 col-form-label">Adjuntar
                                        {{$pregunta->question->pregunta}}:</label>

                                    <div align="left" class="col-md-6">
                                        Tamaño máximo de adjunto 7MB <input role="button"
                                            id="answers_img[{{$pregunta->id}}]" type="file" class="form-control"
                                            name="answers_img[{{$pregunta->id}}]" >

                                        @if ($errors->has('attachment'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('attachment') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>
                                @elseif(($pregunta->question->edad_max==null||$pregunta->question->edad_max==0)&&($pregunta->question->edad_min==null||$pregunta->question->edad_min==0))
                                <input name="questions[]" type="hidden" value="answers_img[{{$pregunta->id}}]">
                                @if($pregunta->question->required==1)
                                Requerida
                                <input name="img_req[]" type="hidden" value="{{$pregunta->id}}">
                                @endif
           

                                <div align="left"
                                    class="form-group row{{ $errors->has('attachment') ? ' has-error' : '' }}">
                                    <label role="contentinfo" tabindex="0" for="attachment"
                                        class="col-md-4 col-form-label">Adjuntar
                                        {{$pregunta->question->pregunta}}:</label>

                                    <div align="left" class="col-md-6">
                                        Tamaño máximo de adjunto 7MB <input role="button"
                                            id="answers_img[{{$pregunta->id}}]" type="file" class="form-control"
                                            name="answers_img[{{$pregunta->id}}]" >

                                        @if ($errors->has('attachment'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('attachment') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>
                                @endif
                                @else
                                <!-- restriccion de edad -->
                                @if($pregunta->question->edad_max!=null&&$pregunta->question->edad_max!=0&&$pregunta->question->edad_max>$edad||$pregunta->question->edad_min!=null&&$pregunta->question->edad_min!=0&&$pregunta->question->edad_min<$edad)
                                <input name="questions[]" type="hidden" value="answers_text[{{$pregunta->id}}]">
                                @if($pregunta->question->required==1)
                                Requerida
                                <input name="text_req[]" type="hidden" value="{{$pregunta->id}}">
                                @endif
                                @php
                                if(isset($old[$pregunta->id])){
                                    $pregunta_old=$old[$pregunta->id];
                                }else
                                $pregunta_old=null;
                                @endphp
                               
                                <div class="form-group">
                                    <label tabindex="0" role="contentinfo"
                                        for="comment">{{$pregunta->question->pregunta}}</label>
                                    @if(isset($pregunta->question->size)&&$pregunta->question->size>0)
                                    <a class="hide">El tamaño maximo de la respuesta es {{$pregunta->question->size}}
                                        caracteres y a continuación hay un contador de caracteres.</a>
                                    <textarea   class="form-control" rows="5" maxlength="6666"
                                        onkeyup="wordCounter(this,'counter1{{$pregunta->id}}',{{$pregunta->question->size}});"
                                        name="answers_text[{{$pregunta->id}}]" id="{{$pregunta->id}}">{{$old[$pregunta->id]?? ''}}</textarea>
                                    <input readonly role="contentinfo" tabindex="0"
                                        aria-label="Cantidad de Caracteres escritos" maxlength="3" size="3"
                                        value="{{$pregunta->question->size}}" id="counter1{{$pregunta->id}}">

                                    @else
                                    @php
                                if(isset($old[$pregunta->id])){
                                    $pregunta_old=$old[$pregunta->id];
                                }
                                @endphp
                               @if(isset($old[$pregunta->id]))
                                {{$old[$pregunta->id]}}
                                else
                                $pregunta_old=null;
                                @endif
                                preguntae{{$e}}
                                    <textarea class="form-control" rows="5" maxlength="6666"
                                        name="answers_text[{{$pregunta->id}}]'" id="{{$pregunta->id}}">{{$pregunta_old}}</textarea>
                                    @endif

                                </div>
                                @elseif(($pregunta->question->edad_max==null||$pregunta->question->edad_max==0)&&($pregunta->question->edad_min==null||$pregunta->question->edad_min==0))
                                <input name="questions[]" type="hidden" value="answers_text[{{$pregunta->id}}]">
                                @if($pregunta->question->required==1)
                                Requerida
                                <input name="tex_req[]" type="hidden" value="{{$pregunta->id}}">
                                @endif
                                @php
                                if(isset($old[$pregunta->id])){
                                    $pregunta_old=$old[$pregunta->id];
                                }else
                                $pregunta_old=null;
                                @endphp
                             
                                <div class="form-group">
                                    <label tabindex="0" role="contentinfo"
                                        for="comment">{{$pregunta->question->pregunta}}</label>
                                    @if(isset($pregunta->question->size)&&$pregunta->question->size>0)
                                    <a class="hide">El tamaño maximo de la respuesta es {{$pregunta->question->size}}
                                        caracteres y a continuación hay un contador de caracteres.</a>
                                    <textarea  class="form-control" rows="5" maxlength="6666" value="{{$pregunta->id}}"
                                        onkeyup="wordCounter(this,'counter1{{$pregunta->id}}',{{$pregunta->question->size}});"
                                        name="answers_text[{{$pregunta->id}}]'" id="{{$pregunta->id}}">{{$pregunta_old}}</textarea>
                                    <input readonly role="contentinfo" tabindex="0"
                                        aria-label="Cantidad de Caracteres escritos" maxlength="3" size="3"
                                        value="{{$pregunta->question->size}}" id="counter1{{$pregunta->id}}">

                                    @else
                                    @php
                                    
                                if(isset($old[$pregunta->id])){
                                    $pregunta_old=$old[$pregunta->id];
                                }else
                                $pregunta_old=null;
                                @endphp
                              
                               
                              
                                    <textarea  class="form-control" rows="5" maxlength="6666"
                                        name="answers_text[{{$pregunta->id}}]'" id="{{$pregunta->id}}">{{$pregunta_old}}
                                        </textarea>
                                    @endif

                                </div>
                                @endif
                                @endif
                                @endif
                                @endforeach





                            </div>
                        </div>
                        <input name="style_font" type="hidden" value="{{$style_font}}">
                        <input name="style_color" type="hidden" value="{{$style_color}}">

                        <div class="form-group row mb-0">
                            <div class="col-md-8">
                            @if($style_font==1)

                               
                            <a href="{{ url('/BeneficiarieIndex/') }}" role="button" type="button" 
                                    class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                <button  type="submit" role="button" class="btn btn-info"><i
                                        class="glyphicon glyphicon-ok-circle"></i>
                                    {{ __('Enviar') }}
                                </button>
                                @elseif($style_font==2)
                                <a href="{{ url('/BeneficiarieIndex/') }}" role="button" type="button" style="font-size : 20px; width: 50%; height: 50px;"
                                    class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                <button  style="font-size : 20px; width: 50%; height: 50px;" type="submit" role="button" class="btn btn-info"><i
                                        class="glyphicon glyphicon-ok-circle"></i>
                                    {{ __('Enviar') }}
                                </button>

                                @elseif($style_font==3)
                                <a href="{{ url('/BeneficiarieIndex/') }}" role="button" type="button" style="font-size : 30px; width: 70%; height: 70px;"
                                    class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                <button style="font-size : 30px; width: 70%; height: 70px;" type="submit" role="button" class="btn btn-info"><i
                                        class="glyphicon glyphicon-ok-circle"></i>
                                    {{ __('Enviar') }}
                                </button>
                                @else
                                <a href="{{ url('/BeneficiarieIndex/') }}" role="button" type="button"
                                    class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Volver</a>
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