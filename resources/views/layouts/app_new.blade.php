<!doctype html>
<html lang="en">
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
        <style>
        #outer {
            width: 100%;
            text-align: center;
          }
          
          #inner {
            display: inline-block;
          }
          </style>
  <head>
  	<title> Postulaciones</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--fontAwesom -->
    <script src="https://kit.fontawesome.com/39806f2671.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
	<!--		<nav id="sidebar" class="active"> -->
     <!-- Menú Lateral Izquierdo-->
    	<!--</nav> -->

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

           
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
              <!--Accesibilidad -->
              <div id="outer">  
                        <div id="inner">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                   
                                  
                                    
                                      
                                  
                                    
                                    <form method="POST"  action="{{ URL::current() }}" enctype="multipart/form-data">
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

              <!-- Accesibilidad -->
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
                      @if(isset(Auth::user()->type_id))
                                @if(Auth::user()->type_id==1||Auth::user()->type_id==0||Auth::user()->type_id==3||Auth::user()->type_id==2)
                                <a class="nav-link" href="{{ route('SelectForms') }}">{{ __('Acceso Profesionales') }}</a>
                                @endif
                                @endif
                  @endguest
              </ul>
            </div>
          </div>
        </nav>
<!-- 
        <h2 class="mb-4">Sidebar #07</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
 -->
        <main class="py-4">
             @yield('content')
        </main>
      </div>
		</div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

  </body>
</html>