<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Tipoatendimento;
use App\Checkup;

class TipoAtendimentosComposer
{
	public function compose(View $view)
	{
	    $tiposAtendimentos = Tipoatendimento::where('cs_status','A')->whereNotNull('tag_value')->orderBy('id')->get();

        $checkup = Checkup::where('cs_status','A')->count();

        $view->with( 'tipoAtendimentos', $tiposAtendimentos )->with( 'hasActiveCheckup', $checkup > 0 ? true : false );
	}
}