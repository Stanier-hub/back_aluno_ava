<?php

namespace App\Http\Requests;

use Validator;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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

        $rules = [
            'pis'               => 'string|required|max:11',
            'nome'              => 'string|required|max:100|min:2',
            'sobrenome'         => 'string|required|max:100|min:2',
            'nome_sobrenome'    => 'string|max:200|min:2',
            'data_nascimento'   => 'required|date',
            'rua'               => 'string|max:200|min:2',
            'bairro'            => 'string|max:80|min:2',
            'cep'               => 'integer',
            'status'            => 'required|integer',  
            'sexo_id'           => 'integer',
            'telefone1'         => 'max:45',
            'telefone2'         => 'max:45',
            'perfil_id'         => 'required|integer',
          
        ];

        if(request()->id){
            $rules['cpf']   = 'integer';
            $rules['rg']    = 'integer';
            $rules['email'] = 'email|max:200';

        }else{
            $rules['cpf']   = 'required|unique:usuario';
            $rules['rg']    = 'unique:usuario';
            $rules['email'] = 'email|required|unique:usuario|max:200';
            
        }

        return $rules;
    }

    public function messages()
    {
        return [

            'integer'  => 'O campo deve ser do tipo INT',
            'required' => 'O campo deve ser obrigatorio',
            'nome.max' => 'O campo nome deve possuir ate 200 caracteres',
            'nome.min' => 'O campo nome deve possuir no minimo 2 caracteres',
            'date'     => 'O campo deve ser uma data valida',
            'email'    => 'Favor forneca um email valido'
        ];
    }
}
