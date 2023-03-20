<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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

            'name' =>'required',
            'email' =>'nullable|email',
            'mission'=>'nullable|regex:/^[a-z A-Z]+$/u|min:5|max:100',
            'vision' =>'nullable|regex:/^[a-z A-Z]+$/u|min:5|max:100',
            'motto' =>'required|regex:/^[a-z A-Z]+$/u|min:5|max:100',
          //  'logo' =>'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048|dimensions:min_width=50,min_height=70',
            'web_address' =>'nullable|min:5|max:30',
            'fax' =>'nullable|numeric|digits:10',
            'telephone' =>'nullable|numeric|digits:10',
            'pobox'=>'nullable|numeric',
           // 'seal' =>'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048|dimensions:min_width=50,min_height=50',
           // 'president_signature'=>'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048|dimensions:min_width=50,min_height=50',
           // 'account_number' =>'nullable|numeric|digits:13',
           // 'header' =>'nullable|regex:/^[a-z A-Z]+$/u|min:5|max:255',
           // 'footer' =>'nullable|regex:/^[a-z A-Z]+$/u|min:5|max:255',
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
