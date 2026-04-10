<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'status'      => 'required|in:draft,published',
            'image'       => $this->isMethod('POST')
                                ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                                : 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Tên khóa học là bắt buộc.',
            'name.max'         => 'Tên khóa học không vượt quá 255 ký tự.',
            'price.required'   => 'Giá khóa học là bắt buộc.',
            'price.numeric'    => 'Giá phải là số.',
            'price.min'        => 'Giá phải lớn hơn 0.',
            'status.required'  => 'Trạng thái là bắt buộc.',
            'status.in'        => 'Trạng thái phải là draft hoặc published.',
            'image.image'      => 'File phải là ảnh.',
            'image.mimes'      => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'image.max'        => 'Kích thước ảnh không vượt quá 2MB.',
        ];
    }
}
