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
                     style="border-radius: 15px; background: linear-gradient(145deg, #ffffff, #e6e6e6);
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
    <div class="modal-content shadow-lg rounded-4 border-0">
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
.card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
}
.mapel-card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    background: linear-gradient(145deg, #f9fafb, #e6e6e6);
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
                const response = await fetch(`/admin/mapel/${mapel}`);
                const data = await response.json();

                if (data.length === 0) {
                    modalBody.innerHTML = `<p class="text-center text-danger">Tidak ada data jadwal untuk mapel ini.</p>`;
                    return;
                }

                let html = `
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Guru</th>
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
                            <td>${item.nama_guru ?? '-'}</td>
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
