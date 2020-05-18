<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Rules\ValidarRut;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
//use App\Mail\EnvioEmail;
//use Illuminate\Support\Facades\Mail;
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
     * Uddate Info User Register
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edituniqueuser(Request $request)
    {
        $validate_response = $request->validate(
			[
				'name' => ['required', 'string', 'max:50'],
                'surname' => ['required', 'string', 'max:50'],
                'identifier' => ['required', 'string', 'regex:/^[0-9]+[-|‐]{1}[0-9kK]{1}$/'],
                'address' => ['required', 'string', 'min:10', 'max:150'],
                'phone' => ['required', 'min:9', 'max:9'],
                'phone1' => ['min:9', 'max:9'],
                'email' => ['required', 'string', 'email', 'max:50'],
                
            ],
			[
				'name.required' => 'newuser.nombre1',
                'surname.required' => 'newuser.nombre2',
                'identifier.required' => 'newuser.nombre3',
                'address.required' => 'newuser.nombre5',
                'phone.required' => 'newuser.nombre6',
			]
        );
        $porciones = explode("/", $request->birthdate);
        $fecha = $porciones[2].'/'.$porciones[1].'/'.$porciones[0];
        DB::update('update users set nombres = ?, apellidos = ?, rut = ?, direccion = ?,  telefono1 = ?, telefono2 = ?, email = ?, fechnac = ? where id = ?',[$request->name, $request->surname, $request->identifier, $request->address, $request->phone, $request->phone1, $request->email, $fecha, $request->id]);
        
        return Redirect::route('ListNewUser');
        
    }

    /**
     * Uddate Info User Register
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edituniqueuserind()
    {
        $newusers = DB::table('users')->paginate(5);
        return view('inclusive.formsuser.listnewuser', ['users' => $newusers ]);
        
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
        
        
        
        //Crear objeto
		$newuser = new User;
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
            return view('inclusive.formsuser.inicio',['nombre' => $request->name.' '.$request->surname]);
			//Session::flash('alertSent', 'Derived');
			//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
		} catch (\Exception $e) {
			// do task when error
			//Session::flash('alert', 'error');
            echo $e->getMessage();   // insert query
            return view('inclusive.formsuser.newuser');
        }
        
    }

    /**
     * Shows registered users on the platform
     *
     */
    public function listnewuser()
    {
        //$objDemo = new \stdClass();
        //$objDemo->demo_one = 'Demo One Value';
        //$objDemo->demo_two = 'Demo Two Value';
        //$objDemo->sender = 'SenderUserName';
        //$objDemo->receiver = 'ReceiverUserName';
 
        //Mail::to("mauri-1973@outlook.cl")->send(new EnvioEmail($objDemo));
        //$newusers = DB::table('new_user')->get();
        //$newusers = NewUser::all();
        $newusers = DB::table('users')->paginate(5);
        return view('inclusive.formsuser.listnewuser', ['users' => $newusers ]);
        
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
     * Show the form for editing the specified NuewUser.
     *
     * @param  \App\NewUser  $newUser
     * @return \Illuminate\Http\Response
     */
    public function editnewuser($id)
    {
        $datauser = User::where('id', $id)->get();
        
        foreach ($datauser as $user) {
            $porciones = explode("-", $user->fechnac);
            $fecha = $porciones[2].'/'.$porciones[1].'/'.$porciones[0];
            $datos = array("nombres" => $user->nombres, "apellidos" => $user->apellidos, "rut" =>$user->rut, "direccion" =>$user->direccion, "telefono1" =>$user->telefono1, "telefono2" =>$user->telefono2, "fechnac" =>$fecha, "email" =>$user->email, "id" =>$user->id);
            
        }
        return view('inclusive.formsuser.newuseredit', ['users' => $datauser , "datos" => $datos]);
    }

    /**
     * Change status specified User.
     *
     * @param  \App\NewUser  $newUser
     * @return \Illuminate\Http\Response
     */
    public function changestatususer($estado, $id)
    {
        if($estado == 0){$status = "inactivo";}else{$status = "activo";}
        DB::update('update users set estado = ? where id = ?',[$status,$id]);
        $newusers = DB::table('users')->paginate(5);
        return view('inclusive.formsuser.listnewuser', ['users' => $newusers ]);
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
