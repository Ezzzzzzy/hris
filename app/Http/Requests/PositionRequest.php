<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Position;

class PositionRequest extends FormRequest
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
            'enabled' => 'required',
            'last_modified_by' => 'required',
            'order' => 'required'
        ];

        if ($this->isMethod('PUT')) {
            $position = $this->segment(5) ? Position::find($this->segment(5)) : NULL;

            if ($position) {
                $rules['position_name'] = ['required', 'max:60', 'min:2', Rule::unique('positions')->ignore($position->id)];
            }
        } else {
            $rules['position_name'] = 'required|max:60|min:2|unique:positions';
        }

        return $rules;
    }
}
