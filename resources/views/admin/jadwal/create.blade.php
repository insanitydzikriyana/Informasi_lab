@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah Jadwal Baru</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.jadwal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Hari</label>
                    <select name="hari" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Hari --</option>
                        <option value="senin">Senin</option>
                        <option value="selasa">Selasa</option>
                        <option value="rabu">Rabu</option>
                        <option value="kamis">Kamis</option>
                        <option value="jumat">Jumat</option>
                        <option value="sabtu">Sabtu</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Guru</label>
                    <input type="text" name="nama_guru" class="form-control" placeholder="Masukkan nama guru" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Mata Pelajaran</label>
                    <input type="text" name="pelajaran" class="form-control" placeholder="Masukkan mata pelajaran" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Jam Keluar</label>
                    <input type="time" name="jam_keluar" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Foto Guru</label>
                <input type="file" name="foto_guru" class="form-control" accept="image/*">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
