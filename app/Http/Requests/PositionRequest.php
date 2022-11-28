<?php

namespace App\Http\Requests;

use App\Models\Position;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PositionRequest extends FormRequest
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
        $jobTitleId = $this->input('job_title_id');
        $unitId = $this->input('unit_id');
        if (Position::where('job_title_id', $jobTitleId)->where('unit_id', $unitId)->count() > 0) {
            if (in_array($this->method(), ['GET'])) {
                throw ValidationException::withMessages(['unit' => 'Existing job within current unit']);
            }
        }
        return [
            // 'name' => 'required|min:5|max:255',
            // '' => [
            //     Rule::unique('positions')->where(function ($query) use($jobTitleId) {
            //         return $query->where('ip', $ip);
            //     }),
            // ]
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
