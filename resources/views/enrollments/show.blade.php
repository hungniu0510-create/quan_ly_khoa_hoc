@extends('layouts.master')

@section('title', 'Học viên - ' . $course->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('enrollments.index') }}">Đăng ký học</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($course->name, 40) }}</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-bold mb-0">
            <i class="bi bi-people me-2 text-success"></i>
            Học viên: <span class="text-primary">{{ $course->name }}</span>
        </h4>
        <p class="text-muted mb-0">
            Tổng cộng: <strong class="text-success">{{ $totalStudents }}</strong> học viên đã đăng ký
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('enrollments.create') }}?course={{ $course->id }}"
           class="btn btn-success btn-sm">
            <i class="bi bi-person-plus"></i> Thêm học viên
        </a>
        <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên học viên</th>
                    <th>Email</th>
                    <th>Ngày đăng ký</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($course->enrollments as $i => $enrollment)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-medium">{{ $enrollment->student->name }}</td>
                    <td>{{ $enrollment->student->email }}</td>
                    <td>{{ $enrollment->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        <form action="{{ route('enrollments.destroy', $enrollment) }}"
                              method="POST"
                              onsubmit="return confirm('Hủy đăng ký của học viên này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-person-x"></i> Hủy đăng ký
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-people fs-3 d-block mb-2"></i>
                        Chưa có học viên nào đăng ký khóa học này
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
