<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!doctype html>
  
    <style>
    
        @if(!isset($style_font)||$style_font==null)
            @php
                $style_font='1';
                $size='1em';    
            @endphp
        @endif
        @if(!isset($style_color)||$style_color==null)
            @php
                $style_color='4';
                $bcolor='#fff';
                $color='#636b6f';
            @endphp
        @endif
        
        </style> 
   
<head>
    <!--fontAwesom -->
    <script src="https://kit.fontawesome.com/39806f2671.js" crossorigin="anonymous"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Formulario de postulación</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Karma" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app_new.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Postulación
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <div id="outer">  
                        <div id="inner">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                   
                                  
                                    
                                      
                                  
                                    
                                    <form method="POST"  action="{{ route('LoginStyle') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <button aria-hidden="true"  type="submit" name='style_font' value='1' role="button" class="btn btn-info"><i class="glyphicon glyphicon-ok-circle"></i>
                                            {{ __('Tamaño Fuente') }}
                                            <i class="fab fa-quora"></i>
                                        </button>
                                        
                                        <button aria-hidden="true"  type="submit" name='style_font' value='2' role="button" class="btn btn-info"><i class="glyphicon glyphicon-ok-circle"></i>
                                            {{ __('Tamaño Fuente') }}
                                            <i  class="fab fa-quora fa-2x"></i>
                                        </button>
                                   
                                        <button aria-hidden="true" type="submit" name='style_font' value='3' role="button" class="btn btn-info"><i class="glyphicon glyphicon-ok-circle"></i>
                                            {{ __('Tamaño Fuente') }}
                                            <i  class="fab fa-quora fa-3x"></i>
                                        </button>
                                        <button aria-hidden="true"  type="submit" name='style_color' value='4' role="button" class="btn btn-info"><i class="glyphicon glyphicon-ok-circle"></i>
                                            {{ __('Color1') }}
                                        </button>
                                        
                                        <button aria-hidden="true"  type="submit" name='style_color' value='5' role="button" class="btn btn-info"><i class="glyphicon glyphicon-ok-circle"></i>
                                            {{ __('Color2') }}
                                        </button>
                                   
                                        <button aria-hidden="true"  type="submit" name='style_color' value='6' role="button" class="btn btn-info"><i class="glyphicon glyphicon-ok-circle"></i>
                                            {{ __('Color3') }}
                                        </button>
                                    </form>    

                                    
                                </div>
                            </div>
                    </div>
                </div>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Acceso') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                        @else
                    <!--   <li><i class="fas fa-globe-asia">CN</i></li>
                        <li><i class="fas fa-globe-asia">JP</i></li>
                        <li><i class="fas fa-globe-africa">HI</i></li>
                        <li><i class="fas fa-globe-americas">ES</i></li>
                        <li><i class="fas fa-globe-europe">EN</i></li> -->
                            <li class="nav-item dropdown">
                               
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                  
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    

        <main class="py-4">
            @if(Session::get('alertSent') == "Alert")
            <div class="alert alert-success" role="alert">
              <strong>{{Session::get('message')}}.</strong> 
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                @endif
            @yield('content')
          
        </main>
    </div>
</body>
</html>
