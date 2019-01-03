<?php

namespace App\Rules;

use App\Paciente;
use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UtilController;

class RegraEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		$user = User::with('pacientes')
			->where('email', $value)
			->whereHas('pacientes', function($query) {
				$query->where('cs_status', Paciente::ATIVO);
			});

        //--verifica o documento dos demais pacientes
        if ($user->exists()) {
        	return false;
        }
        
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Este email já existe no DrHoje!';
    }
}
