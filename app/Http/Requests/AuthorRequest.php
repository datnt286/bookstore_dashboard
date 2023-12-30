<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'unique:authors,name,' . $this->request->get('id'),
                'regex:/^[\p{L}\s]+$/u',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên tác giả.',
            'name.unique' => 'Tên tác giả đã tồn tại.',
            'name.regex' => 'Tên tác giả không được chứa số và ký tự đặc biệt.',
        ];
    }
}
