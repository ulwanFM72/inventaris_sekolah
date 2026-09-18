<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Inventaris Sekolah')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3 shadow-sm">
    <div class="d-flex align-items-center gap-2">
        {{-- Tombol menu, hanya tampil di layar kecil/menengah (di bawah breakpoint lg) --}}
        <button class="btn btn-outline-light btn-sm d-lg-none" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
            ☰
        </button>
        <span class="navbar-brand mb-0 h6 h-md-5 mb-0">🏫 <span class="d-none d-sm-inline">Admin - Inventaris Sekolah</span><span class="d-inline d-sm-none">Admin</span></span>
    </div>
    <div class="d-flex align-items-center gap-2 gap-md-3">
        <span class="text-white-50 small d-none d-md-inline">
            {{ auth()->user()->name ?? '' }}
        </span>
        <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
        </form>
    </div>
</nav>

<div class="d-flex">
    {{--
        offcanvas-lg: di bawah breakpoint lg (<992px, mencakup HP & tablet)
        elemen ini berperilaku sebagai offcanvas (tersembunyi, muncul lewat
        tombol ☰ di navbar). Pada layar lg ke atas (desktop/laptop), otomatis
        berubah jadi sidebar statis biasa yang selalu terlihat.
    --}}
    <aside class="admin-sidebar offcanvas-lg offcanvas-start bg-white border-end"
           tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel"
           style="width: 240px; min-height: calc(100vh - 56px);">
        <div class="offcanvas-header d-lg-none border-bottom">
            <h6 class="offcanvas-title mb-0" id="adminSidebarLabel">Menu Admin</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#adminSidebar" aria-label="Tutup"></button>
        </div>

        <div class="offcanvas-body p-3 d-flex flex-column">
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-dark' }}" href="{{ route('admin.dashboard') }}">
                        📊 Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.inventaris.index') ? 'active' : 'text-dark' }}" href="{{ route('admin.inventaris.index') }}">
                        📦 Data Inventaris
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.inventaris.create') ? 'active' : 'text-dark' }}" href="{{ route('admin.inventaris.create') }}">
                        ➕ Tambah Barang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.foto.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.foto.index') }}">
                        🖼️ Foto Barang
                    </a>
                </li>
                <li class="nav-item mt-3 border-top pt-2">
                    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="nav-link text-danger border-0 bg-transparent text-start w-100">
                            🚪 Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <div class="flex-grow-1 p-3 p-md-4 bg-light" style="min-height: calc(100vh - 56px); min-width: 0;">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
