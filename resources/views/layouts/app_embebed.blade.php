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
		
		
        <main class="py-4">
             @yield('content')
        </main>
    

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

  </body>
 
</html>
<!--ac@akasha.ink-->