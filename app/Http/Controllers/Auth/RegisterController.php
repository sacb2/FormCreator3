<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\ValidarRut;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                'name' => ['required', 'string', 'max:50'],
                'surname' => ['required', 'string', 'max:50'],
                'identifier' => ['required', 'string', 'regex:/^[0-9]+[-|‐]{1}[0-9kK]{1}$/', new ValidarRut, 'unique:users,rut'],
                'address' => ['required', 'string', 'min:10', 'max:150'],
                'phone' => ['required', 'min:9', 'max:9'],
                'phone1' => ['min:9', 'max:9'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email'],
                'password' => ['min:6', 'max:10', 'required_with:password_confirmation','same:password_confirmation'],
            ],
            [
                'name.required' => 'newuser.nombre1',
                'surname.required' => 'newuser.nombre2',
                'identifier.required' => 'newuser.nombre3',
                'address.required' => 'newuser.nombre5',
                'phone.required' => 'newuser.nombre6',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $porciones = explode("/", $data['birthdate']);
        $fecha = $porciones[2].'/'.$porciones[1].'/'.$porciones[0];
        return User::create([
            'nombres' => $data['name'],
            'apellidos' => $data['surname'],
            'rut' => $data['identifier'],
            'email' => $data['email'],
            'direccion' => $data['address'],
            'telefono1' => $data['phone'],
            'telefono2' => $data['phone1'],
            'fechnac' => $fecha,
            'estado' => "activo",
            'tipo1' => "si",
            'tipo2' => "no",
            'tipo3' => "no",
            'password' => Hash::make($data['password']),
        ]);
    }
}
