<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
                'unique:suppliers,name,' . $this->request->get('id'),
                'regex:/^[\p{L}\s\d]+$/u',
            ],
            'phone' => [
                'required',
                'unique:suppliers,phone,' . $this->request->get('id'),
                'regex:/^\d+$/',
                'size:10',
            ],
            'email' => [
                'required',
                'unique:suppliers,email,' . $this->request->get('id'),
                'email:rfc,dns',
            ],
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên nhà cung cấp.',
            'name.unique' => 'Tên nhà cung cấp đã tồn tại.',
            'name.regex' => 'Tên nhà cung cấp không được chứa ký tự đặc biệt.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.regex' => 'Số điện thoại chỉ được chứa ký tự số và bắt đầu bằng số 0.',
            'phone.size' => 'Số điện thoại phải đủ 10 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'email.email' => 'Sai định dạng email.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
        ];
    }
}
