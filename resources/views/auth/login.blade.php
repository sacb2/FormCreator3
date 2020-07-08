@extends('layouts.login') <!-- template -->
@if(Session::has('color'))
@php
$style_color=Session::get('color');

@endphp
{{ Session::put('color',$style_color)}}
@endif
@if(Session::has('font'))
@php
$style_font=Session::get('font');

@endphp
{{ Session::put('font',$style_font)}}
@endif
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
{{ Session::put('font','1')}}   
@endif
@if(!isset($style_color)||$style_color==null)
{{ Session::put('color','4')}}
@php
$style_color=4;

$bcolor='#fff';
$color='#636b6f';
@endphp
@endif

@if($style_font==1)
{{ Session::put('font','1')}}  
<input name="style_font" type="hidden" value="1">
<input name="style_color" type="hidden" value="{{$style_color}}">

@php
$size='1em';    
@endphp
@elseif($style_font==2)
{{ Session::put('font','2')}}  
<input name="style_font" type="hidden" value="2">
<input name="style_color" type="hidden" value="{{$style_color}}">
@php
$size='1.2em';    
@endphp
@elseif($style_font==3)
{{ Session::put('font','3')}}  
<input name="style_font" type="hidden" value="3">
<input name="style_color" type="hidden" value="{{$style_color}}">
@php
$size='1.3em';    
@endphp
@else
@php
$size='1em';    
@endphp
@endif

@if($style_color==4)
{{ Session::put('color','4')}}
<input name="style_font" type="hidden" value="{{$style_font}}">
<input name="style_color" type="hidden" value="4">
@php

$bcolor='#fff';
$color='#636b6f';
@endphp
@elseif($style_color==5)
{{ Session::put('color','5')}}
<input name="style_font" type="hidden" value="{{$style_font}}">
<input name="style_color" type="hidden" value="5">
@php
$bcolor='#FFC20A';
$color='#0C7BDC';
@endphp
@elseif($style_color==6)
{{ Session::put('color','6')}}
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
    body {
  color: #636b6f;

    }
#colornew{
	background-color: #fff;
	color: #636b6f;
}
label {
	color: {{$color}};
    font-weight: bold;

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
    body {
  color: {{$color}};
  background-color: #636b6f;
    }
    panel-body {
        background-color: #636b6f;
    }
    .hide {
   position: absolute !important;
   top: -9999px !important;
   left: -9999px !important;
}
#colornew{
	background-color: {{$bcolor}};
	color: {{$color}};
}
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

               
                <div id=colornew class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                       
{{Session::reflash()}}

              

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
