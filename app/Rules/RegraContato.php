<?php

namespace App\Rules;

use App\Contato;
use App\Paciente;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UtilController;

class RegraContato implements Rule
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
		$contato = Contato::with('pacientes')
			->where('ds_contato', $value)
			->whereHas('pacientes', function($query) {
				$query->where('cs_status', Paciente::ATIVO);
			});

        //--verifica o documento dos demais pacientes
        if ($contato->exists()) {
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
        return 'Este celular já existe cadastrado no DrHoje!';
    }
}
