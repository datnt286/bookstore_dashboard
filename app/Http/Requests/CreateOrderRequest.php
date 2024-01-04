<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
                'regex:/^[\p{L}\s]+$/u',
            ],
            'phone' => [
                'required',
                'regex:/^\d+$/',
                'size:10',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
            ],
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên.',
            'name.regex' => 'Họ tên không được chứa số hoặc ký tự đặc biệt.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.regex' => 'Số điện thoại chỉ được chứa ký tự số và bắt đầu bằng số 0.',
            'phone.size' => 'Số điện thoại phải đủ 10 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Sai định dạng email.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
        ];
    }
}
