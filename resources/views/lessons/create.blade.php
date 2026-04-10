@extends('layouts.master')

@section('title', 'Thêm bài học')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Khóa học</a></li>
    <li class="breadcrumb-item"><a href="{{ route('courses.lessons.index', $course) }}">{{ Str::limit($course->name, 30) }}</a></li>
    <li class="breadcrumb-item active">Thêm bài học</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-plus-circle me-2 text-info"></i>
                    Thêm bài học vào: <span class="text-primary">{{ $course->name }}</span>
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('courses.lessons.store', $course) }}" method="POST">
                    @csrf
                    @include('lessons._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Lưu bài học
                        </button>
                        <a href="{{ route('courses.lessons.index', $course) }}" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
