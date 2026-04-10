@extends('layouts.master')

@section('title', 'Cập nhật khóa học')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Khóa học</a></li>
    <li class="breadcrumb-item active">Cập nhật</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Cập nhật: {{ $course->name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('courses._form', ['course' => $course])

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i> Cập nhật
                        </button>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
