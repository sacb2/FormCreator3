@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('newuser.avisodeingreso')}} <strong>{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::user()->tipo1 == "si")
                    <a href="#" class="btn btn-secondary btn-block" role="button" aria-pressed="true">Usuario</a>  
                    @endif
                    @if (Auth::user()->tipo2 == "si")
                    <a href="#" class="btn btn-success btn-block" role="button" aria-pressed="true">Profesional</a>  
                    @endif
                    @if (Auth::user()->tipo3 == "si")
                    <a href="#" class="btn btn-primary btn-block" role="button" aria-pressed="true">Administrador</a>  
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
