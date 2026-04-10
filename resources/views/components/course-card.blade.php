{{-- Component: Card hiển thị khóa học --}}
@props(['course'])

<div class="card h-100 shadow-sm border-0">
    <img src="{{ $course->image_url }}"
         class="card-img-top"
         alt="{{ $course->name }}"
         style="height:160px;object-fit:cover;">
    <div class="card-body">
        <x-badge-status :status="$course->status" />
        <h6 class="card-title mt-2 fw-semibold">{{ $course->name }}</h6>
        <p class="text-muted small mb-2">{{ Str::limit($course->description, 80) }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold text-primary">{{ number_format($course->price, 0, ',', '.') }}đ</span>
            <span class="text-muted small">
                <i class="bi bi-journal-text"></i> {{ $course->lessons_count ?? $course->lessons->count() }} bài
            </span>
        </div>
    </div>
    <div class="card-footer bg-transparent d-flex gap-2">
        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary flex-fill">
            <i class="bi bi-eye"></i> Xem
        </a>
        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-warning flex-fill">
            <i class="bi bi-pencil"></i> Sửa
        </a>
    </div>
</div>
