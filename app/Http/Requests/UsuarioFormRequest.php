<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioFormRequest extends FormRequest
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
            //
            'name' => 'required|max:191',
            'telUse' => 'max:15',
            'email' => 'required|max:191|unique:users,email,'. $this->id . ',id',
            'password' => !empty($this->password) ? ['string', 'min:4', 'confirmed'] : '',
            'password_confirmation' => !empty($this->password_confirmation) && empty($this->password) ? 'confirmed': '',
            // 'tipUse' => 'required|max:45'
        ];
    }
}
