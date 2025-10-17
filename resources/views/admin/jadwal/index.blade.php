@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Jadwal</h5>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Jadwal
        </a>
    </div>

    <div class="card-body">
        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

       
        </div>

        {{-- Tabel Jadwal --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Foto Guru</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $i => $jadwal)
                        <tr class="text-center">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $jadwal->nama_guru }}</td>
                            <td>{{ $jadwal->mapel }}</td>
                            <td>{{ ucfirst($jadwal->hari) }}</td>
                            <td>{{ $jadwal->jam_masuk }}</td>
                            <td>{{ $jadwal->jam_keluar }}</td>
                            <td>
                                @if($jadwal->foto_guru)
                                    <img src="{{ asset('storage/' . $jadwal->foto_guru) }}" 
                                         alt="Foto" width="60" height="60" 
                                         class="rounded shadow-sm object-fit-cover">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $jadwal->id }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Konfirmasi Hapus --}}
                        <div class="modal fade" id="deleteModal{{ $jadwal->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-3">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus jadwal <strong>{{ $jadwal->mapel }}</strong> milik <strong>{{ $jadwal->nama_guru }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada jadwal yang tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: #f9fafc;
    transition: background-color 0.2s ease-in-out;
}
.object-fit-cover {
    object-fit: cover;
}
</style>
@endsection
