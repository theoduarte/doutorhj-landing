<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Contato;
use Illuminate\Support\Facades\DB;
use App\Paciente;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request)
    {
    	$credentials = $request->only('cvx_telefone', 'cvx_token');
    	
    	$cvx_telefone = $credentials['cvx_telefone'];
    	$cvx_token = $credentials['cvx_token'];
    	
    	$ds_contato = UtilController::retiraMascara($cvx_telefone);
    	$contato1 = Contato::where(DB::raw("regexp_replace(ds_contato , '[^0-9]*', '', 'g')"), '=', $ds_contato)->get();
    	
    	$contato = $contato1->first();
    	$contato_id = $contato->id;
    	
    	$paciente_temp = Paciente::with('user')
	    	->join('contato_paciente', function($join1) { $join1->on('pacientes.id', '=', 'contato_paciente.paciente_id');})
	    	->join('contatos', function($join2) use ($contato_id) { $join2->on('contato_paciente.contato_id', '=', 'contatos.id')->on('contatos.id', '=', DB::raw($contato_id));})
	    	->select('pacientes.*')
	    	->get();
    	 
    	$user = $paciente_temp->first()->user;
    	
    	$username = $user->email;
    	$password = $cvx_token;
    	
    	$active = $user->cs_status;
    	
    	$credentials = ['email' => $username, 'password' => $password, 'cs_status' => 'A'];
    	
    	if($user === null) {
    		return view('login');
    	}
    
    	if (Auth::attempt($credentials)) {
    		// Authentication passed...
    		Auth::user()->load('paciente');
    		
    		return redirect()->intended('/');
    	}
    }
    
    public function logout(Request $request) {
    	Auth::logout();
    	return redirect('/');
    }
}
