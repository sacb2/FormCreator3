<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\ValidarRut;
use App\NewUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Session;


class NewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createuser()
    {
        return view('inclusive.formsuser.newuser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stornewuser(Request $request)
    {
        $validate_response = $request->validate(
			[
				'name' => ['required', 'string', 'max:50'],
                'surname' => ['required', 'string', 'max:50'],
                'identifier' => ['required', 'string', 'regex:/^[0-9]+[-|‐]{1}[0-9kK]{1}$/', new ValidarRut, 'unique:new_user,rut'],
                'address' => ['required', 'string', 'min:10', 'max:150'],
                'phone' => ['required', 'min:9', 'max:9'],
                'phone1' => ['min:9', 'max:9'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:new_user,email'],
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
        
        
        
        //Crear objeto
		$newuser = new NewUser;
		$newuser->nombres = $request->name;
		$newuser->apellidos = $request->surname;
		$newuser->rut = $request->identifier;
        $newuser->email = $request->email;
        $newuser->direccion = $request->address;
		$newuser->telefono1 = $request->phone;
		$newuser->telefono2 = $request->phone1;
        $newuser->fechnac = $request->birthdates;
        $newuser->password = Hash::make('oscar');
		$newuser->estado = 'activo';
		$newuser->tipo = 'usuario';
		try {
            $newuser->save();
            return view('inclusive.formsuser.newuser');
			//Session::flash('alertSent', 'Derived');
			//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
		} catch (\Exception $e) {
			// do task when error
			//Session::flash('alert', 'error');
            echo $e->getMessage();   // insert query
            return view('auth.login');

		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewUser  $newUser
     * @return \Illuminate\Http\Response
     */
    public function show(NewUser $newUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewUser  $newUser
     * @return \Illuminate\Http\Response
     */
    public function edit(NewUser $newUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewUser  $newUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewUser $newUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewUser  $newUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewUser $newUser)
    {
        //
    }
}
