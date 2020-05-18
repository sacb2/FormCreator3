@extends('layouts.app')


@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i>Página de Inicio Sesión</div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-body">
                                {{$nombre}}
                            </div>

                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
@endsection