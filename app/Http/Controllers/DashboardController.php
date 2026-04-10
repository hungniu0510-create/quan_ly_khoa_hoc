<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    /**
     * Dashboard - thống kê tổng quan
     * Dùng eager loading và withCount để tối ưu query
     */
    public function index()
    {
        // Tổng số khóa học
        $totalCourses = Course::count();

        // Tổng số học viên
        $totalStudents = Student::count();

        // Tổng doanh thu (số enrollment * giá từng khóa)
        // Tối ưu: dùng join thay vì N+1
        $totalRevenue = Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
                                   ->sum('courses.price');

        // Khóa học có nhiều học viên nhất
        $topCourse = Course::withCount('enrollments')
                           ->orderBy('enrollments_count', 'desc')
                           ->first();

        // 5 khóa học mới nhất (eager loading tránh N+1)
        $recentCourses = Course::with(['lessons', 'enrollments'])
                               ->withCount(['lessons', 'enrollments'])
                               ->latest()
                               ->take(5)
                               ->get();

        // Thống kê doanh thu theo khóa học
        $revenueStats = Course::withCount('enrollments')
                              ->with('enrollments')
                              ->get()
                              ->map(function ($course) {
                                  return [
                                      'name'    => $course->name,
                                      'revenue' => $course->enrollments_count * $course->price,
                                      'students'=> $course->enrollments_count,
                                  ];
                              })
                              ->sortByDesc('revenue')
                              ->take(10);

        return view('dashboard', compact(
            'totalCourses',
            'totalStudents',
            'totalRevenue',
            'topCourse',
            'recentCourses',
            'revenueStats'
        ));
    }
}
