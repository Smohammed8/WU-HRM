<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvalutionCreteriaRequest extends FormRequest
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
            'evaluation_category_id' => 'required',
            'name' =>  'required|unique:evalution_creterias,name|regex:/^[a-z A-Z]+$/u|min:2|max:255',
            'percent' => 'required|numeric|min:3|max:50',
            'discription '=>  'nullable|regex:/^[a-z A-Z]+$/u|min:5|max:255',
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
