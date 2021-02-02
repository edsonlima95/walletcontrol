<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Invoice extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'value' => 'required',
            'due_at' => 'required',
            'wallet_id' => 'required',
            'category_id' => 'required',
            'repeat_when' => (!empty($this->request->all()['id'])) ? '' : 'required'
        ];
    }

    public function messages()
    {
        return [
            'repeat_when.required' => 'Selecione uma opção (UNICA, FIXA ou PARCELADA)'
        ];
    }
}
