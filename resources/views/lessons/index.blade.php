@extends('layouts.master')

@section('title', 'Bài học - ' . $course->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Khóa học</a></li>
    <li class="breadcrumb-item"><a href="{{ route('courses.show', $course) }}">{{ Str::limit($course->name, 30) }}</a></li>
    <li class="breadcrumb-item active">Bài học</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-journal-text me-2 text-info"></i>
        Bài học: <span class="text-primary">{{ $course->name }}</span>
    </h4>
    <a href="{{ route('courses.lessons.create', $course) }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Thêm bài học
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th width="70">Thứ tự</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Video</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lessons as $lesson)
                <tr>
                    <td>
                        <span class="badge bg-primary rounded-pill">{{ $lesson->order }}</span>
                    </td>
                    <td class="fw-medium">{{ $lesson->title }}</td>
                    <td class="text-muted small">{{ Str::limit($lesson->content, 60) }}</td>
                    <td>
                        @if($lesson->video_url)
                            <a href="{{ $lesson->video_url }}" target="_blank"
                               class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-play-circle"></i> Xem
                            </a>
                        @else
                            <span class="text-muted">—</span>
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
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-journals fs-3 d-block mb-2"></i>
                        Chưa có bài học nào.
                        <a href="{{ route('courses.lessons.create', $course) }}">Thêm ngay</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
