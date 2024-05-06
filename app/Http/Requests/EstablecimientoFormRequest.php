<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablecimientoFormRequest extends FormRequest
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
            'nombre_est' => 'required|max:191'
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre del establecimiento es obligatorio.',
            'nombre.max' => 'El campo nombre del establecimiento no puede exceder los 191 caracteres.',
        ];
    }
}
