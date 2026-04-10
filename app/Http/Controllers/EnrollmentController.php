<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;
use App\Http\Requests\EnrollmentRequest;

class EnrollmentController extends Controller
{
    /**
     * Form đăng ký khóa học
     */
    public function create()
    {
        // Chỉ lấy khóa học đã published (dùng scope)
        $courses = Course::published()->orderBy('name')->get();

        return view('enrollments.create', compact('courses'));
    }

    /**
     * Xử lý đăng ký khóa học
     * - Tìm hoặc tạo Student theo email
     * - Kiểm tra trùng enrollment
     */
    public function store(EnrollmentRequest $request)
    {
        $data = $request->validated();

        // Tìm hoặc tạo student theo email
        $student = Student::firstOrCreate(
            ['email' => $data['student_email']],
            ['name'  => $data['student_name']]
        );

        // Kiểm tra đã đăng ký chưa
        $exists = Enrollment::where('course_id', $data['course_id'])
                             ->where('student_id', $student->id)
                             ->exists();

        if ($exists) {
            return redirect()->back()
                             ->with('error', 'Học viên đã đăng ký khóa học này rồi!');
        }

        Enrollment::create([
            'course_id'  => $data['course_id'],
            'student_id' => $student->id,
        ]);

        return redirect()->route('enrollments.index')
                         ->with('success', 'Đăng ký khóa học thành công!');
    }

    /**
     * Danh sách tất cả enrollments (theo từng khóa học)
     * Eager loading tránh N+1
     */
    public function index()
    {
        // withCount để hiển thị tổng số học viên mỗi khóa
        $courses = Course::withCount('enrollments')
                         ->with(['enrollments.student'])
                         ->orderBy('enrollments_count', 'desc')
                         ->paginate(10);

        return view('enrollments.index', compact('courses'));
    }

    /**
     * Danh sách học viên của một khóa học cụ thể
     */
    public function show(Course $course)
    {
        $course->load('enrollments.student');
        $totalStudents = $course->enrollments()->count();

        return view('enrollments.show', compact('course', 'totalStudents'));
    }

    /**
     * Xóa enrollment
     */
    public function destroy(Enrollment $enrollment)
    {
        $courseId = $enrollment->course_id;
        $enrollment->delete();

        return redirect()->route('enrollments.show', $courseId)
                         ->with('success', 'Đã hủy đăng ký!');
    }
}
