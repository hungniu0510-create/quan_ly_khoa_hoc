@extends('layouts.master')

@section('title', 'Cập nhật bài học')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Khóa học</a></li>
    <li class="breadcrumb-item"><a href="{{ route('courses.lessons.index', $course) }}">{{ Str::limit($course->name, 30) }}</a></li>
    <li class="breadcrumb-item active">Cập nhật bài học</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>
                    Cập nhật: {{ $lesson->title }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('courses.lessons.update', [$course, $lesson]) }}" method="POST">
                    @csrf @method('PUT')
                    @include('lessons._form', ['lesson' => $lesson])
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i> Cập nhật
                        </button>
                        <a href="{{ route('courses.lessons.index', $course) }}" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
