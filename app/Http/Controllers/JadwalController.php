<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::all();
        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hari' => 'required',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'foto_guru' => 'nullable|image',
        ]);

        if ($request->hasFile('foto_guru')) {
            $data['foto_guru'] = $request->file('foto_guru')->store('foto_guru', 'public');
        }

        Jadwal::create($data);
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

        $data = $request->validate([
            'hari' => 'required',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'foto_guru' => 'nullable|image',
        ]);

        if ($request->hasFile('foto_guru')) {
            $data['foto_guru'] = $request->file('foto_guru')->store('foto_guru', 'public');
        }

        $jadwal->update($data);
        return redirect()->route('admin.jadwal.hari', $jadwal->hari)->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function perhari($hari)
    {
        $hari = strtolower($hari);
        $jadwalHari = Jadwal::where('hari', $hari)->get();

        return view('admin.jadwal.perhari', compact('hari', 'jadwalHari'));
    }
}
