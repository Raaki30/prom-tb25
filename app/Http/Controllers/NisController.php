<?php

namespace App\Http\Controllers;

use App\Models\Nis;
use Illuminate\Http\Request;

class NISController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->perPage ?? 10;
        $data = Nis::when($search, function ($query, $search) {
                    $query->where('nis', 'like', "%$search%")
                          ->orWhere('nama_siswa', 'like', "%$search%")
                          ->orWhere('kelas', 'like', "%$search%");
                })
                ->orderBy('kelas')
                ->paginate($perPage);

        return view('dashboard.siswa', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:nis,nis',
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'sudah_beli' => 'required|boolean',
        ]);

        Nis::create($request->all());

        return redirect()->route('dashboard.siswa')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $siswa = Nis::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:nis,nis,' . $siswa->id,
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'sudah_beli' => 'required|boolean',
        ]);

        $siswa->update($request->all());

        return redirect()->route('dashboard.siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Nis::findOrFail($id);
        $siswa->delete();

        return redirect()->route('dashboard.siswa')->with('success', 'Data siswa berhasil dihapus.');
    }
}
