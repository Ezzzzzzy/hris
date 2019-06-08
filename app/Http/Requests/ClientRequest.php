<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Client;

class ClientRequest extends FormRequest
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
            'last_modified_by' => 'required'
        ];

        if ($this->isMethod('PUT')) {
            $client = $this->segment(4) ? Client::find($this->segment(4)) : NULL;

            if ($client) {
                $rules['code'] = ['required', 'alpha_dash', 'max:60', Rule::unique('clients')->ignore($client->id)];
                $rules['client_name'] = ['required', 'alpha_dash', 'max:60', Rule::unique('clients')->ignore($client->id)];
            }
        } else {
            $rules['client_name'] = 'required|unique:clients|alpha_dash|max:60|min:2';
            $rules['code'] = 'required|unique:clients|alpha_dash|max:60';
        }

        return $rules;
    }
}
