<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Http\Requests\LessonRequest;

class LessonController extends Controller
{
    /**
     * Danh sách bài học theo khóa học (sắp xếp theo order)
     * Eager loading để tránh N+1
     */
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('order')->get();

        return view('lessons.index', compact('course', 'lessons'));
    }

    /**
     * Form thêm bài học vào khóa học
     */
    public function create(Course $course)
    {
        return view('lessons.create', compact('course'));
    }

    /**
     * Lưu bài học mới
     */
    public function store(LessonRequest $request, Course $course)
    {
        $course->lessons()->create($request->validated());

        return redirect()->route('courses.lessons.index', $course)
                         ->with('success', 'Bài học đã được thêm thành công!');
    }

    /**
     * Form chỉnh sửa bài học
     */
    public function edit(Course $course, Lesson $lesson)
    {
        return view('lessons.edit', compact('course', 'lesson'));
    }

    /**
     * Cập nhật bài học
     */
    public function update(LessonRequest $request, Course $course, Lesson $lesson)
    {
        $lesson->update($request->validated());

        return redirect()->route('courses.lessons.index', $course)
                         ->with('success', 'Bài học đã được cập nhật!');
    }

    /**
     * Xóa bài học (Soft Delete)
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('courses.lessons.index', $course)
                         ->with('success', 'Bài học đã được xóa!');
    }
}
