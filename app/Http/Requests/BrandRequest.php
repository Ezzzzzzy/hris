<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Brand;

class BrandRequest extends FormRequest
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
        // Create an array of validation ruleset for your attributes
        $rules = [
            'business_unit_id' => 'required',
            'brand_name' => 'required',
        ];

        if ($this->isMethod('PUT')) {
            // Get the fourth segment in our resource's URI/Route (/api/v1/brand/{id})
            $brand = $this->segment(4) ? Brand::find($this->segment(4)) : NULL;
            // If $brand is not NULL, execute condition
            if ($brand) {
                // If method is PUT, ignore given id then apply validation
                $rules['brand_name'] = ['required', 'max:191', 'min:2','alpha_dash', Rule::unique('brands')->ignore($brand->id)];
            }
        } else {
            $rules['brand_name'] = 'required|alpha_dash|max:191|min:2|unique:brands';
        }
        
        return $rules;
    }
}
