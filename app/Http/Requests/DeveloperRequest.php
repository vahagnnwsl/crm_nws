<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeveloperRequest extends FormRequest
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

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'sometimes|string|max:255|nullable',
            'phone' => 'sometimes|string|max:255|nullable',
            'cv' => 'required|mimes:doc,pdf,docx|max:4072',
            'position' => 'required||in:' . implode(',', developerPositions()),
        ];

        if ($this->method() === 'PUT') {
            $rules['cv'] = 'sometimes|mimes:doc,pdf,docx|max:4072|nullable';
            $rules['status'] = 'required';
        }


        return $rules;
    }
}
