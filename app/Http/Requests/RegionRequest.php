<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Region;

class RegionRequest extends FormRequest
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
            'order' => 'required|numeric',
            'last_modified_by' => 'required'
        ];


        if ($this->isMethod('PUT')) {
            $region = $this->segment(4) ? Region::find($this->segment(4)) : NULL;

            if ($region) {
                $rules['region_name'] = ['required', 'max:60', 'min:2', Rule::unique('regions')->ignore($region->id)];
            }
        } else {
            $rules['region_name'] = 'required|unique:regions|max:60|min:2';
        }

        return $rules;
    }
}
