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
            'first_name'=>'required',
            'father_name'=>'required',
            'grand_father_name' => 'required',
            'first_name_am'=>'nullable',
            'father_name_am'=>'nullable',
            'grand_father_name_am' => 'nullable',
            'gender'=>'required',
            'date_of_birth' =>'required',
            'photo' =>'nullable',
            'birth_city' =>'required',
            'passport' =>'nullable',
            'driving_licence' =>'nullable',
            'blood_group' =>'nullable',
            'eye_color' =>'nullable',
            'phone_number' => 'required|numeric|digits:10',
            'alternate_email' => 'nullable|email|unique:employees,alternate_email,'.request()->id,
            'rfid' => 'nullable|numeric|unique:employees,rfid,'.request()->id,
            'employment_identity' => 'nullable|numeric|unique:employees,employment_identity,'.request()->id,
            'marital_status_id' =>'required',
            'ethnicity_id' =>'nullable',
            'religion_id' =>'nullable',
            'unit_id' =>'nullable',
            'employement_date'=>'required|date',
            'salary_step' =>'nullable',
            'nationality_id' =>'required',
            'employment_type_id' =>'required',
            'employee_category_id'=>'required',
            'pention_number'  => 'nullable|numeric|unique:employees,pention_number,'.request()->id,
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
