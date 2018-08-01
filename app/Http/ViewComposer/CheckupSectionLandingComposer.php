<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Checkup;

class CheckupSectionLandingComposer
{
	public function compose(View $view)
	{
	    $checkup = new Checkup();

        $view
            ->with( 'checkupMasculino', Checkup::find(1) )
            ->with( 'checkupMasculinoSummary', $checkup->getSummary( 1 ) )
            ->with( 'checkupFeminino', Checkup::find(2) )
            ->with( 'checkupFemininoSummary', $checkup->getSummary( 2 ) );
	}
}