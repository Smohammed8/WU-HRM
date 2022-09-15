<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChairManTypeRequest extends FormRequest
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
           'name' => 'required|unique:chair_man_types|regex:/^[a-z A-Z]+$/u|min:5|max:50',
          //'username' => 'required|string|min:3|max:50|alpha_dash|unique:chair_man_types',
            'description'=>'nullable|regex:/^[a-zA-Z]+$/u|min:20|max:255',
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
