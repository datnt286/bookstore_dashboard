<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComboRequest extends FormRequest
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
                'unique:combos,name,' . $this->request->get('id'),
            ],
            'supplier_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image' => [
                $this->has('image') ? 'image' : '',
                $this->has('image') ? 'max:2048' : '',
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên combo.',
            'name.unique' => 'Tên combo đã tồn tại.',
            'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'price.required' => 'Vui lòng nhập giá combo.',
            'price.numeric' => 'Giá combo phải là số.',
            'quantity.required' => 'Vui lòng nhập số lượng combo.',
            'quantity.numeric' => 'Số lượng combo phải là số.',
            'image.image' => 'File phải là hình ảnh.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2 MB.',
        ];
    }
}
