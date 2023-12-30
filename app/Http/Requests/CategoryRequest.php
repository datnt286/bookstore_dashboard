<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|unique:categories,name,' . $this->request->get('id'),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên thể loại không được bỏ trống.',
            'name.unique' => 'Tên thể loại đã tồn tại.',
        ];
    }
}
