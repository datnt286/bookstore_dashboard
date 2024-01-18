<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAPIOrderRequest extends FormRequest
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
            'user.name' => [
                'required',
                'regex:/^[\p{L}\s]+$/u',
            ],
            'user.phone' => [
                'required',
                'regex:/^\d+$/',
                'size:10',
            ],
            'user.email' => [
                'required',
                'email:rfc,dns',
            ],
            'user.address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user.name.required' => 'Vui lòng nhập tên khách hàng.',
            'user.name.regex' => 'Tên khách hàng không được chứa số hoặc ký tự đặc biệt.',
            'user.phone.required' => 'Vui lòng nhập số điện thoại.',
            'user.phone.regex' => 'Số điện thoại chỉ được chứa ký tự số và bắt đầu bằng số 0.',
            'user.phone.size' => 'Số điện thoại phải đủ 10 ký tự.',
            'user.email.required' => 'Vui lòng nhập email.',
            'user.email.email' => 'Sai định dạng email.',
            'user.address.required' => 'Vui lòng nhập địa chỉ.',
        ];
    }
}
