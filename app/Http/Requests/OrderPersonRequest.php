<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderPersonRequest extends FormRequest
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
            'position' => 'sometimes|string|max:255|nullable',
            'email' => 'sometimes|string|max:255|nullable',
            'phone' => 'sometimes|string|max:255|nullable',
            'telegram' => 'sometimes|string|max:255|nullable',
            'skype' => 'sometimes|string|max:255|nullable',
            'order_id'=>'required|exists:App\Models\Order,id'
        ];
    }
}
