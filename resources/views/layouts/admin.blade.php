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

<div class="d-flex">
    <aside class="admin-sidebar bg-white border-end p-3" style="width: 240px; min-height: calc(100vh - 56px);">
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
    </aside>

    <div class="flex-grow-1 p-4 bg-light" style="min-height: calc(100vh - 56px);">
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
