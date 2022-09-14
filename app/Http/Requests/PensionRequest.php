<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PensionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => 'required|min:5|max:255'

            'name' =>'required|regex:/^[a-zA-Z]+$/u|min:5|max:30',
            'gender' =>'required',
            'year' => 'required|digits:4|integer|min:1990|max:'.(date('Y')+1),
            'extend_year' => 'required|digits:4|integer|min:1990|max:'.(date('Y')+1),
          //  'extend_year' => 'required|digits:4',
            'employee_category_id'=>'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
