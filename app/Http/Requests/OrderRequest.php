<?php

namespace App\Http\Requests;

use App\Http\Repositories\DeveloperRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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


        return [
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'source' => 'required||in:' . implode(',', orderSources()),
            'stacks' => 'array|min:1|required||in:' . implode(',', stacksList()),
            'currency' => 'required_with:budget||in:' . implode(',', currenciesList()),
            'budget' => 'required_with:currency|numeric|between:1,90000|nullable',
            'description' => 'sometimes|string|nullable',
            'agent_id' => 'required|exists:App\Models\Agent,id',
//            'team_lid_id' => ['required',
//                Rule::exists('developers')->where(function ($query) {
//                    $query->where([
//                        'id' => $this->get('team_lid_id'),
//                        'status' => DeveloperRepository::STATUS_ACCEPTED
//                    ]);
//                })
//            ],
            'developer_id' => ['required',
                Rule::exists('developers')->where(function ($query) {
                    $query->where([
                        'id' => $this->get('developer_id'),
                        'status' => DeveloperRepository::STATUS_ACCEPTED
                    ]);
                })
            ],

        ];


    }
}
