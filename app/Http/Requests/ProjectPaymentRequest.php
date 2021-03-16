<?php

namespace App\Http\Requests;

use App\Http\Repositories\DeveloperRepository;
use App\Http\Repositories\StackRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectPaymentRequest extends FormRequest
{
    protected $errorBag = 'projectPaymentForm';

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
            'rate' => 'required|exists:App\Models\ProjectRate,id',
            'date' => 'required|date_format:Y-m-d',
            'attachment' => 'sometimes|base64image|nullable'

        ];


    }
}
