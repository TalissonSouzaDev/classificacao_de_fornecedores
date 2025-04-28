<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $data = [
            'razao_social' => 'required|string|max:255',
            'cnpj'         => 'required|string|size:14|unique:fornecedors,cnpj',
            'email'        => 'required|email|unique:fornecedors,email',
            'telefone'     => 'required|string|max:20',
            'cep_sede'     => 'required|string|size:8',
        ];

        if ($this->method() == "PUT") {
            $data['cnpj'] = '';
            $data['email'] = '';
        }
        return $data;
    }
}
