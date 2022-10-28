<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobGradeRequest extends FormRequest
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


            'level_id' =>'required',

            'start_salary'  => 'required|numeric|min:1100|max:20468',
            'one'  => 'required|numeric|min:1174|max:21092',
            'two'  => 'required|numeric|min:1253|max:21725',
            'three'  => 'required|numeric|min:1338|max:22361',
            'four'  => 'required|numeric|min:1428|max:23005',
            'five'  => 'required|numeric|min:1523|max:23654',
            'six'  => 'required|numeric|min:1624|max:24305',
            'seven'  => 'required|numeric|min:1731|max:24961',
            'eight'  => 'required|numeric|min:1843|max:25622',
            'nine'  => 'required|numeric|min:1958|max:26288',
            'ceil_salary'  => 'required|numeric|min:2079|max:26959',
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
