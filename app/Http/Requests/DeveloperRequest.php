<?php

namespace App\Http\Requests;

use App\Http\Repositories\StackRepository;
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
            'stacks' => 'array|min:1|required||in:' . implode(',', (new StackRepository())->pluckFiled('id')),
            'phone' => 'sometimes|string|max:255|nullable',
            'cv' => 'sometimes|mimes:doc,pdf,docx|max:4072|nullable',
            'position' => 'required||in:' . implode(',', developerPositions()),
        ];

        if ($this->method() === 'PUT') {
            $rules['cv'] = 'sometimes|mimes:doc,pdf,docx|max:4072|nullable';
            $rules['status'] = 'required';
        }


        return $rules;
    }
}
