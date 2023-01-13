<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFamilyRequest extends FormRequest
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

            'employee_id' =>'required',
            'family_relationship_id' =>'required',
            'first_name' =>'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'father_name' =>'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'grand_father_name' =>'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'gender' =>'required',
            'dob' =>'required',
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
