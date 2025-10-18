<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    // ✅ Tampilkan semua jadwal
    public function index($hari = null)
    {
        $query = Jadwal::query();
        if ($hari) {
            $query->where('hari', strtolower($hari));
        }

        $jadwals = $query->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    // ✅ CRUD
    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'nama_guru' => 'required',
            'pelajaran' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
        ]);

        Jadwal::create($request->all());
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    // ✅ Daftar mapel (untuk halaman utama mapel.blade.php)
    public function daftarMapel()
    {
        $daftarMapel = Jadwal::select('pelajaran as mapel', 'nama_guru', 'hari', 'jam_masuk', 'jam_keluar')
            ->distinct('pelajaran')
            ->orderBy('pelajaran', 'asc')
            ->get();

        return view('admin.mapel', compact('daftarMapel'));
    }

    // ✅ Detail mapel (AJAX)
    public function getMapelDetail($pelajaran)
    {
        $detailMapel = Jadwal::where('pelajaran', $pelajaran)
            ->select('nama_guru', 'hari', 'jam_masuk', 'jam_keluar', 'foto_guru')
            ->get();

        if ($detailMapel->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data untuk mapel ini.'], 404);
        }

        return response()->json($detailMapel);
    }
}
