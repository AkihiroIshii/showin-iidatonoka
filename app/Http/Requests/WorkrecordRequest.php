<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkrecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (strpos($this->path(), 'workrecord') !== false)
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
            'user_id' => 'required',
            'exam_id' => 'required',
            'subject' => 'required',
            'work_name' => 'nullable',
            'work_range' => 'nullable',
            'memo' => 'nullable',
            'date_1st' => 'nullable',
            'date_2nd' => 'nullable',
            'date_3rd' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'exam_id' => '試験名は必須です。',
        ];
    }
}
