<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
          //  'name'=>'required|regex:/^[a-z A-Z]+$/u|max:30',
            'name'=>'required',
           
          //  'acronym' =>'required|regex:/^[a-z A-Z]+$/u|min:2|max:10',
           // 'email'=>'required|email',
           // 'telephone' =>'required|numeric|digits:10',
            // 'extension_line' =>'required|regex:/^[a-z A-Z]+$/u|min:5|max:50',
            // 'location' =>'required|regex:/^[a-z A-Z]+$/u|min:5|max:30',
            // 'teter' =>'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048|dimensions:min_width=50,min_height=50',
            // 'seal' =>'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048|dimensions:min_width=50,min_height=50',
            // 'vision'=>'required|regex:/^[a-z A-Z]+$/u|min:5|max:30',
           // 'mission'=>'required|regex:/^[a-z A-Z]+$/u|min:5|max:30',
            //'objective' =>'required|regex:/^[a-z A-Z]+$/u|min:5|max:30',
           // 'building_number'=>'required',
            //'office_number'=>'required',
           // 'motto'=>'regex:/^[a-z A-Z]+$/u|min:5|max:50',
           // 'value_list'=>'required|regex:/^[a-z A-Z]+$/u|min:10|max:255',
          //  'parent_unit_id'=>'required',
           // 'reports_to_id' =>'required|regex:/^[a-z A-Z]+$/u|min:5|max:30',
            //'organization_id' =>'required',
            //'chair_man_type_id'=>'required',
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
