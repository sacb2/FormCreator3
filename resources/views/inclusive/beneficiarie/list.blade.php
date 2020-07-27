@extends('layouts.app_new_new') <!-- template -->



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
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <h4>{{ Session::get('message')}}</h4>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          <!-- mensaje de error -->

<div class="panel panel-default">
	<div class="panel-heading col-md-8"><i class="fa fa-user"></i> Listar Formularios</div>
	<div class="panel-body">
		<div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
  <div id=colornew  class="table-responsive">
	<a class="sr-only sr-only-focusable">Aquí se muestran las diferentes postulaciones en las cuales debera seleccionar la que quiere completar el formulario</a>
    	<table id=colornew class="table table-hover">
						<thead >
							<tr>
								<th scope="col">Nombre</th>
								<th scope="col">Descripción</th>
								<th scope="col">Ver</th>
							</tr>
						</thead>

						<tbody>
						@foreach($forms as $form)
						
							<tr>
								<td>{{$form->nombre}}</td>
								<td>{{$form->description}}</td>
								@if($form->estado==1)
									<td>
										<form method="POST"  action="{{ route('UseFormBeneficiariePost') }}" enctype="multipart/form-data">
											{{ csrf_field() }}
											<input name="style_font" type="hidden" value={{$style_font}}>
											<input name="style_color" type="hidden" value={{$style_color}}>
											<button type="submit" name='id'  aria-label="Responder {{$form->nombre}}" value='{{$form->id}}' role="button" class="btn btn-info"><i class="glyphicon glyphicon-ok-circle"></i>
												{{ __('Responder') }}
											</button>
										</td>		
										@endif
								

						
							</tr>
							
							
						@endforeach  
						</tbody>

				</table>
	</div>
	  </div>
	</div>
	  </div>
	</div>
	  </div>
	    
</div>

</body>
@endsection
