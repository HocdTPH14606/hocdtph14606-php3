<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Điều kiện để có thể gửi yêu cầu đi
        // Nếu false thì không có quyền gửi yêu cầu 403
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:30',
            'email' => 'required|email',
            'role' => 'required',
            'status' => 'required',
            'username' => 'required|min:2|max:15',
            'phone' => 'required'
        ];
    }

    // Cấu hình nội dung messages theo rules bên trên
    public function messages()
    {
        return [
            'name.required' => 'Tên bắt buộc nhập',
            'name.min' => 'Tên tối thiểu 2 ký tự',
            'name.max' => 'Tên tối đa 30 ký tự',
            'username.required' => 'username bắt buộc nhập',
            'username.min' => 'username tối thiểu 2 ký tự',
            'username.max' => 'username tối đa 15 ký tự',
            'email.required' => 'Email bắt buộc nhập',
            'email.email' => 'Email phải đúng định dạng',
            'status.required' => 'status bắt buộc nhập',
            'role.required' => 'role bắt buộc nhập',
            'phone.required' => 'SĐT bắt buộc nhập'
        ];
    }
}
