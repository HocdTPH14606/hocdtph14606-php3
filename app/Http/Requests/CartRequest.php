<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'name' => 'required|min:2|max:50',
            'email' => 'required|email',
            'phone' => 'required|min:2',
            'address' => 'required|min:5|max:100',
            

        ];
    }

    // Cấu hình nội dung messages theo rules bên trên
    public function messages()
    {
        return [
            // 'name.required' => 'Tên bắt buộc nhập',
            // 'name.min' => 'Tên tối thiểu 2 ký tự',
            // 'name.max' => 'Tên tối đa 50 ký tự',

            'email.required' => 'email bắt buộc nhập',
            'email.email' => 'email phải đúng định dạng',

            'phone.required' => 'phone bắt buộc nhập', 
            'phone.min' => 'phone tối thiểu 2 ký tự', 

            'address.required' => 'address bắt buộc nhập',
            'address.min' => 'address tối thiểu 5 ký tự',
            'address.max' => 'address tối đa 100 ký tự',

        ];
    }
}