<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'first_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'father_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'grand_father_name' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'gender'=>'required',
            'date_of_birth' =>'required',
            'photo' =>'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100',
            'birth_city' =>'required',
            'passport' =>'required',
            'driving_licence' =>'required',
            'blood_group' =>'required',
            'eye_color' =>'required',
            'phone_number' => 'required|numeric|digits:10|unique:employees,phone_number',
            'alternate_email' => 'required|email|unique:employees,alternate_email',
            'rfid' => 'required|numeric|unique:employees,rfid',
            'employment_identity' => 'required|numeric|unique:employees,employment_identity',
            'marital_status_id' =>'required',
            'ethnicity_id' =>'required',
            'religion_id' =>'required',
            'unit_id' =>'required',
            'employement_date'=>'required|date',
            'salary_step' =>'required',
            'job_title_id' =>'required',
            'employment_type_id' =>'required',
            'pention_number'  => 'required|numeric|unique:employees,pention_number',
            'employment_status_id' =>'required',
            'static_salary'=>'required',
            'uas_user_id' =>'required',
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
