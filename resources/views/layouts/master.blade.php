<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Course Manager') - EduAdmin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; margin: 0; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            width: 260px;
            position: fixed;
            top: 0; left: 0;
            overflow-y: auto;
            z-index: 200;
        }
        .sidebar .brand {
            padding: 1.25rem 1rem;
            font-size: 1.15rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; gap: .5rem;
        }
        .sidebar-label {
            padding: .75rem 1rem .25rem;
            font-size: .65rem;
            color: rgba(255,255,255,.35);
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .nav-item-main {
            display: flex; align-items: center; justify-content: space-between;
            padding: .55rem 1rem;
            margin: 2px 8px;
            border-radius: 7px;
            color: rgba(255,255,255,.75);
            text-decoration: none;
            font-size: .9rem;
            transition: background .15s;
        }
        .nav-item-main:hover { background: rgba(255,255,255,1); color:#fff; }
        .nav-item-main.active { background: rgba(255,255,255,.15); color:#fff; }
        .nav-item-main .left { display:flex; align-items:center; gap:.55rem; }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .7rem 1.5rem;
            margin-left: 260px;
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
        }
        .main-content { margin-left: 260px; padding: 1.5rem; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ===== SIDEBAR ===== --}}
<div class="sidebar">
    <div class="brand">
        <i class="bi bi-mortarboard-fill text-info"></i> EduAdmin
    </div>

    <div class="sidebar-label">Tổng quan</div>
    <a href="{{ route('dashboard') }}"
       class="nav-item-main {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="left"><i class="bi bi-speedometer2"></i> Dashboard</span>
    </a>

    <div class="sidebar-label">Quản lý</div>

    {{-- Menu Khóa học rút gọn --}}
    <a href="{{ route('courses.index') }}"
       class="nav-item-main {{ request()->routeIs('courses.index') ? 'active' : '' }}">
        <span class="left"><i class="bi bi-book"></i> Khóa học</span>
    </a>

    <a href="{{ route('courses.create') }}"
       class="nav-item-main {{ request()->routeIs('courses.create') ? 'active' : '' }}">
        <span class="left"><i class="bi bi-plus-circle"></i> Thêm khóa học mới</span>
    </a>

    <a href="{{ route('courses.trashed') }}"
       class="nav-item-main {{ request()->routeIs('courses.trashed') ? 'active' : '' }}">
        <span class="left"><i class="bi bi-trash"></i> Thùng rác</span>
    </a>

    <div class="sidebar-label">Học viên</div>
    <a href="{{ route('enrollments.index') }}"
       class="nav-item-main {{ request()->routeIs('enrollments.index') ? 'active' : '' }}">
        <span class="left"><i class="bi bi-people-fill"></i> Đăng ký học</span>
    </a>
</div>

{{-- ===== TOPBAR ===== --}}
<div class="topbar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            @yield('breadcrumb')
        </ol>
    </nav>
    <span class="text-muted small">{{ now()->format('d/m/Y') }}</span>
</div>

{{-- ===== CONTENT ===== --}}
<div class="main-content">
    @include('components.alert')
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
