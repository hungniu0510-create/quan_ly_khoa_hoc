@extends('layouts.master')

@section('title', 'Khóa học đã xóa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Khóa học</a></li>
    <li class="breadcrumb-item active">Đã xóa</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-trash me-2 text-danger"></i>Khóa học đã xóa</h4>
    <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Quay lại
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tên khóa học</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Ngày xóa</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr class="text-muted">
                    <td>
                        <span class="fw-medium">{{ $course->name }}</span><br>
                        <small>{{ $course->slug }}</small>
                    </td>
                    <td>{{ number_format($course->price, 0, ',', '.') }}đ</td>
                    <td><x-badge-status :status="$course->status" /></td>
                    <td>{{ $course->deleted_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        {{-- Khôi phục --}}
                        <form action="{{ route('courses.restore', $course->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-success" title="Khôi phục">
                                <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                            </button>
                        </form>
                        {{-- Xóa vĩnh viễn --}}
                        <form action="{{ route('courses.force-delete', $course->id) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Xóa VĨNH VIỄN? Không thể hoàn tác!')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Xóa vĩnh viễn">
                                <i class="bi bi-x-circle"></i> Xóa vĩnh viễn
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-check-circle fs-3 d-block mb-2 text-success"></i>
                        Không có khóa học nào trong thùng rác
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($courses->hasPages())
    <div class="card-footer bg-white">
        {{ $courses->links() }}
    </div>
    @endif
</div>
@endsection
