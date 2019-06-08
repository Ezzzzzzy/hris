<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Location;

class LocationRequest extends FormRequest
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
            'enabled' => 'required|numeric',
            'last_modified_by' => 'required|alpha',
            'city_id' => 'required',
            'location_name' => 'required'
        ];

        if ($this->isMethod('PUT')) {
            $location = $this->segment(5) ? Location::find($this->segment(5)) : NULL;

            if ($location) {
                $rules['location_name'] = ['required', 'alpha', 'max:60', 'min:2', Rule::unique('locations')->ignore($location->id)];
            }
        } else {
            $rules['location_name'] = 'required|unique:location|max:60|min:2|alpha';
        }

        return $rules;
    }
}
