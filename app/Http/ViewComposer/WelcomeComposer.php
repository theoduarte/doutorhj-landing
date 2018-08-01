<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Checkup;

class WelcomeComposer
{
	public function compose(View $view)
	{
	    $checkup = Checkup::where('cs_status','A')->count();
        $view->with( 'hasActiveCheckup', $checkup > 0 ? true : false );
	}
}