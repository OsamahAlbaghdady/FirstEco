<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $this->id ? $name = 'required|unique:clients,name,'.$this->id : $name = 'required|unique:clients,name';

        return [
            'name' => $name,
            // 'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required'
        ];
    }
}
