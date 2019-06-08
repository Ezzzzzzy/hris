<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\City;

class CityRequest extends FormRequest
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
            'enabled' => 'numeric',
            'last_modified_by' => 'required',
            'region_id' => 'required'
        ];

        if ($this->isMethod('PUT')) {
            $city = $this->segment(5) ? City::find($this->segment(5)) : NULL;

            if ($city) {
                $rules['city_name'] = ['required', 'max:60', 'min:2', Rule::unique('cities')->ignore($city->id)];
            }
        } else {
            $rules['city_name'] = 'required|unique:cities|max:60|min:2';
        }

        return $rules;
    }
}
