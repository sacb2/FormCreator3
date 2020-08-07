<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Postulaciones DECOM</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Belleza:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Belleza', sans-serif;
                font-weight: 300;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #ffffdf;
                padding: 0 25px;
                font-size: 15px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .hide {
   position: absolute !important;
   top: -9999px !important;
   left: -9999px !important;
}


.header {
  padding: 30px;
  text-align: center;
  background: #0fbbd4;
  color: white;
  font-size: 30px;
}
#outer {
            width: 100%;
            text-align: center;
          }
          
          #inner {
            display: inline-block;
          }

      
        </style>
    </head>
    <div class="header">
	<div>
	
	
            @if (Route::has('login'))
                <div class="links">
                    @auth
                        <a href="{{ url('/OptionsForm') }}">Inicio</a>
                    @else
                        <a class="btn btn-primary"  href="{{ route('login') }}" role="Ingresar">Ya estoy registrado</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Registrarme</a>
                        @endif
                    @endauth
                </div>
            @endif
            </div>
    
       
            
            <div>
            <h1>    <a href="{{URL::to('/OptionsForm/')}}">Plataforma de postulaciones DECOM:</a></h1>
			
            </div>
    </div>
       
    <body>
	            <!--<h2>    <a role="button"  href="{{URL::to('/home/')}}">Inicio</a></h2>-->
				<div id=outer>
					<div id=inner>
				<h1>    <a role="button"  href="{{ route('login') }}">Ya estoy registrado</a></h1>
				<h1>	<a role="button"  href="{{ route('register') }}">Registrarme</a> </h1>
				</div>
				</div>

	
	    <a tabindex="0" class="hide">Pagina de incio de sistema de inscripciones con opciones de accesibilidad, si ya tiene una cuenta presione en ingresar si no tiene una cuenta presione en "ya estoy registrado".</a>
        


            <div class="content">
                <div class="title m-b-md">

                    <div>
                      </div>
                      <a href="{{URL::to('/OptionsForm/')}}" > <img href="{{URL::to('/OptionsForm/')}}"  src="lascondes.png" role="button" class="imageClip" alt="Logo de las condes." ></a>
                      <div>
                    
                   
                </div>

             
            </div>

    </body>
    <footer>
             <!-- Copyright -->
    <div id="outer">  
        <div id="inner">
            © 2020 Copyright:
      <a href="http://www.lascondes.cl/"> lascondes.cl</a>

        </div>
    </div>
    <!-- Copyright -->
      </footer>
</html>
