<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\TenureType;

class TenureTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'month_start_range' => 'required',
            'month_end_range' => 'required',
            'enabled' => 'required'
        ];

        if ($this->isMethod('PUT')) {
            $tenure_type = $this->segment(5) ? TenureType::find($this->segment(5)) : NULL;

            if ($tenure_type) {
                $rules['tenure_type'] = ['required', 'max:60', 'min:2', Rule::unique('tenure_types')->ignore($tenure_type->id)];
            }
        } else {
            $rules['tenure_type'] = 'required|max:60|min:2|unique:tenure_types';
        }

        return $rules;
    }
}
