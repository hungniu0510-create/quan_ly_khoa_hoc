<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'order'     => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Tiêu đề bài học là bắt buộc.',
            'video_url.url'   => 'Video URL phải là đường dẫn hợp lệ.',
            'order.required'  => 'Thứ tự bài học là bắt buộc.',
            'order.integer'   => 'Thứ tự phải là số nguyên.',
            'order.min'       => 'Thứ tự phải lớn hơn hoặc bằng 1.',
        ];
    }
}
