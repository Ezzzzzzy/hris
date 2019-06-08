<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Reason;

class ReasonRequest extends FormRequest
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
            'remarks' => 'required',
            'last_modified_by' => 'required',
            'order' => 'required'
        ];

        if ($this->isMethod('PUT')) {
            $reason = $this->segment(4) ? Reason::find($this->segment(4)) : NULL;
            
            if ($reason) {
                $rules['reason'] = ['required', 'max:60', 'min:2', 'alpha', Rule::unique('reasons')->ignore($reason->id)];
            }
        } else {
            $rules['reason'] = "unique:reasons|required|max:60|min:2|alpha";
        }

        return $rules;
    }
}
