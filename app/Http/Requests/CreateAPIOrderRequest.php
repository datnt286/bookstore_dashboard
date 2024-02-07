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
            'name' => [
                'required',
                'regex:/^[\p{L}\s]+$/u',
            ],
            'phone' => [
                'required',
                'regex:/^0\d{9}$/',
            ],
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng.',
            'name.regex' => 'Tên khách hàng không được chứa số hoặc ký tự đặc biệt.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại chỉ được chứa ký tự số, bắt đầu bằng số 0 và đủ 10 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
        ];
    }
}
