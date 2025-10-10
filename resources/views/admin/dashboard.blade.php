@extends('layouts.admin')

@section('content')
<div class="row">
    <!-- Total Jadwal -->
    <div class="col-md-4">
        <div class="dashboard-card text-center hover-dashboard"
             onclick="window.location.href='{{ route('admin.jadwal.index') }}'">
            <i class="bi bi-calendar-week fs-1 text-primary mb-3"></i>
            <h5 class="fw-semibold">Total Jadwal</h5>
            <p class="fs-4 fw-bold text-dark">{{ $totalJadwal ?? 0 }}</p>
            <small class="text-white-50">Klik untuk lihat semua jadwal</small>
        </div>
    </div>

    <!-- Total Guru -->
    <div class="col-md-4">
        <div class="dashboard-card text-center hover-dashboard"
             onclick="window.location.href='{{ route('admin.guru') }}'">
            <i class="bi bi-person-workspace fs-1 text-warning mb-3"></i>
            <h5 class="fw-semibold">Guru Aktif</h5>
            <p class="fs-4 fw-bold text-dark">{{ $totalGuru ?? 0 }}</p>
            <small class="text-white-50">Klik untuk lihat daftar guru</small>
        </div>
    </div>

   <!-- Total Hari -->
<div class="col-md-4">
    <div class="dashboard-card text-center hover-dashboard"
         onclick="window.location.href='{{ route('admin.mapel') }}'">
        <i class="bi bi-book fs-1 text-success mb-3"></i>
        <h5 class="fw-semibold">Mata Pelajaran</h5>
        <p class="fs-4 fw-bold text-dark">{{ $totalMapel ?? 0 }}</p>
        <small class="text-white-50">Klik untuk lihat daftar mapel</small>
    </div>
</div>

<style>
.hover-dashboard {
    transition: all 0.3s ease;
    cursor: pointer;
}
.hover-dashboard:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
}
</style>
@endsection
