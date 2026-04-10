@extends('layouts.master')

@section('title', $course->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Khóa học</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($course->name, 40) }}</li>
@endsection

@section('content')
<div class="row g-4">
    {{-- Info --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <img src="{{ $course->image_url }}" class="card-img-top" style="height:200px;object-fit:cover" alt="">
            <div class="card-body">
                <x-badge-status :status="$course->status" />
                <h5 class="fw-bold mt-2">{{ $course->name }}</h5>
                <p class="text-muted">{{ $course->description }}</p>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Giá</span>
                    <strong class="text-primary">{{ number_format($course->price, 0, ',', '.') }}đ</strong>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span class="text-muted">Slug</span>
                    <code>{{ $course->slug }}</code>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span class="text-muted">Bài học</span>
                    <strong>{{ $course->lessons->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span class="text-muted">Học viên</span>
                    <strong>{{ $course->enrollments->count() }}</strong>
                </div>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning btn-sm flex-fill">
                    <i class="bi bi-pencil"></i> Chỉnh sửa
                </a>
                <form action="{{ route('courses.destroy', $course) }}" method="POST"
                      onsubmit="return confirm('Xóa khóa học này?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>

    {{-- Lessons --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 pt-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-journal-text me-2 text-info"></i>Danh sách bài học</h6>
                <a href="{{ route('courses.lessons.create', $course) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus"></i> Thêm bài học
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Tiêu đề</th>
                            <th>Video</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($course->lessons as $lesson)
                        <tr>
                            <td><span class="badge bg-light text-dark">{{ $lesson->order }}</span></td>
                            <td>{{ $lesson->title }}</td>
                            <td>
                                @if($lesson->video_url)
                                    <a href="{{ $lesson->video_url }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-play-circle"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Xóa bài học này?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Chưa có bài học nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Enrollments --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-people me-2 text-success"></i>
                    Học viên đã đăng ký ({{ $course->enrollments->count() }})
                </h6>
                <a href="{{ route('enrollments.show', $course) }}" class="btn btn-sm btn-outline-success">
                    Xem tất cả
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Tên</th><th>Email</th><th>Ngày đăng ký</th></tr>
                    </thead>
                    <tbody>
                        @forelse($course->enrollments->take(5) as $enrollment)
                        <tr>
                            <td>{{ $enrollment->student->name }}</td>
                            <td>{{ $enrollment->student->email }}</td>
                            <td>{{ $enrollment->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">Chưa có học viên</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
