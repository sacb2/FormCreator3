<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Session;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;


   public function redirectTo(){
       
        // User role
        $role = Auth::user()->type_id;
    
        
        // Check user role
            switch ($role) {
                case '0':
                    return '/SelectForms';
                break;
                case '1':
                    return '/SelectForms';
                break;
                case '2':
                    return '/SelectForms';
                break;
                case '3':
                    return '/SelectForms';
                break;
                 default:
                    return '/BeneficiarieIndex'; 
                break;
         
            }
        }
    
       
  
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


        //$color =Session::get('color');
  //      dd($color);
        $this->middleware('guest')->except('logout');
    }
}
