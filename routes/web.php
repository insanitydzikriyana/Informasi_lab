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

    // DASHBOARD
    Route::get('/dashboard', function () {
        $totalJadwal = Jadwal::count();
        $totalHari = Jadwal::distinct('hari')->count('hari');

        $totalGuru = Schema::hasColumn('jadwals', 'nama_guru')
            ? Jadwal::distinct('nama_guru')->count('nama_guru')
            : (Schema::hasColumn('jadwals', 'guru') ? Jadwal::distinct('guru')->count('guru') : 0);

        $totalMapel = Schema::hasColumn('jadwals', 'mapel')
            ? Jadwal::distinct('mapel')->count('mapel')
            : 0;

        return view('admin.dashboard', compact('totalJadwal', 'totalGuru', 'totalHari', 'totalMapel'));
    })->name('dashboard');

    // DAFTAR GURU
    Route::get('/guru', function () {
        if (Schema::hasColumn('jadwals', 'nama_guru')) {
            $daftarGuru = Jadwal::select('nama_guru', 'mapel', 'foto_guru', 'hari')->distinct('nama_guru')->get();
        } elseif (Schema::hasColumn('jadwals', 'guru')) {
            $daftarGuru = Jadwal::select('guru as nama_guru', 'mapel', 'foto_guru', 'hari')->distinct('guru')->get();
        } else {
            $daftarGuru = collect();
        }

        return view('admin.guru', compact('daftarGuru'));
    })->name('guru');

    // DAFTAR MAPEL
    Route::get('/mapel', function () {
        $daftarMapel = Jadwal::select('mapel', 'nama_guru', 'hari', 'jam_masuk', 'jam_keluar')
            ->distinct('mapel')
            ->orderBy('mapel', 'asc')
            ->get();

        return view('admin.mapel', compact('daftarMapel'));
    })->name('mapel');

    Route::get('/mapel/{mapel}', function ($mapel) {
        $detailMapel = Jadwal::where('mapel', $mapel)
            ->select('nama_guru', 'hari', 'jam_masuk', 'jam_keluar', 'ruang', 'foto_guru')
            ->get();
        return response()->json($detailMapel);
    })->name('mapel.detail');

    /*
    |--------------------------------------------------------------------------
    | FILTER JADWAL PER HARI (HARUS DI ATAS RESOURCE!)
    |--------------------------------------------------------------------------
    */
    Route::get('/jadwal/hari/{hari}', function ($hari) {
        $hari = strtolower($hari);
        $jadwalHari = Jadwal::where('hari', $hari)->get();
        return view('admin.jadwal.perhari', compact('hari', 'jadwalHari'));
    })->name('jadwal.hari');

    /*
    |--------------------------------------------------------------------------
    | CRUD JADWAL
    |--------------------------------------------------------------------------
    */
    Route::resource('jadwal', JadwalController::class);
});
