@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Edit Jadwal</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Hari</label>
                    <select name="hari" class="form-select" required>
                        <option value="" disabled>Pilih Hari</option>
                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>
                                {{ ucfirst($hari) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Guru</label>
                    <input type="text" name="nama_guru" 
                           value="{{ old('nama_guru', $jadwal->nama_guru) }}" 
                           class="form-control" placeholder="Masukkan nama guru" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Mata Pelajaran</label>
                    <input type="text" name="mapel" 
                           value="{{ old('mapel', $jadwal->mapel) }}" 
                           class="form-control" placeholder="Masukkan mata pelajaran" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Jam Masuk</label>
                    <input type="time" name="jam_masuk" 
                           value="{{ old('jam_masuk', $jadwal->jam_masuk) }}" 
                           class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Jam Keluar</label>
                    <input type="time" name="jam_keluar" 
                           value="{{ old('jam_keluar', $jadwal->jam_keluar) }}" 
                           class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Foto Guru</label>
                <input type="file" name="foto_guru" class="form-control" accept="image/*">

                @if($jadwal->foto_guru)
                    <div class="mt-3">
                        <p class="small text-muted mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $jadwal->foto_guru) }}" 
                             alt="Foto Guru" width="100" 
                             class="rounded shadow-sm border">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.jadwal.hari', $jadwal->hari) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
