<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'source' => 'required||in:' . implode(',', orderSources()),
            'stacks' => 'array|min:1|required||in:' . implode(',', stacksList()),
            'currency' => 'required_with:budget||in:' . implode(',', currenciesList()),
            'budget' => 'required_with:currency|numeric|between:1,90000|nullable',
            'description' => 'sometimes|string|nullable',
            'agent_id' => 'required|exists:App\Models\Agent,id'

        ];

        if ($this->method() === 'PUT') {
            $rules['status'] = 'required';
        }

        return $rules;


    }
}
