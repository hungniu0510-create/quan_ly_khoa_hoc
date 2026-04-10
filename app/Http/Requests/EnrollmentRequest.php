<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id'     => 'required|exists:courses,id',
            'student_name'  => 'required|string|max:255',
            'student_email' => 'required|email|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.required'     => 'Vui lòng chọn khóa học.',
            'course_id.exists'       => 'Khóa học không tồn tại.',
            'student_name.required'  => 'Tên học viên là bắt buộc.',
            'student_email.required' => 'Email học viên là bắt buộc.',
            'student_email.email'    => 'Email không hợp lệ.',
        ];
    }
}
