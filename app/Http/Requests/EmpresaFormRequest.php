<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaFormRequest extends FormRequest
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
            'nomEmp' => 'required|max:191',
            'direcEmp' => 'required|max:191',
            'telefEmp' => 'nullable|max:15',
            'nroRucEmp' => 'nullable|max:11',
            // 'logoEmp' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'nomEmp.required' => 'El campo nombre de la empresa es obligatorio.',           
            'nomEmp.max' => 'El campo nombre de la empresa no puede exceder los 191 caracteres.',
            'direcEmp.required' => 'El campo dirección de la empresa es obligatorio.',           
            'direcEmp.max' => 'El campo dirección de la empresa no puede exceder los 191 caracteres.',          
            'telefEmp.max' => 'El campo teléfono de la empresa no puede exceder los 15 caracteres.',          
            'nroRucEmp.max' => 'El campo número de RUC de la empresa no puede exceder los 11 caracteres.',          
            // 'logoEmp.max' => 'El campo logo de la empresa no puede exceder los 191 caracteres.',          
        ];
    }
}
