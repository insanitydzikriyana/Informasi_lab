@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark bi-person-workspace"> Daftar Guru Aktif</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">← Kembali ke Dashboard</a>
    </div>

    @if($daftarGuru->isEmpty())
        <div class="alert alert-info text-center shadow-sm">
            Belum ada data guru yang tersedia.
        </div>
    @else
        <div class="row g-4">
            @foreach($daftarGuru as $guru)
                <div class="col-md-4 col-lg-3">
                    <div class="card guru-card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body text-center p-4">
                            <div class="guru-photo mb-3">
                               @if($guru->foto_guru)
                                  <img src="{{ asset('storage/' . $guru->foto_guru) }}" 
                                       alt="{{ $guru->nama_guru }}" 
                                       class="rounded-circle" 
         style="width: 90px; height: 90px; object-fit: cover;">
@else
    <div class="placeholder-photo d-flex align-items-center justify-content-center bg-light text-secondary rounded-circle" 
         style="width: 90px; height: 90px; font-size: 30px;">
        <i class="bi bi-person-circle"></i>
    </div>
@endif

                            </div>
                            <h6 class="fw-semibold mb-1 text-dark">{{ $guru->nama_guru }}</h6>
                            <small class="text-muted">{{ $guru->mapel }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.guru-card {
    background: linear-gradient(145deg, #ffffff, #e7ebef);
    transition: all 0.3s ease;
}
.guru-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.guru-photo img, .placeholder-photo {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection
