<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\TermosCondicoes;

class TermosCondicoesComposer
{
	public function compose(View $view)
	{
        $termosCondicoes = new TermosCondicoes();
	    $userSession = Auth::user();
	        
	    if (isset($userSession)) {
            $termoCondicaoUser = $termosCondicoes->getByAuth();
            $view->with('termoCondicaoUser', $termoCondicaoUser->ds_termo);
	    }
	    
	    $termosCondicoesActual = $termosCondicoes->getActual();

        $view->with( 'termosCondicoesActual', $termosCondicoesActual->ds_termo );
	}
}