@extends('layouts.app')


@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i>{{ __('newuser.listar') }} </div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                    <thead>
                                            <tr>
                                                <th>{{ __('newuser.nombres') }}</th>
                                                <th>{{ __('newuser.apellido') }}</th>
                                                <th>{{ __('newuser.rut') }} </th>
                                                <th>{{ __('newuser.email') }} </th>
                                                <th>{{ __('newuser.estado') }} </th>
                                                <th>{{ __('newuser.accion') }} </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @csrf

                                            @forelse($users as $user)
                                                <tr>
                                                <td>{{ $user->nombres }}</td>
                                                <td>{{ $user->apellidos }}</td>
                                                <td>{{ $user->rut }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->estado }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-block" href="{{URL::to('/EditNewUser/')}}/{{$user->id}}" role="button">{{ __('newuser.editar') }}</a>
                                                    @if($user->estado =="activo")
                                                    <a class="btn btn-warning btn-block" href="{{URL::to('/ChangeStatusUser/')}}/0/{{$user->id}}" role="button">{{ __('newuser.cambiarestadoact') }}</a>
                                                    @else
                                                    <a class="btn btn-success btn-block" href="{{URL::to('/ChangeStatusUser/')}}/1/{{$user->id}}" role="button">{{ __('newuser.cambiarestadoinact') }}</a>
                                                    @endif
                                                
                                                </td>
                                                </tr>
                                            @empty
                                                <tr colspan="5">
                                                <td>Sin Usuarios Registrados.</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                    
                                    <div class="d-flex justify-content-center">{{ $users->links() }}</div>
                                    
                                </div>
                            </div>

                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
@endsection