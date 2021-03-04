<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'sometimes|string|max:255|nullable',
            'phone' => 'sometimes|string|max:255|nullable',
            'telegram' => 'sometimes|string|max:255|nullable',
            'skype' => 'sometimes|string|max:255|nullable',
        ];
    }
}
