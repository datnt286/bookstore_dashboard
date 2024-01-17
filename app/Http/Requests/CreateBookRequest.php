<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
                'unique:books,name,' . $this->request->get('id'),
            ],
            'category_id' => 'required',
            'publisher_id' => 'required',
            'supplier_id' => 'required',
            'num_pages' => $this->input('num_pages') ? 'numeric' : '',
            'price' => 'required|numeric',
            'e_book_price' => $this->input('e_book_price') ? 'numeric' : '',
            'quantity' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sách.',
            'name.unique' => 'Tên sách đã tồn tại.',
            'category_id.required' => 'Vui lòng chọn thể loại.',
            'publisher_id.required' => 'Vui lòng chọn nhà xuất bản.',
            'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'num_pages.numeric' => 'Số trang phải là số.',
            'price.required' => 'Vui lòng nhập giá bán.',
            'price.numeric' => 'Giá bán phải là số.',
            'e_book_price.numeric' => 'Giá e-book phải là số.',
            'quantity.required' => 'Vui lòng nhập số lượng sách.',
            'quantity.numeric' => 'Số lượng sách phải là số.',
        ];
    }
}
