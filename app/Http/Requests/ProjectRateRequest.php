<?php

namespace App\Http\Requests;

use App\Http\Repositories\DeveloperRepository;
use App\Http\Repositories\StackRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRateRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'pay_day' => 'required|numeric|min:1|max:31',
            'currency' => 'required',
            'budget' => 'required'
        ];


    }
}
