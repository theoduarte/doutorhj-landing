<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\UtilController;
use App\Contato;
use Illuminate\Support\Facades\DB;
use App\Paciente;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use MundiAPILib\MundiAPIClient;
use App\FuncoesPagamento;


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

        $basicAuthUserName = env('MUNDIPAGG_KEY');

        $basicAuthPassword = "";

        $client = new MundiAPIClient($basicAuthUserName, $basicAuthPassword);

        $ds_contato = UtilController::retiraMascara($cvx_telefone);
    	$contato1 = Contato::where(DB::raw("regexp_replace(ds_contato , '[^0-9]*', '', 'g')"), '=', $ds_contato)->get();

    	$contato = $contato1->first();
    	$contato_id = $contato->id;
    	
    	//DB::enableQueryLog();
    	$paciente = Paciente::with('user')
			->where(['pacientes.cs_status' => Paciente::ATIVO])
	    	->join('contato_paciente', function($join1) { $join1->on('pacientes.id', '=', 'contato_paciente.paciente_id');})
	    	->join('contatos', function($join2) use ($contato_id) { $join2->on('contato_paciente.contato_id', '=', 'contatos.id')->on('contatos.id', '=', DB::raw($contato_id));})
	    	->select('pacientes.*')
	    	->first();

	    //$query = DB::getQueryLog();
	    //dd($query);
    	$user_login = $paciente->user;

    	$username = $user_login->email;
    	$access_token = $cvx_token;

    	$active = $user_login->cs_status;

    	$credentials = ['email' => $username, 'password' =>  ($access_token), 'cs_status' => 'A'];
// 		dd($credentials);
    	if($active == 'I') {
			$send_message = UserController::enviaEmailAtivacao($paciente);
    		return redirect()->route('landing-page')->with('error-alert', 'Sua Conta DoutorHoje não está ativa. Por favor, acesse o e-mail de ativação e clique no link existente nele!');
    	}
    	
    	if($user_login === null) {
    		//return view('login');
    		return redirect()->route('landing-page')->with('error-alert', 'O Login falhou!');
		}

		//dd($user_login);
    	if (Auth::attempt($credentials)) {
    		// Authentication passed...
    		$session = Auth::user()->load('paciente');
			Session::put('vigencia_id', $session->paciente->vigencia_principal->id);

    		if(empty($session->paciente->mundipagg_token)) {
                // passa os valores para montar o objeto a ser enviado
                $resultado = FuncoesPagamento::criarUser($session->paciente->nm_primario . ' ' . $session->paciente->nm_secundario, $session->email);

                try {
                    // cria o usuario na mundipagg
                    $userCreate = $client->getCustomers()->createCustomer($resultado);
                    $paciente->mundipagg_token = $userCreate->id;
                    if(!$paciente->save()) {
                        return redirect()->route('landing-page')->with('error-alert', 'O Login falhou! Não conseguimos criar e validar seu usuario ' );
                    }

                    return redirect()->intended('/');
                } catch (\Exception $e) {

                    return redirect()->route('landing-page')->with('error-alert', 'O Login falhou! Não conseguimos validar seu usuario,');

                }
            } else {
               return redirect()->intended('/');
    		}
    	} else {
    		return redirect()->route('landing-page')->with('error-alert', 'O Login falhou. As credenciais não conferem!');
    	}
    }
    
    public function logout(Request $request) {
		CVXCart::clear();
		Session::forget('plano_id');
    	Auth::logout();
    	return redirect('/');
    }
}
