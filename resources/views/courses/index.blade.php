@extends('layouts.master')

@section('title', 'Danh sách khóa học')

@section('breadcrumb')
    <li class="breadcrumb-item active">Khóa học</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-book me-2 text-primary"></i>Danh sách khóa học</h4>
    <a href="{{ route('courses.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Thêm khóa học
    </a>
</div>

{{-- BỘ LỌC & TÌM KIẾM --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('courses.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-medium">Tìm kiếm</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Tên khóa học..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-medium">Trạng thái</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Tất cả --</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-medium">Giá từ</label>
                <input type="number" name="price_min" class="form-control form-control-sm"
                       placeholder="0" value="{{ request('price_min') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-medium">Giá đến</label>
                <input type="number" name="price_max" class="form-control form-control-sm"
                       placeholder="999999" value="{{ request('price_max') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-medium">Sắp xếp theo</label>
                <select name="sort_by" class="form-select form-select-sm">
                    <option value="created_at"       {{ request('sort_by') === 'created_at'       ? 'selected' : '' }}>Ngày tạo</option>
                    <option value="price"            {{ request('sort_by') === 'price'            ? 'selected' : '' }}>Giá</option>
                    <option value="name"             {{ request('sort_by') === 'name'             ? 'selected' : '' }}>Tên</option>
                    <option value="enrollments_count"{{ request('sort_by') === 'enrollments_count'? 'selected' : '' }}>Số học viên</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small fw-medium">Thứ tự</label>
                <select name="sort_dir" class="form-select form-select-sm">
                    <option value="desc" {{ request('sort_dir') === 'desc' ? 'selected' : '' }}>↓ Giảm</option>
                    <option value="asc"  {{ request('sort_dir') === 'asc'  ? 'selected' : '' }}>↑ Tăng</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search"></i> Lọc
                </button>
                <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th width="60">Ảnh</th>
                    <th>Tên khóa học</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Bài học</th>
                    <th class="text-center">Học viên</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>
                        <img src="{{ $course->image_url }}" width="50" height="40"
                             class="rounded object-fit-cover" style="object-fit:cover" alt="">
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $course->name }}</div>
                        <div class="text-muted small">{{ $course->slug }}</div>
                    </td>
                    <td class="fw-medium text-primary">{{ number_format($course->price, 0, ',', '.') }}đ</td>
                    <td><x-badge-status :status="$course->status" /></td>
                    <td class="text-center">
                        <a href="{{ route('courses.lessons.index', $course) }}"
                           class="badge bg-info text-decoration-none">
                            {{ $course->lessons_count }}
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('enrollments.show', $course) }}"
                           class="badge bg-success text-decoration-none">
                            {{ $course->enrollments_count }}
                        </a>
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('courses.show', $course) }}"
                               class="btn btn-sm btn-outline-primary" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('courses.edit', $course) }}"
                               class="btn btn-sm btn-outline-warning" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('courses.destroy', $course) }}" method="POST"
                                  onsubmit="return confirm('Xóa khóa học này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Chưa có khóa học nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($courses->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Hiển thị {{ $courses->firstItem() }}–{{ $courses->lastItem() }} / {{ $courses->total() }} kết quả
        </small>
        {{ $courses->links() }}
    </div>
    @endif
</div>
@endsection
