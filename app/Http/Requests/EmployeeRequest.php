<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
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
            'first_name' => 'required|min:3|max:30|alpha',
            'father_name' => 'required|min:3|max:30|alpha',
            'grand_father_name' => 'required|min:3|max:30|alpha',
        
            'first_name_am' => 'required|min:2|max:30',
            'father_name_am' => 'required|min:2|max:30',
            'grand_father_name_am' => 'required|min:2|max:30',
        
            'gender'=>'required',
            'date_of_birth' =>'required',
            'photo' =>'nullable',
            'birth_city' =>'required',
            'passport' =>'nullable',
            'driving_licence' =>'nullable',
            'blood_group' =>'nullable',
            'eye_color' =>'nullable',
        
            'rfid' => 'nullable|numeric|unique:employees,rfid,'.request()->id,
            'employment_identity' => 'nullable|numeric|unique:employees,   employment_identity,'.request()->id,
            'marital_status_id' =>'required',
            'ethnicity_id' =>'nullable',
            'religion_id' =>'nullable',
            'unit_id' =>'nullable',
            'employement_date'=>'required|date',
            'salary_step' =>'nullable',
            'nationality_id' =>'required',
            'employment_type_id' =>'required',

    

            'pention_number'  => 'nullable|unique:employees,pention_number,'.request()->id,
            'static_salary'=>'nullable',
            'uas_user_id' =>'nullable',
          
            'employee_category_id' => 'required',


            // 'employee_sub_category_id' => 'nullable',
            // 'position_id'=> 'required_if:employee_sub_category_id,null', 

            'position_id' => 'required_without_all:employee_sub_category_id',
            'employee_sub_category_id' => 'required_without_all:position_id',



            'educational_level_id' => 'required',
            'field_of_study_id' => 'required',
            'horizontal_level' => 'required',
            'hr_branch_id' => 'required',
            'employment_status_id' => 'required',
            'employee_title_id' => 'required',


            'national_id' => [
                'nullable',
                'string',
                'size:10', 
                //'min:10',
                //'max:10',
                'unique:employees,national_id,' . request()->id,
            ],
            'cbe_account' => [
                'nullable',
                'numeric',
                'size:13', 
                'unique:employees,cbe_account,' .request()->id, 
              
            ],
            'phone_number' => 'nullable|numeric|digits:10|unique:employees,phone_number,'.request()->id,
            'email' => 'nullable|email|unique:employees,email,'.request()->id,



        
      
       
           
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
             'position_id.required_without_all' => 'Either Job Position or sub category must be selected.',
             'employee_sub_category_id.required_without_all' => 'Sub category must be empty when Employee job position is selected.',
         ];
     }

     
}
