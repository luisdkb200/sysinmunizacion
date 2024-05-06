<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacunaFormRequest extends FormRequest
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
            'nombre' => 'required|max:191'
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la vacuna es obligatorio.',
            'nombre.max' => 'El nombre de la vacuna no puede exceder los 191 caracteres.',
        ];
    }
}
