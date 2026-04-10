<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Danh sách khóa học (có tìm kiếm, lọc, sắp xếp, phân trang)
     * Dùng with() để tránh N+1 query
     */
    public function index(Request $request)
    {
        $query = Course::withCount(['lessons', 'enrollments'])
                       ->with(['lessons', 'enrollments']); // tránh N+1

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->searchByName($request->search);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->filterStatus($request->status);
        }

        // Lọc theo khoảng giá
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->priceBetween($request->price_min, $request->price_max);
        }

        // Sắp xếp
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $allowedSorts = ['price', 'created_at', 'name', 'enrollments_count'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir);
        }

        $courses = $query->paginate(5)->withQueryString();

        return view('courses.index', compact('courses'));
    }

    /**
     * Form tạo khóa học
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Lưu khóa học mới (dùng CourseRequest để validate)
     */
    public function store(CourseRequest $request)
    {
        $data = $request->validated();

        // Upload ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()->route('courses.index')
                         ->with('success', 'Khóa học đã được tạo thành công!');
    }

    /**
     * Chi tiết khóa học (tránh N+1 với eager loading)
     */
    public function show(Course $course)
    {
        $course->load(['lessons' => function ($q) {
            $q->orderBy('order');
        }, 'enrollments.student']);

        return view('courses.show', compact('course'));
    }

    /**
     * Form chỉnh sửa khóa học
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Cập nhật khóa học
     */
    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();

        // Upload ảnh mới (nếu có)
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('courses.index')
                         ->with('success', 'Khóa học đã được cập nhật!');
    }

    /**
     * Soft Delete khóa học
     */
    public function destroy(Course $course)
    {
        $course->delete(); // Soft Delete

        return redirect()->route('courses.index')
                         ->with('success', 'Khóa học đã được xóa (có thể khôi phục).');
    }

    /**
     * Danh sách khóa học đã xóa (trashed)
     */
    public function trashed()
    {
        $courses = Course::onlyTrashed()->paginate(10);

        return view('courses.trashed', compact('courses'));
    }

    /**
     * Khôi phục khóa học đã xóa
     */
    public function restore($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        return redirect()->route('courses.trashed')
                         ->with('success', 'Khóa học đã được khôi phục!');
    }

    /**
     * Xóa vĩnh viễn
     */
    public function forceDelete($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);

        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->forceDelete();

        return redirect()->route('courses.trashed')
                         ->with('success', 'Khóa học đã bị xóa vĩnh viễn!');
    }
}
