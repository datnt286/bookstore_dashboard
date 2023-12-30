<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublisherRequest extends FormRequest
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
                'unique:publishers,name,' . $this->request->get('id'),
                'regex:/^[\p{L}\s\d]+$/u',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên nhà xuất bản.',
            'name.unique' => 'Tên nhà xuất bản đã tồn tại.',
            'name.regex' => 'Tên nhà xuất bản không được chứa ký tự đặc biệt.',
        ];
    }
}
