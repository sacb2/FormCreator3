<!doctype html>
<html lang="en">
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
			<nav id="sidebar" class="active">
        <h1><a href="{{ url('/') }}" class="logo">
        <img src="{{ asset('img/header_logo.png') }}" alt="Logotipo de HTML5" width="80" height="50">
        </a></h1>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="{{ route('SelectForms') }}"><span class="fa fa-home"></span> Inicio</a>
          </li>
          <li>
            <a href="{{ route('ContactListUser') }}"><span class="fa fa-sticky-note"></span> Usuarios</a>
          </li>
          <li>
            <a href="{{ route('ListForms') }}"><span class="fa fa-user"></span> Formularios</a>
          </li>
          <li>
              <a href="{{ route('ListQuestions') }}"><span class="fa fa-question"></span> Preguntas</a>
          </li>
          <li>
            <a href="{{ route('ListAnswers') }}"><span class="fa fa-sticky-note"></span> Respuestas</a>
          </li>
          <li>
            <a href="{{ route('Evaluations') }}"><span class="fa fa-sticky-note"></span> Evaluación</a>
          </li>
          <li>
            <a href="{{ route('Rubrics') }}"><span class="fa fa-sticky-note"></span> Rubrics</a>
          </li>
          <li>
            <a href="{{ route('ViewEvaluationList') }}"><span class="fa fa-sticky-note"></span> Listas</a>
          </li>
          <li>
            <a href="#"><span class="fa fa-paper-plane"></span> Contacto</a>
          </li>
        </ul>

        <div class="footer">
        	<p>
					  Copyright &copy;<script>document.write(new Date().getFullYear());</script> DECOM de la Ilustre Municipalidad de Las Condes
					</p>
        </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Esconder Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
<!-- 
        <h2 class="mb-4">Sidebar #07</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
 -->
        <main class="py-4">
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