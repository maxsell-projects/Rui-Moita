<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecruitmentRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        // Alterado para true para permitir o envio do formulário
        return true;
    }

    /**
     * Regras de validação para a candidatura.
     */
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['required', 'string', 'max:20'],
            'cv'      => ['required', 'file', 'mimes:pdf', 'max:5120'], // Máximo 5MB
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }
}