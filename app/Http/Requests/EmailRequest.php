<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'nome'              => 'Nome Completo',
            'email'             => 'E-mail',
            'telefone'          => 'Telefone',
            'mensagem'          => 'Mensagem'
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
            'nome'              => 'required|string|max:150',
            'email'             => 'required|string|max:50|min:3|email',
            'telefone'          => 'required|max:20',
            'mensagem'          => 'required'
        ];

        return $rules;
    }
}