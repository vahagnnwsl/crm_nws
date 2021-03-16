<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeveloperInterviewRequest extends FormRequest
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
            'test_name' => 'required|string|max:255',
            'test_result' => 'required|string',
            'interviewer' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d',
            'position' => 'required||in:' . implode(',', developerPositions()),

        ];
    }
}
