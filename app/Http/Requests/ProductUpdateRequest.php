<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;// Điều kiện để có thể gửi yêu cầu đi
        // Nếu false thì không có quyền gửi yêu cầu 403
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50',
            'price' => 'required|int',
            'status' => 'required'

        ];
    }

    // Cấu hình nội dung messages theo rules bên trên
    public function messages()
    {
        return [
            'name.required' => 'Tên bắt buộc nhập',
            'name.min' => 'Tên tối thiểu 2 ký tự',
            'name.max' => 'Tên tối đa 50 ký tự',
            'price.required' => 'price bắt buộc nhập',
            'status.required' => 'status bắt buộc nhập',
            'price.int' => 'price phải đúng định dạng'  
        ];
    }
}
