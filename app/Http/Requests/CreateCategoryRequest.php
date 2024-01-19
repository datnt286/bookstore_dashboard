<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
                'unique:categories,name,' . $this->request->get('id'),
                'regex:/^[\p{L}\s]+$/u',
            ],
            'image' => [
                'required',
                'image',
                'max:2048',
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên thể loại.',
            'name.unique' => 'Tên thể loại đã tồn tại.',
            'name.regex' => 'Tên thể loại không được chứa số và ký tự đặc biệt.',
            'image.required' => 'Vui lòng chọn hình ảnh.',
            'image.image' => 'File phải là hình ảnh.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2 MB.',
        ];
    }
}
