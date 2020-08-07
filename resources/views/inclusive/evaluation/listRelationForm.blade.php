@extends('layouts_template.app') <!-- template -->



@section('content')

<body>


    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-user"></i> Agregar condiciones de listas</div>



        <div class="panel-body">


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">


                            <div class="card-body">
                                <form method="POST" action="{{ route('StoreRestrictionFormsList') }}">
                                    @csrf


                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <input name="id_form" type="hidden" value="{{$form->id}}">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                        <div class="col-md-6">
                                            <input readonly id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{$form->nombre}}" ?? "{{ old('name') }}" required
                                                autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <input name="id" type="hidden" value="{{$form->id}}">


                                    <div>
                                        <p class="text-justify">Seleccione las listas que desea evalauar
                                        </p>
                                        <div>

                                            @foreach($lists as $list)
                                            
                                            <input type="checkbox" name="pickedDep[{{$list->id}}]" id="pickedDep1"
                                            value='{{$list->id}}'> {{$list->nombre}}</input>

                                  
                                            <div class="form-group row">
                                                <label for="required"
                                                    class="col-md-4 col-form-label text-md-right">{{ __('Evaluación de Listas') }}</label>
                                                <div class="col-md-6">
                                                    <select class="custom-select" id="list" name="groupDep[{{$list->id}}]"
                                                        value="{{ old('list') }}">
                                                        <option value='0' selected>Sin Restricción </option>
                                                        <option value='1'>Se debe encontrar en </option>
                                                        <option value='2'>No se debe encontrar en </option>
                                                    </select>
                                                </div>
                                            </div>

                                           
                                              
                                           
                                           
                                           
                                            <br>

                                            @endforeach
                                        </div>
                                    </div>


                                    <div class="form-group row mb-0">
                                        <div class="col-md-8">
                                            <a href="{{ URL::previous() }}" type="button" class="btn btn-warning"><i
                                                    class="glyphicon glyphicon-menu-left"></i> Volver</a>
                                            <button type="submit" class="btn btn-info"><i
                                                    class="glyphicon glyphicon-ok-circle"></i>
                                                {{ __('Agregar') }}
                                            </button>
                                            <a href="{{ URL::current() }}" type="button" class="btn btn-danger"><i
                                                    class="glyphicon glyphicon-ban-circle"></i> Cancelar</a>
                                        </div>
                                    </div>




                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
@endsection