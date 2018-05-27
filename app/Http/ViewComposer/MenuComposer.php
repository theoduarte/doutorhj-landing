<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;

use App\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;
use App\Mensagem;
use App\Http\Controllers\UtilController;

class MenuComposer
{
	protected $menus;

	public function __construct(Menu $menus)
	{
		$this->$menus = $menus;
	}

	public function compose(View $view)
	{
	    $user_session = Auth::user();
	    
	    $menus_app = Session::get('menus_app');
	    
	    //--busca itens no carrinho-----------------------
	    $cartCollection = CVXCart::getContent();
	    $cvx_num_itens_carrinho = $cartCollection->count();
	    
	    //--busca as notificacoes do paciente-----------------------
	    $notificacoes_app = Mensagem::with('remetente')
    	    ->join('mensagem_destinatarios', function($join1) { $join1->on('mensagem_destinatarios.mensagem_id', '=', 'mensagems.id');})
    	    ->where(function ($query) use ($user_session) { $query->where('mensagem_destinatarios.destinatario_id', $user_session->id);})
    	    ->where(DB::raw('mensagem_destinatarios.cs_status'), '=', 'A')
    	    ->where(DB::raw('mensagem_destinatarios.visualizado'), '=', 'false')
    	    ->orderBy('mensagem_destinatarios.created_at', 'desc')
    	    ->limit(3)
    	    ->get();
    	
	    for ($i=0; $i < sizeof($notificacoes_app); $i++) {
	        $nome_remetente = '';
	        
	        $nome_remetente = UtilController::getBetween($notificacoes_app[$i]->conteudo, '<li>Nome:', '</li>');
	        
	        if($nome_remetente == '') {
	            $nome_remetente = str_replace("Contato", "", $notificacoes_app[$i]->rma_nome);
	        }
	        
	        $notificacoes_app[$i]->nome_remetente = trim($nome_remetente);
	        $notificacoes_app[$i]->time_ago = UtilController::timeAgo(date('Y-m-d H:i:s', strtotime($notificacoes_app[$i]->getRawCreatedAtAttribute())));
	    }
	    
	    $total_notificacoes = Mensagem::with('remetente')
    	    ->join('mensagem_destinatarios', function($join1) { $join1->on('mensagem_destinatarios.mensagem_id', '=', 'mensagems.id');})
    	    ->where(function ($query) use ($user_session) { $query->where('mensagem_destinatarios.destinatario_id', $user_session->id);})->where(DB::raw('mensagem_destinatarios.cs_status'), '=', 'A')
    	    ->orderBy('mensagem_destinatarios.updated_at', 'desc')
    	    ->get();
	    
	    $num_total_notificacoes = sizeof($total_notificacoes);
	    

	    $view->with('menus_app', $menus_app);
	    $view->with('notificacoes_app', $notificacoes_app);
	    $view->with('num_total_notificacoes', $num_total_notificacoes);
	    $view->with('cvx_num_itens_carrinho', $cvx_num_itens_carrinho);
	    
	}
}