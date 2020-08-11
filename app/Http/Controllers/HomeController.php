<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Session;
use App\User;
use App\InclusiveUserType;
use Illuminate\Support\Facades\Hash;
use App\InclusiveUserTypes;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
	
		
	//	$this->middleware('auth');
		$this->middleware('auth', ['except' => ['loginStyle','registerStyle']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function logout(){

        Auth::logout();
        Session::flush();
		return view('home');
	}
	
	public function loginStyle(Request $request){

		if(isset($request->style_color))
		Session::put('color', $request->style_color);
		else 
		$request->style_color=Session::get('color');
		if(isset($request->style_font))
		Session::put('font', $request->style_font);
		else
		$request->style_font=Session::get('font');
	
		return view('auth.login', ['style_color'=>$request->style_color,'style_font'=>$request->style_font]);

	}
	public function registerStyle(Request $request){

		if(isset($request->style_color))
		Session::put('color', $request->style_color);
		else 
		$request->style_color=Session::get('color');
		if(isset($request->style_font))
		Session::put('font', $request->style_font);
		else
		$request->style_font=Session::get('font');
	
		return view('auth.register', ['style_color'=>$request->style_color,'style_font'=>$request->style_font]);

	}

    //vista crear usuario
	public function createUser(){
	//validar usuario
		$type= Auth::user()->type_id;
	if( $type>0||is_null($type)){
			Auth::logout();
			return view('welcome');
		}
		$types= InclusiveUserTypes::all();
		return view('users.create', ['types'=>$types]);
	}
	
	//guardar usuario
	  public function storeUsers(Request $request)

    {
		//validar usuario
		$type= Auth::user()->type_id;
	if( $type>0||is_null($type)){
			Auth::logout();
			return view('welcome');
		}
			$validate_response=$request->validate([
			'name'=>'required',
			'email'=>'required',
			'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
			'type'=>'not-in:null',
		]);
		
		$user= new User;
		$user->password=Hash::make($request->password);
		$user->email=$request->email;
		$user->type_id=$request->type;
		$user->name=$request->name;
		$types = InclusiveUserTypes::all();
	
				

		try{
     
			Session::flash('alertSent', 'UsuarioCreado');
			foreach($types as $type){
				if($request->type==$type->id)
				Session::flash('message',  $type->name.'  '.$user->email );
				}
			  $user->save();
				
		}
		catch(\Exception $e){
       // do task when error
        Session::flash('alert', 'error');
		echo $e->getMessage();   // insert query
		
		}
		$users = User::all();
		$users = User::paginate(10);
		return view('users.list', ['users'=>$users]);

    }
	
	//lista de usuarios en el sistema
	public function listUser(){
		//validar usuario
		$type= Auth::user()->type_id;
	if( $type>0||is_null($type)){
			Auth::logout();
			return view('welcome');
		}
      //  dd("aquí");
			$users = User::all();
			$users = User::paginate(10);
	
		return view('users.list', ['users'=>$users]);
		
    }
	

    	//lista de usuarios en el sistema
	public function userView($id){
		//validar usuario
	/*	$type= Auth::user()->type_id;
	if( $type>0||is_null($type)){
			Auth::logout();
			return view('welcome');
		}*/
      
              $users = User::find($id);
              
      
          return view('users.view', ['user'=>$users]);
          
      }

      public function updateUsers(Request $request)
		{
			//validar usuario
	/*	$type= Auth::user()->type_id;
		if( $type>0||is_null($type)){
				Auth::logout();
				return view('welcome');
			}*/
		
		
		//constructed and designed by Sebastián Acevedo ac@akasha.ink
			$user = User::where('email', '=', $request->email)->firstOrFail();
		$user->password=Hash::make($request->password);
		$user->type_id=$request->type;
		$user->name=$request->name;
				$types = InclusiveUserTypes::all();

				try{
     
			Session::flash('alertSent', 'UsuarioActualizado');
			foreach($types as $type){
				if($request->type==$type->id)
				Session::flash('message',  $type->name.'  '.$user->email );
				}
			  $user->save();
				
		}
		catch(\Exception $e){
       // do task when error
        Session::flash('alert', 'error');
		echo $e->getMessage();   // insert query
		
		}
				return view('users.view', ['user'=>$user]);


    }
	
    
}
