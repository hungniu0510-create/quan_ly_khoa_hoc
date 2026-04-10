@extends('layouts.master')

@section('title', 'Đăng ký khóa học')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('enrollments.index') }}">Đăng ký học</a></li>
    <li class="breadcrumb-item active">Đăng ký mới</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-person-plus me-2 text-success"></i>Đăng ký khóa học mới
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('enrollments.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-medium">Khóa học <span class="text-danger">*</span></label>
                        <select name="course_id"
                                class="form-select @error('course_id') is-invalid @enderror">
                            <option value="">-- Chọn khóa học --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }} — {{ number_format($course->price, 0, ',', '.') }}đ
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Tên học viên <span class="text-danger">*</span></label>
                        <input type="text" name="student_name"
                               class="form-control @error('student_name') is-invalid @enderror"
                               value="{{ old('student_name') }}"
                               placeholder="Nguyễn Văn A">
                        @error('student_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Email <span class="text-danger">*</span></label>
                        <input type="email" name="student_email"
                               class="form-control @error('student_email') is-invalid @enderror"
                               value="{{ old('student_email') }}"
                               placeholder="email@example.com">
                        @error('student_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nếu email đã tồn tại, thông tin học viên cũ sẽ được giữ nguyên.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg me-1"></i> Xác nhận đăng ký
                        </button>
                        <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
