@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">📘 Daftar Mata Pelajaran</h4>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="row">
        @forelse($daftarMapel as $mapel)
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg border-0 p-3 text-center mapel-card"
                     data-mapel="{{ $mapel->mapel }}"
                     style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #e6e6e6);
                            transition: all 0.3s ease; transform-style: preserve-3d; cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-journal-bookmark text-primary fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $mapel->mapel ?? 'Tidak diketahui' }}</h5>
                        <p class="mb-1 text-muted">
                            <strong>Guru:</strong> {{ $mapel->nama_guru ?? 'Belum diisi' }}
                        </p>
                        <p class="small text-secondary mb-0">
                            Klik untuk lihat detail jadwal
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada data mata pelajaran.</p>
        @endforelse
    </div>
</div>

<!-- Modal Detail Mapel -->
<div class="modal fade" id="mapelModal" tabindex="-1" aria-labelledby="mapelModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg rounded-4 border-0" style="overflow: hidden;">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="mapelModalLabel">Detail Mata Pelajaran</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="mapelDetailBody">
        <div class="text-center text-muted">Memuat data...</div>
      </div>
    </div>
  </div>
</div>

<style>
/* --- Efek 3D Kartu Mapel --- */
.mapel-card {
    border-radius: 18px;
    background: linear-gradient(145deg, #ffffff, #dfe3e6);
    box-shadow: 6px 6px 15px #c5c5c5, -6px -6px 15px #ffffff;
    transition: all 0.3s ease;
}
.mapel-card:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 10px 10px 20px rgba(0,0,0,0.2);
    background: linear-gradient(145deg, #f5f9ff, #e8ecf2);
}

/* --- Modal Table --- */
.table th {
    background-color: #0d6efd !important;
    color: #fff !important;
    text-align: center;
}
.table td {
    vertical-align: middle;
    text-align: center;
}
.modal-body img {
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: transform 0.3s;
}
.modal-body img:hover {
    transform: scale(1.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapelCards = document.querySelectorAll('.mapel-card');
    const modal = new bootstrap.Modal(document.getElementById('mapelModal'));
    const modalBody = document.getElementById('mapelDetailBody');
    const modalTitle = document.getElementById('mapelModalLabel');

    mapelCards.forEach(card => {
        card.addEventListener('click', async () => {
            const mapel = card.dataset.mapel;
            modalTitle.textContent = `Detail Mata Pelajaran: ${mapel}`;
            modalBody.innerHTML = `<div class="text-center text-muted">Memuat data...</div>`;
            modal.show();

            try {
                const response = await fetch(`/admin/mapel/${encodeURIComponent(mapel)}`);
                const data = await response.json();

                if (!data || data.length === 0) {
                    modalBody.innerHTML = `<p class="text-center text-danger">Tidak ada data jadwal untuk mapel ini.</p>`;
                    return;
                }

                // Ambil foto guru pertama kalau ada
                const foto = data[0].foto_guru 
                    ? `/storage/${data[0].foto_guru}` 
                    : 'https://via.placeholder.com/120x120?text=No+Photo';

                let html = `
                    <div class="text-center mb-4">
                        <img src="${foto}" alt="Foto Guru" width="120" height="120">
                        <h5 class="mt-3 fw-bold">${mapel}</h5>
                        <p class="text-muted mb-0">${data[0].nama_guru ?? 'Guru tidak diketahui'}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle rounded-3 overflow-hidden">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Ruang</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.hari ? item.hari.charAt(0).toUpperCase() + item.hari.slice(1) : '-'}</td>
                            <td>${item.jam_masuk ?? '-'}</td>
                            <td>${item.jam_keluar ?? '-'}</td>
                            <td>${item.ruang ?? '-'}</td>
                        </tr>
                    `;
                });

                html += `</tbody></table></div>`;
                modalBody.innerHTML = html;

            } catch (error) {
                modalBody.innerHTML = `<p class="text-danger text-center">Gagal memuat data.</p>`;
            }
        });
    });
});
</script>
@endsection
