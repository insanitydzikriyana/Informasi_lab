<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Jadwal Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
</head>

<body>
  <!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4 bi-nut">Admin Jadwal</h4>
    <hr>

    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
    <a href="{{ route('admin.guru') }}"><i class="bi bi-person-badge"></i> Daftar Guru</a>
    <a href="{{ route('admin.mapel') }}"><i class="bi bi-journal-bookmark"></i> Daftar Mapel</a>

    <!-- Tombol collapse untuk Kelola Jadwal -->
    <a class="d-flex justify-content-between align-items-center" 
       data-bs-toggle="collapse" 
       href="#jadwalSubmenu" 
       role="button" 
       aria-expanded="false" 
       aria-controls="jadwalSubmenu">
        <span><i class="bi bi-calendar3"></i> Kelola Jadwal</span>
        <i class="bi bi-caret-down-fill small"></i>
    </a>

    <!-- Submenu Hari -->
    <div class="collapse ps-4 mt-1" id="jadwalSubmenu">
        <a href="{{ route('admin.jadwal.hari', 'senin') }}"><i class="bi bi-calendar-week"></i> Senin</a>
        <a href="{{ route('admin.jadwal.hari', 'selasa') }}"><i class="bi bi-calendar-week"></i> Selasa</a>
        <a href="{{ route('admin.jadwal.hari', 'rabu') }}"><i class="bi bi-calendar-week"></i> Rabu</a>
        <a href="{{ route('admin.jadwal.hari', 'kamis') }}"><i class="bi bi-calendar-week"></i> Kamis</a>
        <a href="{{ route('admin.jadwal.hari', 'jumat') }}"><i class="bi bi-calendar-week"></i> Jumat</a>
        <a href="{{ route('admin.jadwal.hari', 'sabtu') }}"><i class="bi bi-calendar-week"></i> Sabtu</a>
    </div>

    <hr>
</div>


    <!-- Navbar -->
    <nav class="navbar navbar-light px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-primary btn-sm d-md-none toggle-sidebar">
                <i class="bi bi-list"></i>
            </button>
            <span class="fw-semibold fs-5 text-primary">Panel Admin</span>
        </div>
        <button class="btn btn-outline-primary btn-sm">Logout</button>
    </nav>

    <!-- Main content -->
    <div class="main-content">
        @yield('content')
    </div>

       <!-- Footer -->
    <footer>
        <span>📘 Sistem Jadwal Pelajaran - <strong>Insanity Dzikriyana</strong> © {{ date('Y') }}</span>
    </footer>

    <!-- Bootstrap JS (Wajib untuk modal, dropdown, dan alert) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script tambahan -->
    <script>
        // Sidebar toggle untuk mobile
        document.querySelector('.toggle-sidebar')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Auto-close alert sukses setelah 3 detik
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);
    </script>
</body>
</html>
