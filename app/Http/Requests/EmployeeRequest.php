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
        // |dimensions:min_width=100,min_height=100
        return [
            'first_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'father_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'grand_father_name' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:30',
            'first_name_am'=>'nullable|min:3|max:30',
            'father_name_am'=>'nullable|min:3|max:30',
            'grand_father_name_am' => 'nullable|min:3|max:30',
            'gender'=>'required',
            'date_of_birth' =>'required',
            'photo' =>'nullable',
            'birth_city' =>'required',
            'passport' =>'nullable',
            'driving_licence' =>'nullable',
            'blood_group' =>'nullable',
            'eye_color' =>'nullable',
            'phone_number' => 'required|numeric|digits:10|unique:employees,phone_number',
            'alternate_email' => 'nullable|email|unique:employees,alternate_email',
            'rfid' => 'nullable|numeric|unique:employees,rfid',
            'employment_identity' => 'nullable|numeric|unique:employees,employment_identity',
            'marital_status_id' =>'required',
            'ethnicity_id' =>'nullable',
            'religion_id' =>'required',
            'unit_id' =>'nullable',
            'employement_date'=>'required|date',
            'salary_step' =>'nullable',
           // 'nationality_id' =>'required',
            'employment_type_id' =>'required',
            'employee_category_id'=>'required',
            'pention_number'  => 'nullable|numeric|unique:employees,pention_number',
            'employment_status_id' =>'nullable',
            'static_salary'=>'nullable',
            'uas_user_id' =>'nullable',
            'position_id'=> 'nullable',
            'educational_level_id' => 'required',
            'field_of_study_id' => 'required',

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
