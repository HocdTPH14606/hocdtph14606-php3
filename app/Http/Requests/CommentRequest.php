<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'content' => 'required|min:1|max:500', 
        ];
    }

    // Cấu hình nội dung messages theo rules bên trên
    public function messages()
    {
        return [
            'content.required' => 'Nội dung bắt buộc nhập',
            'content.min' => 'Nội dung tối thiểu 1 ký tự',
            'content.max' => 'Nội dung tối đa 500 ký tự', 
        ];
    }
}
