<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingAndStudyRequest extends FormRequest
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
            'name' =>'required|regex:/^[a-zA-Z]+$/u|min:5|max:30',
            'nationality_id' =>'required',
            'educational_level_id' =>'required',
            'inistitution'=>'required|regex:/^[a-zA-Z]+$/u|min:5|max:100',
            'city' =>'required|regex:/^[a-zA-Z]+$/u|min:5|max:100',
            'is_contract' =>'required',
            'date_of_leave'=>'required|date',
            'end_of_study'=>'required|date',
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
