<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
                'unique:customers,name,' . $this->request->get('id'),
                'regex:/^[\p{L}\s]+$/u',
            ],
            'phone' => [
                'required',
                'unique:customers,phone,' . $this->request->get('id'),
                'regex:/^\d+$/',
                'size:10',
            ],
            'email' => [
                'required',
                'unique:customers,email,' . $this->request->get('id'),
                'email:rfc,dns',
            ],
            'address' => 'required',
            'avatar' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng.',
            'name.regex' => 'Tên khách hàng không được chứa số hoặc ký tự đặc biệt.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.regex' => 'Số điện thoại chỉ được chứa ký tự số và bắt đầu bằng số 0.',
            'phone.size' => 'Số điện thoại phải đủ 10 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'email.email' => 'Sai định dạng email.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'avatar.image' => 'File phải là hình ảnh.',
        ];
    }
}
