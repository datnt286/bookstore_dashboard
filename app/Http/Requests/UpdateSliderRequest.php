<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
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
                'unique:sliders,name,' . $this->request->get('id'),
            ],
            'book_id' => 'required',
            'image' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên slider.',
            'name.unique' => 'Tên slider đã tồn tại.',
            'book_id.required' => 'Vui lòng chọn sách.',
            'image.image' => 'File phải là hình ảnh.',
        ];
    }
}
