<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaldoVacunaFormRequest extends FormRequest
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
        $codVacuna = $this->cod_vacuna;
        $mes = $this->mes;
        $anio = $this->anio;
        return [
            // 'cod_vacuna' => 'required|unique:saldo,cod_vacuna,NULL,cod_saldo,mes,' . $mes . ',anio,' . $anio,
            'cod_vacuna' => 'required|unique:saldo,cod_vacuna,'.$this->cod_saldo.',cod_saldo,mes,' . $mes . ',anio,' . $anio,
            'stock' => 'required|integer',
            'mes' => 'required',
            'anio' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cod_vacuna.required' => 'Seleccione una vacuna es obligatorio.',
            'cod_vacuna.unique' => 'El saldo para esta vacuna ya está registrado para el mes y año proporcionados.',
            'stock.required' => 'El campo stock es obligatorio.',
            'stock.integer' => 'El campo stock debe ser un número entero.',
            'mes.required' => 'El campo mes es obligatorio.',
            'anio.required' => 'El campo año es obligatorio.',
        ];
        
    }
}
