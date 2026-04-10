@extends('layouts.master')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</h4>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-book fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Tổng khóa học</div>
                    <div class="fs-3 fw-bold">{{ $totalCourses }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-people fs-4 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Tổng học viên</div>
                    <div class="fs-3 fw-bold">{{ $totalStudents }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-cash-stack fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Tổng doanh thu</div>
                    <div class="fs-3 fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-trophy fs-4 text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Khóa học nổi bật</div>
                    <div class="fw-bold text-truncate" style="max-width:130px">
                        {{ $topCourse?->name ?? '—' }}
                    </div>
                    <div class="small text-muted">{{ $topCourse?->enrollments_count ?? 0 }} học viên</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- 5 khóa học mới nhất --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold border-0 pt-3">
                <i class="bi bi-clock-history me-2 text-primary"></i>5 Khóa học mới nhất
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tên khóa học</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Học viên</th>
                            <th>Bài học</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCourses as $course)
                        <tr>
                            <td>
                                <a href="{{ route('courses.show', $course) }}" class="text-decoration-none fw-medium">
                                    {{ $course->name }}
                                </a>
                            </td>
                            <td>{{ number_format($course->price, 0, ',', '.') }}đ</td>
                            <td><x-badge-status :status="$course->status" /></td>
                            <td>{{ $course->enrollments_count }}</td>
                            <td>{{ $course->lessons_count }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Chưa có khóa học nào</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Thống kê doanh thu --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold border-0 pt-3">
                <i class="bi bi-bar-chart me-2 text-success"></i>Doanh thu theo khóa học
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Khóa học</th>
                            <th>HV</th>
                            <th class="text-end">Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($revenueStats as $stat)
                        <tr>
                            <td class="text-truncate" style="max-width:140px">{{ $stat['name'] }}</td>
                            <td>{{ $stat['students'] }}</td>
                            <td class="text-end fw-medium text-success">{{ number_format($stat['revenue'], 0, ',', '.') }}đ</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Chưa có dữ liệu</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
