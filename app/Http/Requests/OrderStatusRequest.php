<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatusRequest extends FormRequest
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
            'status' => 'required',
            'comment' => 'required',
            'attachment' => 'sometimes|base64image|nullable',
        ];


    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'base64image' => 'File tye must be png, jpg, svg'
        ];
    }
}
