<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (strpos($this->path(), 'user') !== false)
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
            'password' => 'required',
            'name' => 'required',
            'school_id' => 'required',
            'grade' => 'required',
            'plan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id' => 'ユーザIDは必須です。',
            'password' => 'パスワードは必須です。',
            'name' => '名前は必須です。',
            'school_id' => '学校名は必須です。',
            'grade' => '学年は必須です。',
            'plan' => '通塾コースは必須です。',
        ];
    }
}
