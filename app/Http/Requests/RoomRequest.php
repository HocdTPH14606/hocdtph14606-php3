<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'name' => 'required|min:2|max:30', 
            'status' => 'required' 
        ];
    }

    // Cấu hình nội dung messages theo rules bên trên
    public function messages()
    {
        return [
            'name.required' => 'Tên bắt buộc nhập',
            'name.min' => 'Tên tối thiểu 2 ký tự',
            'status.required' => 'status bắt buộc nhập',
            'name.max' => 'Tên tối đa 30 ký tự', 
        ];
    }
}
