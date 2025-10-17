<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index(Request $request, $hari = null)
{
    // Jika route lewat parameter hari
    $hariParam = $request->route('hari');

    if ($hariParam) {
        $validHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        if (!in_array(strtolower($hariParam), $validHari)) {
            abort(404);
        }

        $jadwals = Jadwal::where('hari', strtolower($hariParam))
            ->orderBy('jam_masuk')
            ->get();
        $hariDipilih = ucfirst($hariParam);
    } else {
        // Kalau tidak pakai /hari/{hari} → tampilkan semua
        $jadwals = Jadwal::orderBy('hari')->orderBy('jam_masuk')->get();
        $hariDipilih = null;
    }

    return view('admin.jadwal.index', compact('jadwals', 'hariDipilih'));
}

    /**
     * Form tambah jadwal
     */
    public function create()
    {
        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        return view('admin.jadwal.create', compact('hariList'));
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|string',
            'nama_guru' => 'required|string|max:100',
            'pelajaran' => 'required|string|max:100',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'ruang' => 'nullable|string|max:50',
            'foto_guru' => 'nullable|image|max:2048',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto_guru')) {
            $validated['foto_guru'] = $request->file('foto_guru')->store('foto_guru', 'public');
        }

        Jadwal::create($validated);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail satu jadwal (opsional)
     */
    public function show($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    /**
     * Form edit jadwal
     */
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        return view('admin.jadwal.edit', compact('jadwal', 'hariList'));
    }

    /**
     * Update data jadwal
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $validated = $request->validate([
            'hari' => 'required|string',
            'nama_guru' => 'required|string|max:100',
            'pelajaran' => 'required|string|max:100',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'ruang' => 'nullable|string|max:50',
            'foto_guru' => 'nullable|image|max:2048',
        ]);

        // Jika ada foto baru, hapus yang lama
        if ($request->hasFile('foto_guru')) {
            if ($jadwal->foto_guru && Storage::disk('public')->exists($jadwal->foto_guru)) {
                Storage::disk('public')->delete($jadwal->foto_guru);
            }
            $validated['foto_guru'] = $request->file('foto_guru')->store('foto_guru', 'public');
        }

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Hapus jadwal
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        if ($jadwal->foto_guru && Storage::disk('public')->exists($jadwal->foto_guru)) {
            Storage::disk('public')->delete($jadwal->foto_guru);
        }

        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
