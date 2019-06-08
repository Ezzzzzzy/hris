<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\DocumentType;

class DocumentTypeRequest extends FormRequest
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
            'order' => 'required',
            'enabled' => 'required',
            'document_type' => 'required'
        ];

        if ($this->isMethod('PUT')) {
            $doc_type = $this->segment(5) ? DocumentType::find($this->segment(5)) : NULL;

            if ($doc_type) {
                $rules['type_name'] = ['required', 'max:191', 'min:2', 'alpha_dash', Rule::unique('document_types')->ignore($doc_type->id)];
            }
        } else {
            $rules['type_name'] = 'required|unique:document_types|max:191|min:2|alpha_dash';
        }

        return $rules;
    }
}
