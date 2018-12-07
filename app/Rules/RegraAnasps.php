<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Documento;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UtilController;

class RegraAnasps implements Rule
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
    	$date_regra = date('Y-m-d H:i:s', strtotime('2018-12-03 00:00:00'));
//     	DB::enableQueryLog();
    	$documento = Documento::where(['tp_documento' => 'CPF', 'te_documento' => UtilController::retiraMascara($value)])->whereDate('created_at', '=', $date_regra)->whereDate('updated_at', '=', $date_regra)->first();
//     	$query_log = DB::getQueryLog();
//     	dd($query_log);
    	
    	//--verifica se eh documento de colaborador anasps
        if (!empty($documento)) {
        	return true;
        }
        
        
        $documento = Documento::where(['tp_documento' => 'CPF', 'te_documento' => UtilController::retiraMascara($value)])->first();
        //--verifica o documento dos demais pacientes
        if (!empty($documento)) {
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
        return 'Este CPF já existe no DrHoje!';
    }
}
