<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampanhaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    public function attributes()
    {
    	return [
    			'nm_primario'          		=> 'Nome',
    			'nm_secundario'       		=> 'Sobrenome',
    			'cs_sexo'           		=> 'Sexo',
    			'email'             		=> 'Email',
    			'te_documento'      		=> 'CPF',
    			'ds_contato'      			=> 'Celular',
    			'confirma_ds_contato'  		=> 'Confirmação do Celular',
    	];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    	$rules = [
    			'nm_primario'       		=> 'required|max:50',
    			'nm_secundario'     		=> 'required|max:50',
    			'cs_sexo'           		=> 'required|max:1',
    			'te_documento'				=> 'required|max:14|min:11|cpf',
    			'ds_contato'        		=> 'required|max:30|same:confirma_ds_contato',
    			'confirma_ds_contato'       => 'required',
    			'email'     				=> 'required|max:250|min:3|email',
    	];
        
        return $rules;
    }
}
