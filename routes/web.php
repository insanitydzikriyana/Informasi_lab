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

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $totalJadwal = Jadwal::count();
        $totalHari = Jadwal::distinct('hari')->count('hari');

        $totalGuru = Schema::hasColumn('jadwals', 'nama_guru')
            ? Jadwal::distinct('nama_guru')->count('nama_guru')
            : (Schema::hasColumn('jadwals', 'guru') ? Jadwal::distinct('guru')->count('guru') : 0);

        // ✅ FIX: gunakan kolom 'pelajaran' bukan 'mapel'
        $totalMapel = Schema::hasColumn('jadwals', 'pelajaran')
            ? Jadwal::distinct('pelajaran')->count('pelajaran')
            : 0;

        return view('admin.dashboard', compact('totalJadwal', 'totalGuru', 'totalHari', 'totalMapel'));
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | DAFTAR GURU
    |--------------------------------------------------------------------------
    */
    Route::get('/guru', function () {
        if (Schema::hasColumn('jadwals', 'nama_guru')) {
            $daftarGuru = Jadwal::select('nama_guru', 'pelajaran as mapel', 'foto_guru', 'hari')
                ->distinct('nama_guru')
                ->get();
        } elseif (Schema::hasColumn('jadwals', 'guru')) {
            $daftarGuru = Jadwal::select('guru as nama_guru', 'pelajaran as mapel', 'foto_guru', 'hari')
                ->distinct('guru')
                ->get();
        } else {
            $daftarGuru = collect();
        }

        return view('admin.guru', compact('daftarGuru'));
    })->name('guru');

    /*
    |--------------------------------------------------------------------------
    | DAFTAR MATA PELAJARAN
    |--------------------------------------------------------------------------
    */
    Route::get('/mapel', function () {
        // ✅ Ambil data dari kolom 'pelajaran'
        $daftarMapel = Jadwal::select('pelajaran as mapel', 'nama_guru', 'hari', 'jam_masuk', 'jam_keluar')
            ->distinct('pelajaran')
            ->orderBy('pelajaran', 'asc')
            ->get();

        return view('admin.mapel', compact('daftarMapel'));
    })->name('mapel');

    // Detail mapel untuk modal (AJAX)
    Route::get('/mapel/{mapel}', function ($mapel) {
        $detailMapel = Jadwal::where('pelajaran', $mapel)
            ->select('nama_guru', 'hari', 'jam_masuk', 'jam_keluar', 'ruang', 'foto_guru')
            ->get();
        return response()->json($detailMapel);
    })->name('mapel.detail');

    /*
    |--------------------------------------------------------------------------
    | JADWAL (INDEX & CRUD)
    |--------------------------------------------------------------------------
    */
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index'); // semua jadwal
    Route::get('/jadwal/hari/{hari}', [JadwalController::class, 'index'])->name('jadwal.hari'); // filter per hari

    // CRUD
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
});
