<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nm_primario'       => 'required|max:50',
            'nm_secundario'     => 'required|max:50',
            'cs_sexo'           => 'required|max:1',
            'te_documento'      => 'required|max:14|min:11',
            'ds_contato'        => 'required|max:30|unique:contatos,ds_contato',
            'dt_nascimento' => 'required|max:10|date_format:"d/m/Y"',
            'email'         => 'required|max:250|min:3|email|unique:users,email',
        ];
    }
}
