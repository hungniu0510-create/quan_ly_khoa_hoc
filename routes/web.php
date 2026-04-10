<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// ==================== COURSES ====================
// ⚠️ Các route tĩnh phải đặt TRƯỚC Route::resource để tránh bị {course} nuốt mất

// Soft Delete routes
Route::get('courses/trashed', [CourseController::class, 'trashed'])->name('courses.trashed');
Route::patch('courses/{id}/restore', [CourseController::class, 'restore'])->name('courses.restore');
Route::delete('courses/{id}/force-delete', [CourseController::class, 'forceDelete'])->name('courses.force-delete');

// Resource (đặt SAU các route tĩnh)
Route::resource('courses', CourseController::class);

// ==================== LESSONS (nested resource) ====================
Route::resource('courses.lessons', LessonController::class)
     ->except(['show']);

// ==================== ENROLLMENTS ====================
Route::prefix('enrollments')->name('enrollments.')->group(function () {
    Route::get('/', [EnrollmentController::class, 'index'])->name('index');
    Route::get('/create', [EnrollmentController::class, 'create'])->name('create');
    Route::post('/', [EnrollmentController::class, 'store'])->name('store');
    Route::get('/course/{course}', [EnrollmentController::class, 'show'])->name('show');
    Route::delete('/{enrollment}', [EnrollmentController::class, 'destroy'])->name('destroy');
});