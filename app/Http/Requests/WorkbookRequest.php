<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkbookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (strpos($this->path(), 'workbook') !== false)
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject' => 'required',
            'field' => 'required',
            'grade' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'reference' => 'nullable'
        ];
    }
}
