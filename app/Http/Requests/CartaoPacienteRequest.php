<?php

namespace App\Http\Requests;

use App\Http\Controllers\UtilController;
use Faker\Provider\zh_CN\DateTime;
use Illuminate\Foundation\Http\FormRequest;
use SebastianBergmann\CodeCoverage\Util;

class CartaoPacienteRequest extends FormRequest
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
			'numero' 			=> 'Número',
			'nome_impresso' 	=> 'Nome Impresso',
			'validade' 			=> 'Validade',
			'codigo_seg' 		=> 'Código de Segurança',
		];
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'numero'				=> 'required|string|min:13|max:19',
			'nome_impresso'			=> 'required|string|max:150',
			'validade'				=> 'required|min:4||max:9|date_format:"m/Y',
			'codigo_seg'			=> 'required|integer|nullable',
        ];
    }

	/**
	 * Padroniza Data de Validade
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getValidatorInstance()
	{
		$this->formatValidade();
		$this->formatNumeroCartao();

		return parent::getValidatorInstance();
	}

	protected function formatValidade()
	{
		if(strlen($this->input('validade')) == 7) {
			$mes = substr($this->input('validade'), 0, 2);
			$ano = \DateTime::createFromFormat('y', substr($this->input('validade'), -2))->format('Y');
			$this->merge(['validade' => "{$mes}/{$ano}"]);
		} else {
			$mes = substr($this->input('validade'), 0, 2);
			$ano = substr($this->input('validade'), -4);
			$this->merge(['validade' => "{$mes}/{$ano}"]);
		}
	}

	protected function formatNumeroCartao()
	{
		$this->merge(['numero' => UtilController::retiraMascara($this->input('numero'))]);
	}
}
