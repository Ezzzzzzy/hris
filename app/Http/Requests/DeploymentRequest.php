<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\BranchWorkHistory;

class DeploymentRequest extends FormRequest
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
            'client_work_history_id' => 'required',
            'employment_status_id' => 'required',
            'position_id' => 'required',
            'branch_id' => 'required',
            'status' => 'required|alpha'
        ];

        if ($this->hasMethod('PUT')) {
            $deployment = $this->segment(4) ? BranchWorkHistory::find($this->segment(4)) : NULL;

            if ($deployment) {
                $rules['reason_id'] = ['required', Rule::unique(branch_work_histories)->ignore($deployment->id)];
                $rules['employment_status_id'] = ['required', Rule::unique(branch_work_histories)->ignore($deployment->id)];
                $rules['reason_for_leaving_remarks'] = ['required', 'alpha_dash', Rule::unique(branch_work_histories)->ignore($deployment->id)];
                $rules['date_end'] = ['required', Rule::unique(branch_work_histories)->ignore($deployment->id)];
            }
        } else {
            $rules['reason_id'] = 'required';
            $rules['employment_status_id'] = 'required';
            $rules['reason_for_leaving_remarks'] = 'required|unique:branch_work_histories|alpha_dash';
            $rules['date_end'] = 'required';
        }

        return $rules;
    }
}
