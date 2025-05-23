<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nis;
use App\Models\Tiket;
use Illuminate\Support\Facades\Crypt;


class SiswaController extends Controller
{
    public function search(Request $request)
    {
        
        $query = $request->input('query');
        if (strlen($query)<3) {
            return response()->json([]);
        }

        $search = Nis::where('nis', 'LIKE', "%{$query}%")
            ->orWhere('nama_siswa', 'LIKE', "%{$query}%")
            ->select('nis', 'nama_siswa', 'kelas')
            ->get();
        return response()->json($search);

        
    }

    public function verify(Request $request)
{
    $query = $request->input('query');

    // Minimal panjang query 3 karakter
    if (strlen($query) < 3) {
        return response()->json([
            'status' => 'error',
            'message' => 'Query terlalu pendek.'
        ]);
    }

    // Cari data tiket berdasarkan nomor telepon
    $search = Tiket::where('phone', $query)
        ->select(['nis', 'nama', 'kelas', 'status'])
        ->first();

    if (!$search) {
        return response()->json([
            'status' => 'error',
            'message' => 'Nomor tidak ditemukan.'
        ]);
    }

    // Cek apakah siswa sudah polling
    $nisData = Nis::where('nis', $search->nis)->first();
    if ($nisData && $nisData->sudah_polling == 1) {
        return response()->json([
            'status' => 'error',
            'message' => 'Siswa sudah melakukan polling.'
        ]);
    }

    // Enkripsi NIS hanya jika semua pengecekan lolos
    $search->nis = Crypt::encryptString($search->nis);

    return response()->json($search);
}
}
