<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Control;

class GenSettingsController extends Controller
{
    public function edit()
    {
        $control = Control::first(); // hanya ada 1 data
        return view('dashboard.control', compact('control'));
    }

    public function update(Request $request, $id)
    {
        $control = Control::findOrFail($id);

        $control->harga = $request->harga;
        $control->tanggal_mulai = $request->tanggal_mulai;
        $control->tanggal_berakhir = $request->tanggal_berakhir;
        $control->biaya_lain = $request->biaya_lain;
        $control->is_active = $request->has('is_active');
        $control->save();

        return redirect()->route('dashboard.control')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
