<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\JadwalController;
use App\Models\Jadwal;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $hariList = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
    $hari = $hariList[now()->dayOfWeek];

    $jadwal_semua = Jadwal::where('hari', $hari)->get();
    $jadwal_hari_ini = $jadwal_semua->first();

    return view('index', compact('hari', 'jadwal_semua', 'jadwal_hari_ini'));
})->name('home');

/*
|--------------------------------------------------------------------------
| GRUP ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ✅ DASHBOARD
    Route::get('/dashboard', function () {
        $totalJadwal = Jadwal::count();
        $totalHari = Jadwal::distinct('hari')->count('hari');
        $totalGuru = Schema::hasColumn('jadwals', 'nama_guru')
            ? Jadwal::distinct('nama_guru')->count('nama_guru')
            : 0;
        $totalMapel = Jadwal::distinct('pelajaran')->count('pelajaran');

        return view('admin.dashboard', compact('totalJadwal', 'totalGuru', 'totalHari', 'totalMapel'));
    })->name('dashboard');

    // ✅ GURU
    Route::get('/guru', function () {
        $daftarGuru = Jadwal::select('nama_guru', 'pelajaran as mapel', 'foto_guru', 'hari')
            ->distinct('nama_guru')
            ->get();
        return view('admin.guru', compact('daftarGuru'));
    })->name('guru');

    // ✅ MAPEL (DAFTAR)
    Route::get('/mapel', [JadwalController::class, 'daftarMapel'])->name('mapel');

    // ✅ MAPEL (DETAIL AJAX)
    Route::get('/mapel/{pelajaran}', [JadwalController::class, 'getMapelDetail'])
        ->where('pelajaran', '.*')
        ->name('mapel.detail');

    // ✅ JADWAL (INDEX & CRUD)
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/hari/{hari}', [JadwalController::class, 'index'])->name('jadwal.hari');

    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
});
