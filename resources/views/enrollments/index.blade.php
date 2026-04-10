@extends('layouts.master')

@section('title', 'Quản lý đăng ký học')

@section('breadcrumb')
    <li class="breadcrumb-item active">Đăng ký học</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-success"></i>Quản lý đăng ký học</h4>
    <a href="{{ route('enrollments.create') }}" class="btn btn-success">
        <i class="bi bi-person-plus"></i> Đăng ký mới
    </a>
</div>

@forelse($courses as $course)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 pt-3 pb-2">
        <div>
            <h6 class="fw-bold mb-0">
                <a href="{{ route('courses.show', $course) }}" class="text-decoration-none">
                    {{ $course->name }}
                </a>
            </h6>
            <small class="text-muted">{{ number_format($course->price, 0, ',', '.') }}đ / học viên</small>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-success fs-6">
                {{ $course->enrollments_count }} học viên
            </span>
            <a href="{{ route('enrollments.show', $course) }}" class="btn btn-sm btn-outline-primary">
                Xem chi tiết
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0 table-sm">
            <thead class="table-light">
                <tr>
                    <th>Tên học viên</th>
                    <th>Email</th>
                    <th>Ngày đăng ký</th>
                    <th class="text-center">Xóa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($course->enrollments->take(3) as $enrollment)
                <tr>
                    <td>{{ $enrollment->student->name }}</td>
                    <td>{{ $enrollment->student->email }}</td>
                    <td>{{ $enrollment->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <form action="{{ route('enrollments.destroy', $enrollment) }}"
                              method="POST"
                              onsubmit="return confirm('Hủy đăng ký này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-x"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-2">Chưa có học viên</td>
                </tr>
                @endforelse

                @if($course->enrollments->count() > 3)
                <tr>
                    <td colspan="4" class="text-center py-2">
                        <a href="{{ route('enrollments.show', $course) }}" class="text-muted small">
                            + {{ $course->enrollments->count() - 3 }} học viên khác...
                        </a>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="text-center py-5 text-muted">
    <i class="bi bi-people fs-1 d-block mb-3"></i>
    Chưa có dữ liệu đăng ký học
</div>
@endforelse

{{ $courses->links() }}
@endsection
