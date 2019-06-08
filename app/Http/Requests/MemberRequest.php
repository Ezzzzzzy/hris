<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Member;

class MemberRequest extends FormRequest
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
            'new_member_id' => 'exists:members,new_member_id|alpha_dash|max:60|min:2',
            'first_name' => 'required|max:60|min:2|alpha',
            'last_name' => 'required|max:60|min:2|alpha',
            'address_cities_permanent_id' => 'required',
            'address_cities_present_id' => 'required',
            'present_address' => 'required|max:100|min:5',
            'permanent_address' => 'required|max:100|min:5',
            'gender' => 'required',
            'civil_status' => 'required|max:60',
            'birthdate' => 'required',
            'birthplace' => 'required|max:100|min:5',
            'mobile_number' => 'required',
            'telephone_number' => 'required',
            'references_data' => 'required',
            'school_data' => 'required',
            'emp_history_data' => 'required',
            'family_data' => 'required',
            'emergency_data' => 'required',
        ];

        if ($this->isMethod('PUT')) {
            $member = $this->segment(4) ? Member::find($this->segment(4)) : NULL;
            if ($member) {
                $rules['tin'] = ['required', 'max:15', 'min:15', 'alpha_dash', Rule::unique('members')->ignore($member->id)];
                $rules['sss_num'] = ['required', 'max:12', 'min:12', 'alpha_dash', Rule::unique('members')->ignore($member->id)];
                $rules['pag_ibig_num'] = ['required', 'max:15', 'min:15', 'alpha_dash', Rule::unique('members')->ignore($member->id)];
                $rules['philhealth_num'] = ['required', 'max:12', 'min:12', 'numeric', Rule::unique('members')->ignore($member->id)];
                $rules['email_address'] = ['required', 'max:60', 'alpha', Rule::unique('members')->ignore($member->id)];
                $rules['existing_member_id'] = ['required', 'max:60', 'alpha_dash', Rule::unique('members')->ignore($member->id)];
            }
        } else {
            $rules['tin'] = 'required|max:15|min:15|alpha_dash|unique:members';
            $rules['sss_num'] = 'required|max:12|min:12|alpha_dash|unique:members';
            $rules['pag_ibig_num'] = 'required|max:15|min:15|alpha_dash|unique:members';
            $rules['philhealth_num'] = 'required|max:12|min:12|numeric|unique:members';
            $rules['email_address'] = 'required|max:60|alpha|unique:members';
            $rules['existing_member_id'] = 'required|max:60|alpha_dash|unique:members';
        }

        return $rules;        
    }

    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json($validator->errors()->all(), 422)); 
    }
}